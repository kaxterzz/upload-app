<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnimtaImage extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'image';
    protected $primaryKey = 'idImage';
    public $timestamps = false;


}
