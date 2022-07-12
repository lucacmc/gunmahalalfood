<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class ShippingSlot extends Model
{
    public static function getAvaiableSlots()
    {
        $slots = ShippingSlot::where('status', 1)->orderBy('position', 'ASC')->get();
        return $slots;
    }

    public static function checkShippingDate($date)
    {
        $max = get_setting('shipping_max_slot');
        $count = Order::where('shipping_time', 'like', '%' . $date . '%')->count();
        return $count < $max;
    }
}
