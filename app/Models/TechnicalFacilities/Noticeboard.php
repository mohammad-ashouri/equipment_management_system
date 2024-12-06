<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Noticeboard extends Model
{
    use ModelRelations;

    protected $table = 'noticeboards';
    protected $fillable = [
        'model', 'width', 'length', 'brand', 'status', 'adder', 'editor'
    ];
}
