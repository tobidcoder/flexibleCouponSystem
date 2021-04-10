<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{


    /**
     * Validate coupon code.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCoupon(Request $request){

        $input = $request->all();

        $validate = Validator::make($input,
            [
                'coupon_code' => 'required|string',
                'items_no' => 'required|integer',
                'cart_total_price' => 'required|integer',
            ]);
        if($validate->fails()){
            return $this->sendError($validate->errors());
        }

        $coupon = Coupon::where('name','coupon_code')->first();

        if(empty($coupon)){
            return $this->sendError('Coupon code does not exit');
        }

        //Check if coupon has minimum price.
        if($coupon->min_price > 0.00) {
            //Check if cart total price is greater than coupon minimum price.
            if($request->cart_total_price <= $coupon->min_price) {
                return $this->sendError('Your total cart price must be greater than '.$coupon->min_price.'');
            }
        }
        //Check if coupon has minimum items
        if($coupon->min_items > 0) {
            //Check if coupon minimum items is equal or greater than items numbers
            if ($request->items_no < $coupon->min_items) {
                return $this->sendError('Your cart items must be a minimum of '.$coupon->min_items.'');
            }
        }

        //fixed,percentage,both,greater
        //Check if coupon type if fixed
        if($coupon->discount_type === 'fixed'){
            //remove the discount price from cart total price
            $amount_discount = $coupon->discount_amount;
            $amount_remain = $request->cart_total_price - $amount_discount;
        }

        //Check if coupon type is percentage
        if($coupon->discount_type === 'percentage'){
            //remove the percentage discount of coupon from cart total price
            $amount_discount = ($coupon->discount_percentage / 100) * $request->cart_total_price;
            $amount_remain = $request->cart_total_price - $amount_discount;
        }

        //Check if coupon type both
        if($coupon->discount_type === 'both'){
            //remove both percentage discount and fixed amount discount from cart total price
            $fixed_amount_discount = $coupon->discount_amount;
            $percentage_amount_discount = ($coupon->discount_percentage / 100) * $request->cart_total_price;

            //Add both percentage and fixed amount discount together
            $amount_discount = $fixed_amount_discount + $percentage_amount_discount;

            $amount_remain = $request->cart_total_price - $amount_discount;
        }

        //Check if coupon type is greater
        if($coupon->discount_type === 'greater'){
            //remove both percentage discount or fixed amount discount from cart total price
            $fixed_amount_discount = $coupon->discount_amount;
            $percentage_amount_discount = ($coupon->discount_percentage / 100) * $request->cart_total_price;

            //compare and used the highest discount amount
            if($fixed_amount_discount > $percentage_amount_discount) {
                $amount_discount = $fixed_amount_discount;
                $amount_remain = $request->cart_total_price - $fixed_amount_discount;
            }
            if($percentage_amount_discount > $fixed_amount_discount) {
                $amount_discount = $percentage_amount_discount;
                $amount_remain = $request->cart_total_price - $percentage_amount_discount;
            }

        }

        $data=[];
        $data['amount_discount']  = $amount_discount;
        $data['amount_remain'] = $amount_remain;

        return $this->sendResponse($data, 'Discount for '.$request->coupon_code.' applied successfully');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }
}
