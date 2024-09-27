<?php

namespace App\Models;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use ModelRelations;

    protected $table = 'equipments';
    protected $fillable = [
        'personnel', 'equipment_type', 'property_code', 'delivery_date', 'info', 'description', 'status', 'adder', 'editor'
    ];


    protected static function booted()
    {
        static::updating(function ($equipment) {
            $originalData = $equipment->getOriginal();
            unset($originalData['id'],
                $originalData['personnel'],
                $originalData['equipment_type'],
                $originalData['property_code'],
                $originalData['adder'],
                $originalData['editor'],
                $originalData['created_at'],
                $originalData['updated_at']
            );
            $info = json_decode($originalData['info'], true);
            unset($info['equipmentId']);
            $originalData['info'] = json_encode($info);

            $changes = $equipment->getDirty();
            $info = json_decode($changes['info'], true);
            unset($info['description'], $info['equipmentId']);
            $changes['info'] = json_encode($info);

            $original = json_decode($originalData['info'], true);
            $changes = json_decode($changes['info'], true);

            function recursiveArrayDiff($array1, $array2)
            {
                $result = [];

                foreach ($array1 as $key => $value) {
                    if (array_key_exists($key, $array2)) {
                        if (is_array($value) && is_array($array2[$key])) {
                            $diff = recursiveArrayDiff($value, $array2[$key]);

                            $addedItems = array_diff($array2[$key], $value);
                            $removedItems = array_diff($value, $array2[$key]);

                            if (!empty($diff) || !empty($addedItems) || !empty($removedItems)) {
                                $result[$key] = [
                                    'added' => !empty($addedItems) ? $addedItems : null,
                                    'removed' => !empty($removedItems) ? $removedItems : null,
                                    'modified' => !empty($diff) ? $diff : null,
                                ];
                            }
                        } else {
                            if ($value != $array2[$key]) {
                                $result[$key] = [
                                    'original' => $value,
                                    'changed' => $array2[$key]
                                ];
                            }
                        }
                    } else {
                        $result[$key] = [
                            'original' => $value,
                            'changed' => null
                        ];
                    }
                }

                foreach ($array2 as $key => $value) {
                    if (!array_key_exists($key, $array1)) {
                        $result[$key] = [
                            'original' => null,
                            'changed' => $value
                        ];
                    }
                }

                return $result;
            }

            $differences = recursiveArrayDiff($original, $changes);

            if (!empty($differences)) {
                ChangeHistory::create([
                    'equipment_id' => $equipment->id,
                    'changes' => json_encode($differences),
                    'user' => auth()->user()->id,
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
