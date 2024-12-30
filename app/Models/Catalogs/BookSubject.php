<?php

namespace App\Models\Catalogs;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class BookSubject extends Model
{
    use ModelRelations;

    protected $table = 'book_subjects';
    protected $fillable = [
        'name', 'status', 'address', 'adder', 'editor'
    ];
}
