<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnimtaCustomers extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'customer';
    protected $primaryKey = 'idCustomer';
    public $timestamps = false;
}
