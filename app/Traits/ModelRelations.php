<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Catalogs\Brand;

trait ModelRelations
{
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
