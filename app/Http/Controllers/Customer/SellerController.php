<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer_seller;
use App\Models\Item;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use DB;
use \PDF;
use ChartjsNodeCanvas\ChartjsNodeCanvas;
use Carbon\Carbon;

class SellerController extends Controller
{
    public function sellerRegistration()
    {
      
        $categories = DB::table('category')->get();

        $cartData = null ;

        if(Auth::guard('customer')->check())  
        {

            $cartData = DB::table('cart')->join('item', 'cart.item_ID', '=', 'item.item_ID')->where('cart.user_ID' , Auth::guard('customer')->user()->id)->get();

        }

        return view('Customer.Supplier.sellerRegistration')->with([
            'categories'  =>  $categories, 
            'cartData'  =>  $cartData, 
        ]);
    }

    public function registrationAgreed()
    {
      
        $update = [
            'type' => 0,
        ];

        Customer_seller::where('id',Auth::guard('customer')->user()->id)->update($update);

        return redirect()->intended('/')->with('success', 'You became a seller.');
    }

    public function dashboard()
    {
        return view('Customer.Supplier.dashboard');
    }

    public function addItem()
    {
        return view('Customer.Supplier.Item_Management.addItem');
    }


    public function getSubCategories(Request $request)
    {  
        $mainCategory = $request->category;

        $subCategories = DB::table('category')->where('type',$mainCategory )->get();

        return response()->json(['subCategories' => $subCategories]);
    }


    public function storeItem(Request $request)
    {
        $request->validate([
            'category_ID'      => 'required',
            'price'      => 'required',
            'description'    => 'required',
            'name'      => 'required|string|max:255',
            'photo.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'photo' => 'required|array|min:4|min:4',
            'quantity' => 'required|numeric|min:1',

        ]);

        $size = [];

        if($request->sizeS !== null)
        {
            $size[] = $request->sizeS;
        }
        if($request->sizeM !== null)
        {
            $size[] = $request->sizeM;
        }
        if($request->sizeL !== null)
        {
            $size[] = $request->sizeL;
        }
        if($request->sizeXL !== null)
        {
            $size[] = $request->sizeXL;
        }
        $sizeJson = json_encode($size);


        try{
            $filenames = [];

            foreach ($request->file('photo') as $image) {
                $filename= date('YmdHi').$image->getClientOriginalName();
                $image->move(public_path().'/uploads/', $filename); 
                
                $filenames[] = $filename;
            }

            $filenamesJson = json_encode($filenames);

            $images = new Item([
                    'name' =>$request->name,
                    'seller_ID' => Auth::guard('customer')->user()->id,
                    'size' =>$sizeJson,
                    'price' =>$request->price,
                    'description' =>$request->description,
                    'category_ID' =>$request->category_ID,
                    'photo' =>$filenamesJson,
                    'quantity' =>$request->quantity,
                ]);

            $images->save();
            
            return redirect()
            ->back()
            ->with('success', 'New Item added successfully.');

        }
        catch(\Exception $error){
            return redirect()
            ->back()
            ->with('delete', 'Something goes wrong. Please try again.');
        }
    
    }


    public function itemList()
    {
        $itemList = DB::table('item')->join('category', 'item.category_ID', '=', 'category.category_ID')->where('seller_ID',Auth::guard('customer')->user()->id )
        ->select('item.*', 'category.name as category_name' , 'category.type as category_type' )->get();

        return view('Customer.Supplier.Item_Management.itemList')->with([
            'itemList'  =>  $itemList, 
        ]);
    }

    public function deleteItem($item_ID)
    {
        DB::delete('delete from item where item_ID = ?',[$item_ID]);

        return redirect()->back()->with('delete', 'Item Delete Successfully.');
    }


    public function orderList()
    {
        

        $orderData = DB::table('order')->join('item', 'order.item_ID', '=', 'item.item_ID')->join('payment', 'order.payment_ID', '=', 'payment.payment_ID')
        ->where('item.seller_ID' , Auth::guard('customer')->user()->id)
        ->select('order.*', 'item.*', 'order.quantity as orderQuantity')->get();


        return view('Customer.Supplier.Order_Management.orderList')->with([
            'orderData'  =>  $orderData, 
        ]);
    }

    

    public function updateItem($item_ID)
    {
        $itemData = DB::table('item')->join('category', 'item.category_ID', '=', 'category.category_ID')->where('seller_ID',Auth::guard('customer')->user()->id )
        ->where('item_ID',$item_ID )
        ->select('item.*', 'category.name as category_name' , 'category.type as category_type' )->first();

        return view('Customer.Supplier.Item_Management.updateItem')->with([
            'itemData'  =>  $itemData, 
        ]);
    }

    public function updateItemDetails(Request $request)
    {
        $request->validate([
            'price'      => 'required',
            'description'    => 'required',
            'name'      => 'required|string|max:255',
            'quantity' => 'required|numeric|min:1',

        ]);

        $size = [];

        if($request->sizeS !== null)
        {
            $size[] = $request->sizeS;
        }
        if($request->sizeM !== null)
        {
            $size[] = $request->sizeM;
        }
        if($request->sizeL !== null)
        {
            $size[] = $request->sizeL;
        }
        if($request->sizeXL !== null)
        {
            $size[] = $request->sizeXL;
        }
        $sizeJson = json_encode($size);


        try{
        

            $update = [
                'name' =>$request->name,  
                'size' =>$sizeJson,
                'price' =>$request->price,
                'description' =>$request->description,
                'quantity' =>$request->quantity,
            ];
    
            Item::where('item_ID',$request->item_ID)->update($update);

            return redirect()
            ->back()
            ->with('success', 'Item Updated successfully.');

        }
        catch(\Exception $error){
            dd( $error);
            return redirect()
            ->back()
            ->with('delete', 'Something goes wrong. Please try again.');
        }
    
    }

    public function inquiries()
    {
        $inquiryList = DB::table('inquiries')
            ->join('customer_seller', 'inquiries.user_id', '=', 'customer_seller.id') 
            ->join('item', 'inquiries.item_id', '=', 'item.item_ID') 
            ->select(
                'inquiries.id as inquiry_id',
                'inquiries.message as inquiry_message',
                'inquiries.reply as inquiry_reply',
                'inquiries.replied_at',
                'inquiries.created_at as inquiry_created_at',
                'customer_seller.id as user_id',
                'customer_seller.name as user_name',
                'customer_seller.email as user_email',
                'item.item_ID as item_id',
                'item.name as item_name',
                'item.description as item_description'
            )
            ->where('item.seller_ID', Auth::guard('customer')->user()->id)
            ->get();

        return view('Customer.Supplier.Item_Management.inquiryList', compact('inquiryList'));
    }
    
    public function saveReply(Request $request)
    {
        try {
            $request->validate([
                'inquiry_id' => 'required|exists:inquiries,id',
                'reply' => 'required|string|max:500',
            ]);

            $inquiry = Inquiry::find($request->inquiry_id);
            if (!$inquiry) {
                return response()->json(['success' => false, 'message' => 'Inquiry not found.'], 404);
            }

            $inquiry->reply = $request->reply;
            $inquiry->replied_at = now();
            $inquiry->save();

            return response()->json(['success' => true, 'message' => 'Reply saved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function reviews()
    {
        $reviews = DB::table('reviews')
            ->join('customer_seller as customer', 'reviews.user_id', '=', 'customer.id')
            ->join('customer_seller as seller', 'reviews.seller_id', '=', 'seller.id')
            ->join('item', 'reviews.item_id', '=', 'item.item_ID')
            ->select(
                'reviews.id as review_id',
                'reviews.rating as review_rating',
                'reviews.content as review_content',
                'reviews.helpful_count',
                'reviews.unhelpful_count',
                'reviews.created_at as review_created_at',
                'reviews.updated_at as review_updated_at',
                'customer.id as user_id',
                'customer.name as user_name',
                'customer.email as user_email',
                'seller.id as seller_id',
                'seller.name as seller_name',
                'item.item_ID as item_id',
                'item.name as item_name',
                'item.description as item_description'
            )
            ->where('item.seller_ID', Auth::guard('customer')->user()->id)
            ->get();
    
        $groupedReviews = $reviews->groupBy('item_id');
    
        return view('Customer.Supplier.Item_Management.reviewList', compact('groupedReviews'));
    }

    public function mostDemandReport()
    {
        $ratingsData = Review::select('item_id', DB::raw('COUNT(*) as ratings_count'))
            ->groupBy('item_id')
            ->orderBy('ratings_count', 'desc')
            ->get();

        // Prepare the data for the chart
        $chartData = [
            'labels' => $ratingsData->map(function ($review) {
                return $review->item->name ?? 'Unknown Item'; // Ensure you have item names here
            }),
            'values' => $ratingsData->map(function ($review) {
                return $review->ratings_count;
            }),
        ];

        return view('Customer.Supplier.Item_Management.mostDemandReports', compact('ratingsData', 'chartData'));
    }
    public function leastDemandReport()
    {
        $ratingsData = Review::select('item_id', DB::raw('COUNT(*) as ratings_count'))
            ->groupBy('item_id')
            ->orderBy('ratings_count', 'asc')
            ->get();

        // Prepare the data for the chart
        $chartData = [
            'labels' => $ratingsData->map(function ($review) {
                return $review->item->name ?? 'Unknown Item'; // Ensure you have item names here
            }),
            'values' => $ratingsData->map(function ($review) {
                return $review->ratings_count;
            }),
        ];

        return view('Customer.Supplier.Item_Management.leastDemandReports', compact('ratingsData', 'chartData'));
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
    
        return view('Customer.Supplier.Item_Management.incomeReports', compact('chartData', 'totalIncome', 'startDate', 'endDate'));
    }
    
    private function prepareChartData($incomeData, $dateDiff)
    {
        // Group data by interval (week, month, day)
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
