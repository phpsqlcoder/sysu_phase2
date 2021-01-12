<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deliverablecities extends Model
{
	use SoftDeletes;
    protected $table = 'deliverable_cities';
    protected $fillable = ['name', 'rate','user_id','status'];
    

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
