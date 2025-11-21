<?php

namespace App\Http\Controllers;

use App\Models\TransOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private function getFilteredOrders(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        return TransOrder::with('customer', 'transOrderDetails.typeOfService', 'transLaundryPickups')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('order_date', [$startDate, $endDate])
                    ->orWhereBetween('order_end_date', [$startDate, $endDate]);
            })
            ->get();
    }
    public function index(Request $request)
    {
        // Ambil tanggal dari request, default awal bulan sampai hari ini
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Pastikan format tanggal valid (jika gagal, pakai default)
        try {
            $startDate = Carbon::parse($startDate)->format('Y-m-d');
            $endDate = Carbon::parse($endDate)->format('Y-m-d');
        } catch (\Exception $e) {
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
        }

        // Ambil data order sesuai filter tanggal
        $orders = TransOrder::with('customer', 'transOrderDetails.typeOfService')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->get();

        // Statistik
        $totalRevenue = $orders->where('order_status', 1)->sum('total');
        $totalOrders = $orders->count();
        $completedOrders = $orders->where('order_status', 1)->count();
        $pendingOrders = $orders->where('order_status', 0)->count();

        // Kirim ke view
        return view('reports.index', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'startDate',
            'endDate'
        ));
    }

    public function print(Request $request)
    {
        $orders = $this->getFilteredOrders($request);

        $totalRevenue = $orders->where('order_status', 1)->sum('total');
        $totalOrders = $orders->count();
        $completedOrders = $orders->where('order_status', 1)->count();
        $pendingOrders = $orders->where('order_status', 0)->count();

        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Tampilkan view print tanpa tombol/filter dan dengan style khusus
        return view('reports.print', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'startDate',
            'endDate'
        ));
    }
}
