<?php

namespace App\EcommerceModel;

use App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use SoftDeletes;

    protected $table = 'ecommerce_product_review';
    protected $fillable = ['product_id', 'user_id','review','rating'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo('App\EcommerceModel\Product');
    }
}
