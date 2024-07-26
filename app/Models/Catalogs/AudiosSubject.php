<?php

namespace App\Models\Catalogs;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AudiosSubject extends Model
{
    public $table = 'audios_subjects';
    protected $fillable = [
        'name','status','adder','editor'
    ];

    public function adderInfo()
    {
        return $this->belongsTo(User::class, 'adder', 'id');
    }

    public function editorInfo()
    {
        return $this->belongsTo(User::class, 'editor', 'id');
    }
}
