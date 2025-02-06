<?php
namespace App\Http\Controllers\dashboard\site;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\ServiceOrder;
use App\Models\ServiceView;
use App\Models\Service;
use App\Models\App\DeviceUser;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $subscribers = Subscriber::all(); // Retrieve all subscribers
        $totalOrders = ServiceOrder::count(); // Total number of orders
        $totalViews = ServiceView::count(); // Total number of views
        $services = Service::count(); // Total number of services
        $deviceOrders = DeviceUser::select('device_type', DB::raw('count(*) as total'))
            ->groupBy('device_type')
            ->get(); // Orders by device type
        $orders = ServiceOrder::all(); // Retrieve all orders

        // Filter orders by month and day
        $filter = $request->input('filter', 'month');
        $date = Carbon::now();

        if ($filter == 'month') {
            $startDate = $date->startOfMonth();
        } else {
            $startDate = $date->startOfDay();
        }

        $endDate = Carbon::now();

        $topServices = ServiceOrder::select('service_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('service_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        $serviceNames = $topServices->map(function ($order) {
            return Service::find($order->service_id)->name;
        });

        // Calculate previous month's sales percentage
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $previousMonthSales = ServiceOrder::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();
        $currentMonthSales = ServiceOrder::whereBetween('created_at', [$startDate, $endDate])->count();
        $salesPercentage = $previousMonthSales > 0 ? ($currentMonthSales - $previousMonthSales) / $previousMonthSales * 100 : 0;

        return view('dashboard.home', compact('subscribers', 'totalOrders', 'totalViews', 'services', 'deviceOrders', 'orders', 'topServices', 'serviceNames', 'filter', 'salesPercentage'));
    }
}
