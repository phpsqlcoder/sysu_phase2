<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryReceiverHeader extends Model
{
    protected $table = 'inventory_receiver_header';
    protected $fillable = ['posted_at', 'posted_by', 'user_id', 'status', 'cancelled_at', 'cancelled_by'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function posted()
    {
        return $this->belongsTo('App\User','posted_by');
    }

    public function cancelled()
    {
        return $this->belongsTo('App\User','cancelled_by');
    }

    public function details()
    {
        return $this->hasMany('App\InventoryReceiverHeader', 'header_id', 'id');
    }
}
