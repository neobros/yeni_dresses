<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use DB;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    public function mostDemandReport(Request $request)
    {
        $startDate = $request->get('start_date') 
            ? Carbon::parse($request->get('start_date')) 
            : Carbon::now()->startOfMonth();

        $endDate = $request->get('end_date') 
            ? Carbon::parse($request->get('end_date')) 
            : Carbon::now();

        $ratingsData = Review::whereBetween('created_at', [$startDate, $endDate])
            ->select('item_id', DB::raw('COUNT(*) as ratings_count'))
            ->with(['item' => function ($query) {
                $query->select('item_ID', 'seller_ID', 'name')
                    ->with(['seller' => function ($subQuery) {
                        $subQuery->select('id', 'name');
                    }]);
            }])
            ->groupBy('item_id')
            ->orderBy('ratings_count', 'desc')
            ->get();

        $chartData = [
            'labels' => $ratingsData->map(fn($review) => $review->item->name ?? 'Unknown Item'),
            'values' => $ratingsData->map(fn($review) => $review->ratings_count),
        ];

        return view('Admin.Report_Management.mostDemandReports', compact('ratingsData', 'chartData', 'startDate', 'endDate'));
    }

    public function leastDemandReport()
    {
        $ratingsData = Review::select('item_id', DB::raw('COUNT(*) as ratings_count'))
        ->with(['item' => function ($query) {
            $query->select('item_ID', 'seller_ID', 'name')
                ->with(['seller' => function ($subQuery) {
                    $subQuery->select('id', 'name'); 
                }]);
        }])
            ->groupBy('item_id')
            ->orderBy('ratings_count', 'asc')
            ->get();

        $chartData = [
            'labels' => $ratingsData->map(function ($review) {
                return $review->item->name ?? 'Unknown Item'; 
            }),
            'values' => $ratingsData->map(function ($review) {
                return $review->ratings_count;
            }),
        ];

        return view('Admin.Report_Management.leastDemandReports', compact('ratingsData', 'chartData'));
    }
    public function incomeReport(Request $request)
    {
        $startDate = $request->start_date 
            ? Carbon::parse($request->start_date) 
            : Carbon::now()->startOfMonth();
    
        $endDate = $request->end_date 
            ? Carbon::parse($request->end_date) 
            : Carbon::now();
    
        $dateDiff = $startDate->diffInDays($endDate);
        
        $orders = Order::select('order.item_ID', 'order.created_at', DB::raw('SUM(order.quantity) as total_quantity'))
            ->whereBetween('order.date', [$startDate, $endDate])
            ->groupBy('order.item_ID', 'order.created_at')
            ->get();
        
        $items = Item::whereIn('item_ID', $orders->pluck('item_ID'))->get()->keyBy('item_ID');
    
        $incomeData = $orders->map(function ($order) use ($items) {
            if (isset($items[$order->item_ID])) {
                $item = $items[$order->item_ID];
                return [
                    'item_name' => $item->name,
                    'income' => $order->total_quantity * $item->price,
                    'date' => $order->created_at->format('Y-m-d'),
                ];
            } else {
                return [
                    'item_name' => 'Unknown',
                    'income' => 0,
                    'date' => $order->created_at->format('Y-m-d'),
                ];
            }
        });
    
        $totalIncome = $incomeData->sum('income');
        $chartData = $this->prepareChartData($incomeData, $dateDiff);
    
        return view('Admin.Report_Management.incomeReports', compact('chartData', 'totalIncome', 'startDate', 'endDate'));
    }

    private function prepareChartData($incomeData, $dateDiff)
    {
        $dataGrouped = collect($incomeData)->groupBy(function ($item) use ($dateDiff) {
            $date = Carbon::parse($item['date']);
            return $date->startOfDay()->timestamp; 
        });
    
        $labels = $dataGrouped->keys()->map(function ($key) {
            return Carbon::createFromTimestamp($key)->format('Y-m-d');
        });
    
        $values = $dataGrouped->map(function ($items) {
            return $items->sum('income');
        });
    
        return [
            'labels' => $labels->toArray(),
            'values' => $values->values()->toArray(), 
        ];
    }
}
