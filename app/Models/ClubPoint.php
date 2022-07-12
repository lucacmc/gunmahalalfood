<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ClubPoint extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function getUserPoint()
    {
        if (Auth::user()->id) {
            $user_point = ClubPoint::where('user_id', Auth::user()->id)->where('convert_status', 0)->sum('points');
        } else {
            $user_point = 0;
        }
        return $user_point;
    }
}
