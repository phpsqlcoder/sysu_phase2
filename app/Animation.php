<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animation extends Model
{
    protected $table = 'animations';
    protected $fillable = ['name', 'value'];

}
