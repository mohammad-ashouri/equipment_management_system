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

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type', 'id');
    }

    public function personnelInfo()
    {
        return $this->belongsTo(Personnel::class, 'personnel', 'id');
    }

    protected static function booted()
    {
        static::created(function ($equipment) {
            $data = [
                'status' => 'created',
                'personnel' => $equipment->personnel,
                'property_code' => $equipment->property_code,
                'delivery_date' => $equipment->delivery_date,
                'info' => $equipment->info,
            ];
            ChangeHistory::create([
                'equipment_id' => $equipment->id,
                'new' => json_encode($data),
                'user' => auth()->user()->id,
                'updated_at' => now(),
            ]);
        });
        static::updating(function ($equipment) {
            // گرفتن داده‌های اصلی قبل از تغییر
            $originalData = $equipment->getOriginal();
            unset($originalData['id'], $originalData['personnel'], $originalData['equipment_type'], $originalData['adder'], $originalData['editor'], $originalData['created_at'], $originalData['updated_at']);

            // حذف فیلدهای اضافی از JSON اصلی
            $originalInfo = json_decode($originalData['info'], true);
            unset($originalInfo['equipmentId']);
            $originalData['info'] = json_encode($originalInfo);

            // گرفتن تغییرات جدید
            $changedData = $equipment->getDirty();
            $changedInfo = json_decode($changedData['info'], true);
            unset($changedInfo['description'], $changedInfo['equipmentId']);
            $changedData['info'] = json_encode($changedInfo);

            // تبدیل JSON ها به آرایه برای مقایسه
            $original = json_decode($originalData['info'], true);
            $changes = json_decode($changedData['info'], true);

            // مقایسه برای یافتن داده‌های جدید، ویرایش‌شده و حذف‌شده
            $addedParts = array_diff_key($changes, $original); // قطعات جدید
            $deletedParts = array_diff_key($original, $changes); // قطعات حذف‌شده
            $modifiedParts = [];

            // بررسی تغییرات در قطعات
            foreach ($original as $key => $value) {
                if (isset($changes[$key]) && $changes[$key] != $value) {
                    $modifiedParts[$key] = [
                        'from' => $value,
                        'to' => $changes[$key]
                    ];
                }
            }

            // ذخیره‌سازی تغییرات در تاریخچه
            ChangeHistory::create([
                'equipment_id' => $equipment->id,
                'new' => json_encode($addedParts),
                'edit' => json_encode($modifiedParts),
                'delete' => json_encode($deletedParts),
                'user' => auth()->user()->id,
                'updated_at' => now(),
            ]);
        });
    }
}
