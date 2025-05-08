<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateVipStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        $user_id = $event->order->user_id;

        $totalSpent = DB::table('tbl_order')
            ->where('user_id', $user_id)  // Lọc đơn hàng theo user_id
            ->sum('order_total');  // Tính tổng tiền của tất cả các đơn hàng

        $isVip = $totalSpent > 5000000 ? 1 : 0;
        Users::where('user_id', $user_id)->update(['user_vip' => $isVip]);
    }
}
