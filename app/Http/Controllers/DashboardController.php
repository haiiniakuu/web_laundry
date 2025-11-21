<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\TransOrder;
use App\Models\TypeOfService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\JsonSchema\Types\Type;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalServices = TypeOfService::count();
        $totalOrders = TransOrder::count();
        $monthlyRevenue = TransOrder::where('order_status', 1)
            ->whereMonth('order_date', Carbon::now()->month)
            ->whereYear('order_date', Carbon::now()->year)
            ->sum('total');

        $latestOrders = TransOrder::with('customer')
            ->orderBy('order_date', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalCustomers',
            'totalServices',
            'totalOrders',
            'monthlyRevenue',
            'latestOrders'
        ));
    }
}
