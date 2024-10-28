<?php

namespace App\Models\Catalogs;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SubjectFormat extends Model
{
    public $table = 'subject_formats';
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
