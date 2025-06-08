<?php

namespace App\Http\Controllers;

use view;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

use Illuminate\Foundation\Auth\User;


class HomeController extends Controller
{
    public function show()
    {
        return view('cust.dashboard');

    }

    public function admin()
    {
        return view('admin.dashboard');
    }

    public function about()
    {
        return view('cust.about');
    }

    public function terms()
    {
        return view('cust.term');
    }

    public function Privacy()
    {
        return view('cust.Privacy');
    }

    public function faq()
    {
        return view('cust.faq');
    }

    public function showTotalOrders()
    { 
        // Get the total count of orders
        $totalOrder = Order::count();
        $TotalEarnings = DB::table('total_penjualan')->value('total_sales');
        $totalActiveUsers = User::whereNotNull('id')->count();
        $totalQtySold = DB::table('total_sepatu_terjual')->value('total_qty_sold');

        $inventory = DB::table('products as p')
            ->join('variants as v', 'v.product_id', '=', 'p.id')
            ->select('p.name as product_name', DB::raw('SUM(v.stock) as total_stock'))
            ->groupBy('p.id', 'p.name')
            ->orderBy('p.name')
            ->get();

        $topProducts = DB::table('TOP_3_PRODUCT')->get();

        return view('admin.dashboard', ['totalOrder' => $totalOrder, 'TotalEarnings'=> $TotalEarnings, 'totalActiveUsers' => $totalActiveUsers, 'totalQtySold' => $totalQtySold, 'inventory' => $inventory, 'topProducts' => $topProducts]);
    }

    public function showDashboard()
{
    // Panggil fungsi showTotalOrders
    $totalOrder = Order::count();
    $TotalEarnings = DB::table('total_penjualan')->value('total_sales');
    $totalActiveUsers = User::whereNotNull('id')->count();
    $totalQtySold = DB::table('total_sepatu_terjual')->value('total_qty_sold');

    $inventory = DB::table('products as p')
        ->join('variants as v', 'v.product_id', '=', 'p.id')
        ->select('p.name as product_name', DB::raw('SUM(v.stock) as total_stock'))
        ->groupBy('p.id', 'p.name')
        ->orderBy('p.name')
        ->get();

  $topProducts = DB::table('TOP_3_PRODUCT as t3p')
    ->leftJoin(DB::raw('
        (SELECT product_id, MIN(url) as url FROM images GROUP BY product_id) as img
    '), 'img.product_id', '=', 't3p.id')
    ->select('t3p.*', 'img.url as image_url')
    ->get();
//    foreach ($topProducts as $product) {
// dd($product);
// }
    
    //code untuk chart
        // Ambil tahun-tahun yang tersedia di tabel orders
$availableYears = DB::table('orders')
    ->select(DB::raw('YEAR(date) as year'))
    ->distinct()
    ->orderBy('year', 'desc')
    ->pluck('year');

// Tahun yang dipilih (default: tahun sekarang, bisa dari query string)
$selectedYear = request()->get('year', now()->year);

// Ambil data total penjualan dan total qty per bulan
$salesTrends = DB::table('orders')
    ->selectRaw('MONTH(date) as month, SUM(total_price) as total_revenue, SUM(total_qty) as total_qty')
    ->whereYear('date', $selectedYear)
    ->groupByRaw('MONTH(date)')
    ->orderBy('month')
    ->get();

    // Siapkan array 12 bulan dengan default 0
$monthlyRevenue = array_fill(1, 12, 0);
$monthlyQty = array_fill(1, 12, 0);

// Isi data sesuai hasil query
foreach ($salesTrends as $trend) {
    $monthlyRevenue[$trend->month] = (float) $trend->total_revenue;
    $monthlyQty[$trend->month] = (int) $trend->total_qty;
}

    //end chart


    // Panggil fungsi show() untuk mengecek role pengguna
    // $userRole = Auth()->user()->role;

        // Mendapatkan role pengguna dari session
    $userRole = session('user_role');

    // Cek jika tidak ada role dalam session
    if (!$userRole) {
        // Menangani jika tidak ada role dalam session (misalnya redirect atau fallback)
        return redirect()->route('login'); // Mengarahkan pengguna ke halaman login jika session role tidak ditemukan
    }

    // Mengarahkan berdasarkan role
    if ($userRole === 'Admin') {
        return view('admin.dashboard', [
            'totalOrder' => $totalOrder,
            'TotalEarnings' => $TotalEarnings,
            'totalActiveUsers' => $totalActiveUsers,
            'totalQtySold' => $totalQtySold,
            'inventory' => $inventory,
            'topProducts' => $topProducts,
            'salesTrends' => $salesTrends,
'selectedYear' => $selectedYear,
'availableYears' => $availableYears,
'monthlyRevenue' => array_values($monthlyRevenue),
'monthlyQty' => array_values($monthlyQty)
        ]);
    } elseif ($userRole === 'Customer') {
        return view('cust.dashboard', [
            'totalOrder' => $totalOrder,
            'TotalEarnings' => $TotalEarnings,
            'totalActiveUsers' => $totalActiveUsers,
            'totalQtySold' => $totalQtySold,
            'inventory' => $inventory,
            'topProducts' => $topProducts,
            'salesTrends' => $salesTrends,
'selectedYear' => $selectedYear,
'availableYears' => $availableYears,
'monthlyRevenue' => array_values($monthlyRevenue),
'monthlyQty' => array_values($monthlyQty)
        ]);
    }

    // Jika role tidak dikenali, kembalikan view default (misal guest)
    return view('guest.dashboard', [
        'totalOrder' => $totalOrder,
        'TotalEarnings' => $TotalEarnings,
        'totalActiveUsers' => $totalActiveUsers,
        'totalQtySold' => $totalQtySold,
        'inventory' => $inventory,
        'topProducts' => $topProducts,
        'salesTrends' => $salesTrends,
'selectedYear' => $selectedYear,
'availableYears' => $availableYears,
'monthlyRevenue' => array_values($monthlyRevenue),
'monthlyQty' => array_values($monthlyQty)
    ]);
}



}
