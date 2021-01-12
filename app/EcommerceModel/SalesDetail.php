<?php

namespace App\EcommerceModel;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesDetail extends Model
{
    use SoftDeletes;

    protected $table = 'ecommerce_sales_details';
    protected $fillable = ['sales_header_id', 'product_id', 'product_name', 'product_category', 'price', 'tax_amount', 'promo_id', 'promo_description', 'discount_amount', 'gross_amount', 'net_amount', 'qty', 'uom', 'created_by'
];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function product()
    {
        return $this->belongsTo('\App\EcommerceModel\Product');
    }

    public function header()
    {
        return $this->belongsTo('\App\EcommerceModel\SalesHeader', 'sales_header_id');
    }

    public function category()
    {
        return $this->belongsTo('\App\ProductCategory','product_category');
    }

    public function getItemTotalPriceAttribute()
    {
        return $this->product->price;
    }

}
