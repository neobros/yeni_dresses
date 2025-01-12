<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Delivery;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function productPage($item_ID)
    {
        // Update the click count
        $this->updateItemCount($item_ID);

        $categories = DB::table('category')->get();
        $itemDetails = DB::table('item')->join('category', 'item.category_ID', '=', 'category.category_ID')->where('item_ID' , $item_ID)
        ->select('item.*', 'category.name as category_name' , 'category.type as category_type' )->first();

        $cartDetails = null ;
        $cartData = null ;
        $inquiryDetails = collect();
        $reviews = collect();

        if(Auth::guard('customer')->check())  
        {
            $cartDetails = DB::table('cart')->where('item_ID' , $item_ID)->where('user_ID' , Auth::guard('customer')->user()->id)->get();

            $cartData = DB::table('cart')->join('item', 'cart.item_ID', '=', 'item.item_ID')->where('cart.user_ID' , Auth::guard('customer')->user()->id)->get();

            $inquiryDetails = DB::table('inquiries')
            ->where('item_id', $item_ID)
            ->where('user_id', Auth::guard('customer')->user()->id)
            ->get();
        }
      
        $reviews = DB::table('reviews')
            ->where('item_id', $item_ID)
            ->orderBy('created_at', 'desc')
            ->get();

            $highRateProducts = DB::table('item')
            ->leftJoin('reviews', 'item.item_ID', '=', 'reviews.item_id')
            ->select(
                'item.*',
                DB::raw('COUNT(reviews.id) as reviews_count'),
                DB::raw('COALESCE(AVG(reviews.rating), 0) as rating_percentage')
            )
            ->groupBy('item.item_ID') // Group by product ID to calculate aggregates
            ->orderBy('item.click_count', 'desc') // Sort by click count
            ->take(10) // Limit to top 10
            ->get();
            // dd("highRateProducts",$highRateProducts);

        return view('Customer.product')->with([
            'categories'  =>  $categories, 
            'itemDetails'  =>  $itemDetails, 
            'cartDetails'  =>  $cartDetails, 
            'cartData'  =>  $cartData,
            'inquiryDetails' => $inquiryDetails,
            'reviews' => $reviews, 
            'highRateProducts' => $highRateProducts,
        ]);
    }

    public function updateItemCount($item_ID)
    {
        // Increment the click count for the item
        DB::table('item')
            ->where('item_ID', $item_ID)
            ->increment('click_count');
    }


    public function addToCart(Request $request)
    {

        $data = new Cart([
            'item_ID' =>$request->item_ID,
            'user_ID' => Auth::guard('customer')->user()->id,  
            'size' =>$request->size,
            'quantity' =>$request->quantity,
        ]);

        $data->save();
    
        return response()->json([
            'success' => 1,
            'message' => 'Item added to your cart successfully!',
        ]);
        

    }


    public function viewCart()
    {
        $categories = DB::table('category')->get();
        $totalPrice = DB::table('cart')
        ->join('item', 'cart.item_ID', '=', 'item.item_ID')
        ->where('cart.user_ID', Auth::guard('customer')->user()->id)
        ->select(DB::raw('SUM(cart.quantity * item.price) as totalPrice')) // Calculate total price
        ->value('totalPrice'); // Get the final value directly

        $cartData = DB::table('cart')->join('item', 'cart.item_ID', '=', 'item.item_ID')->where('cart.user_ID' , Auth::guard('customer')->user()->id)
        ->select('cart.*', 'item.*', 'cart.size as cartSize' , 'cart.quantity as cartQuantity' , 'item.quantity as itemQuantity' )->get();



        return view('Customer.viewCart')->with([
            'categories'  =>  $categories, 
            'cartData'  =>  $cartData, 
            'totalPrice'  =>  $totalPrice, 
        ]);
    }


    public function deleteCartItems($cart_ID)
    {
        DB::delete('delete from cart where cart_ID = ?',[$cart_ID]);

        return redirect()->back()->with('success', 'Item Delete Successfully.');
    }

    public function updateCartSize(Request $request)
    {
        $update = [
            'size' => $request->selectedSize,
        ];

        Cart::where('cart_ID',$request->cart_ID)->update($update);

        $totalPrice = DB::table('cart')
        ->join('item', 'cart.item_ID', '=', 'item.item_ID')
        ->where('cart.user_ID', Auth::guard('customer')->user()->id)
        ->select(DB::raw('SUM(cart.quantity * item.price) as totalPrice')) // Calculate total price
        ->value('totalPrice'); // Get the final value directly
    

        return response()->json([
            'success' => 1,
            'message' => 'update successfully!',
            'data' =>  $totalPrice,
        ]);

    }

    public function updateQuantity(Request $request)
    {
        $update = [
            'quantity' => $request->quantity,
        ];

        Cart::where('cart_ID',$request->cart_ID)->update($update);

        $totalPrice = DB::table('cart')
        ->join('item', 'cart.item_ID', '=', 'item.item_ID')
        ->where('cart.user_ID', Auth::guard('customer')->user()->id)
        ->select(DB::raw('SUM(cart.quantity * item.price) as totalPrice')) // Calculate total price
        ->value('totalPrice'); // Get the final value directly
    

        return response()->json([
            'success' => 1,
            'message' => 'update successfully!',
            'data' => $totalPrice ,
        ]);

    }

    public function checkout(Request $request)
    {

        $totalPrice = DB::table('cart')
        ->join('item', 'cart.item_ID', '=', 'item.item_ID')
        ->where('cart.user_ID', Auth::guard('customer')->user()->id)
        ->select(DB::raw('SUM(cart.quantity * item.price) as totalPrice')) // Calculate total price
        ->value('totalPrice'); // Get the final value directly

              
        return view('Customer.checkout')->with([
            'totalPrice'  =>  $totalPrice, 
            'shippingType'  =>  $request->shipping, 
        ]);
    }

    public function pay(Request $request)
    {

        $totalPrice = DB::table('cart')
        ->join('item', 'cart.item_ID', '=', 'item.item_ID')
        ->where('cart.user_ID', Auth::guard('customer')->user()->id)
        ->select(DB::raw('SUM(cart.quantity * item.price) as totalPrice')) // Calculate total price
        ->value('totalPrice'); // Get the final value directly

        $data = new Payment([
            'amount' => $totalPrice ,  
            'date' => today(),
        ]);

        $data->save();

        $dataDelivery = new Delivery([
            'type' => $request->shippingType,  
            'address' => Auth::guard('customer')->user()->address,
            'date' => today(),
        ]);

        $dataDelivery->save();

        $cartData = DB::table('cart')->join('item', 'cart.item_ID', '=', 'item.item_ID')->where('cart.user_ID' , Auth::guard('customer')->user()->id)
        ->select('cart.*', 'item.*', 'cart.size as cartSize' , 'cart.quantity as cartQuantity')->get();

        foreach( $cartData as  $cartItems)
        {
            $dataOrder= new Order([
                'order_status' => 1 ,  
                'user_ID' => Auth::guard('customer')->user()->id,
                'item_ID' => $cartItems->item_ID ,  
                'payment_ID' => $data->payment_ID ,  
                'delivery_ID' =>$dataDelivery->delivery_ID ,  
                'quantity' => $cartItems->cartQuantity , 
                'size' => $cartItems->cartSize , 
                'date' => today(),
            ]);
    
            $dataOrder->save();
        }
        DB::delete('delete from cart where user_ID = ?',[Auth::guard('customer')->user()->id]);

      
        return redirect("/")->with('success', 'Item Purchase Successfully.');
    }
    
    public function inquiryStore(Request $request, $id)
    {
        if (!Auth::guard('customer')->check()) {
            return response()->json(['error' => 'You must be logged in to submit an inquiry.'], 400);
        }
    
        $request->validate([
            'message' => 'required|string',
        ]);
    
        // Create the inquiry
        $inquiry = Inquiry::create([
            'user_id' => Auth::guard('customer')->user()->id,
            'item_id' => $id,
            'message' => $request->message,
        ]);
    
        return response()->json([
            'message' => $inquiry->message,
            'created_at' => $inquiry->created_at->format('F j, Y, g:i a'),
        ]);
    }

    public function storeReview(Request $request, $item_ID, $seller_ID)
    {
        if (!Auth::guard('customer')->check()) {
            return response()->json(['error' => 'You must be logged in to submit a review.'], 400);
        }
    
        $request->validate([
            'rating' => 'required|integer',
            'review' => 'required|string',
        ]);
    
        // Create the review
        $review = Review::create([
            'user_id' => Auth::guard('customer')->user()->id,
            'user_name' => Auth::guard('customer')->user()->name, // Use authenticated user's name
            'seller_id' => $seller_ID,
            'item_id' => $item_ID,
            'rating' => $request->rating,
            'content' => $request->review, // Map the correct field
        ]);
    
        return response()->json([
            'username' => $review->username,
            'rating' => $review->rating,
            'review' => $review->content,
            'created_at' => $review->created_at->format('F j, Y, g:i a'),
        ]);
    }

    public function addToWishlist(Request $request)
    {

        $userId = Auth::guard('customer')->user()->id;

        $existingWishlist = Wishlist::where('user_ID', $userId)
            ->where('item_ID', $request->item_ID)
            ->first();

        if ($existingWishlist) {
            return response()->json([
                'success' => 0,
                'message' => 'Item is already in your wishlist.',
            ]);
        }

        $data = new Wishlist([
            'item_ID' => $request->item_ID,
            'user_ID' => $userId,
        ]);

        $data->save();

        return response()->json([
            'success' => 1,
            'message' => 'Item added to wishlist successfully!',
        ]);
    }

    
    public function viewWishList()
    {
     $user = Auth::guard('customer')->user(); 

     $wishlistItems = Wishlist::where('user_ID', $user->id)->get();
     $wishlistCount = Wishlist::where('user_ID', $user->id)->count();
 
     $wishlistItemDetails = [];
 
     foreach ($wishlistItems as $wishlistItem) {
         $itemDetails = Item::where('item_ID', $wishlistItem->item_ID)->first(); 
 
         if ($itemDetails) {
             $wishlistItemDetails[] = $itemDetails; 
         }
     }
     
     $categories = DB::table('category')->get();
     $cartData = null ;

     if(Auth::guard('customer')->check())  
     {

         $cartData = DB::table('cart')->join('item', 'cart.item_ID', '=', 'item.item_ID')->where('cart.user_ID' , Auth::guard('customer')->user()->id)->get();

     }

        return view('Customer.viewWishList')->with([
            'wishlistItemDetails' => $wishlistItemDetails,
            'wishlistCount' => $wishlistCount,
            'categories'  =>  $categories,
            'cartData'  =>  $cartData, 
        ]);
    }

    public function removeWishlistItems($item_ID)
    {
        $user = Auth::guard('customer')->user(); 

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to remove items from your wishlist.');
        }

        $deleted = Wishlist::where('user_ID', $user->id)
            ->where('item_ID', $item_ID)
            ->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Item removed successfully from your wishlist.');
        }

        return redirect()->back()->with('error', 'Failed to remove the item. Please try again.');
    }

    public function showCategory($category_slug)
    {
        $categories = DB::table('category')->get();
        $categoryName = Str::title(str_replace('-', ' ', $category_slug));

        $items = DB::table('item')
            ->join('category', 'item.category_ID', '=', 'category.category_ID')
            ->leftJoin('reviews', 'item.item_ID', '=', 'reviews.item_id')
            ->select(
                'item.*', 
                'category.name as category_name', 
                'category.type as category_type',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('AVG(reviews.rating) as avg_rating')
            )
            ->where('category.name', $categoryName)
            ->groupBy('item.item_ID')
            ->orderByDesc('review_count') 
            ->paginate(9);

        return view('Customer.shop.shopItems')->with([
            'categories' => $categories,
            'items' => $items,
            'categoryName' => $categoryName,
        ]);
    }

}
