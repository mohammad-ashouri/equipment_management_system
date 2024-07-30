<?php

namespace App\Models\HardwareEquipments;

use App\Models\Catalogs\Brand;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $table = 'monitors';
    protected $fillable = [
        'model','size', 'brand', 'status', 'adder', 'editor'
    ];

    public function adderInfo()
    {
        return $this->belongsTo(User::class, 'adder', 'id');
    }

    public function editorInfo()
    {
        return $this->belongsTo(User::class, 'editor', 'id');
    }

    public function brandInfo()
    {
        return $this->belongsTo(Brand::class, 'brand', 'id');
    }
}
