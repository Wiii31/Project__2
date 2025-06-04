<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Announcement;

class C_Klien extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();

        $orders = Order::with(['package', 'date'])
                       ->where('client_id', $userId)
                       ->orderBy('created_at', 'desc')
                       ->get();

        $announcements = Announcement::orderBy('created_at', 'desc')->limit(5)->get();

        return view('klien.v_dashboard-klien', compact('orders', 'announcements'));
    }
}
