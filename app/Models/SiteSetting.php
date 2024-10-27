<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public $table = 'site_settings';
    protected $fillable = [
        'option',
        'value',
        'editor',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function editorInfo()
    {
        return $this->belongsTo(User::class, 'editor', 'id');
    }
}
