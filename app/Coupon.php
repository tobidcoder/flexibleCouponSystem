<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    public $table = 'coupons';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable =
            [
                'name',
                'min_price',
                'min_items',
                'discount_type',
                'discount_amount',
                'discount_percentage',
                'currency_symbol',
            ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'min_price' => 'decimal:2',
        'min_items' => 'integer',
        'discount_type' => 'string',
        'discount_amount' => 'decimal:2',
        'discount_percentage' => 'integer',
        'currency_symbol' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:coupons',
        'min_price' => 'nullable',
        'min_items' => 'nullable',
        'discount_type' => 'nullable',
        'discount_amount' => 'nullable',
        'discount_percentage' => 'nullable',
        'currency_symbol' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
