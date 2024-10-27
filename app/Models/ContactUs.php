<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use SoftDeletes;

    protected $table = 'contact_us';
    protected $connection = 'contact_us';

    public function editorInfo()
    {
        return $this->belongsTo(User::class, 'editor', 'id');
    }
}
