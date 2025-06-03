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

        // Filter orders by month and day
        $filter = $request->input('filter', 'month');
        $date = Carbon::now();

        if ($filter == 'month') {
            $startDate = $date->startOfMonth();
        } else {
            $startDate = $date->startOfDay();
        }

        $endDate = Carbon::now();

        return view('dashboard.home');
    }
}
