<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function refund_requests()
    {
        return $this->hasMany(RefundRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->hasOne(Shop::class, 'user_id', 'seller_id');
    }

    public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    }

    public function affiliate_log()
    {
        return $this->hasMany(AffiliateLog::class);
    }

    public function club_point()
    {
        return $this->hasMany(ClubPoint::class);
    }

    public function delivery_boy()
    {
        return $this->belongsTo(User::class, 'assign_delivery_boy', 'id');
    }

    public function proxy_cart_reference_id()
    {
        return $this->hasMany(ProxyPayment::class)->select('reference_id');
    }

    public static function getTotalSale($type='today'){
        $total = 0;
        switch ($type){
            case 'year':
                $date = date("Y");
                $total = Order::whereRaw("DATE_FORMAT(created_at,'%Y') = '$date'")->count();
                break;
            case 'month':
                $date = date("Y-m");
                $total = Order::whereRaw("DATE_FORMAT(created_at,'%Y-%m') = '$date'")->count();
                break;
            case 'today':
                $date = date("Y-m-d");
                $total = Order::whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d') = '$date'")->count();
                break;
            default:
                $total = Order::count();
        }
        return $total;
    }

    public static function getTotalSaleAmount($type='today'){
        $total = 0;
        switch ($type){
            case 'year':
                $date = date("Y");
                $total = Order::whereRaw("DATE_FORMAT(created_at,'%Y') = '$date'")->sum('grand_total');
                break;
            case 'month':
                $date = date("Y-m");
                $total = Order::whereRaw("DATE_FORMAT(created_at,'%Y-%m') = '$date'")->sum('grand_total');
                break;
            case 'today':
                $date = date("Y-m-d");
                $total = Order::whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d') = '$date'")->sum('grand_total');
                break;
            default:
                $total = Order::sum('grand_total');
        }
        return single_price($total);
    }
}
