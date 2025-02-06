<?php
namespace App\Http\Controllers\dashboard\License;
use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function index()
    {
        return view('dashboard.reports.sales-report');
    }
    public function getSalesData(Request $request)
    {
        $start_date = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->subMonth();
        $end_date = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now();

        // 1. مبيعات خلال الفترة
        $sales = License::whereBetween('purchase_date', [$start_date, $end_date])
            ->join('programs', 'licenses.program_id', '=', 'programs.id')
            ->join('clients', 'licenses.client_id', '=', 'clients.id')  // إضافة جدول العملاء
            ->selectRaw('DATE(licenses.purchase_date) as date, COUNT(licenses.id) as sales_count, SUM(programs.price) as revenue, clients.name as client_name, clients.email as client_email')
            ->groupBy('date', 'clients.id' , 'client_name' , 'client_email') // إضافة تجميع حسب العميل
            ->orderBy('date', 'asc')
            ->get();

        // 2. آخر 5 مشتريات
        $last_purchases = License::with('program', 'client') // إضافة العلاقة مع العميل
            ->whereBetween('purchase_date', [$start_date, $end_date])
            ->orderBy('purchase_date', 'desc')
            ->limit(5)
            ->get();

        // 3. أفضل البرامج مبيعًا
        $top_selling_programs = License::join('programs', 'licenses.program_id', '=', 'programs.id')
            ->select('programs.name', DB::raw('COUNT(licenses.id) as sales_count'))
            ->groupBy('programs.name')
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();

        // 4. توزيع المبيعات حسب اليوم
        $sales_distribution = $sales->groupBy('date');

        // إضافة عدد مرات الشراء لكل عميل
        $client_purchase_counts = License::select('client_id', DB::raw('COUNT(*) as purchase_count'))
            ->whereBetween('purchase_date', [$start_date, $end_date])
            ->groupBy('client_id')
            ->get();

        return response()->json([
            'sales' => $sales,
            'last_purchases' => $last_purchases,
            'top_selling_programs' => $top_selling_programs,
            'sales_distribution' => $sales_distribution,
            'client_purchase_counts' => $client_purchase_counts // عدد مرات الشراء لكل عميل
        ]);
    }


}
