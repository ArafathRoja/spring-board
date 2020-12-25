<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Samples extends Model
{
    protected $table = "samples";

    protected $fillable = ['f_name', 'l_name', 'dob', 'address1', 'address2', 'country', 'state' , 'city', 'pincode', 'comments'];
}
