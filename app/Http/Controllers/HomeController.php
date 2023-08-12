<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Comments;
use App\Models\Reply;
use Session;
use Stripe;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function index()
    {
      if(Auth::id()) 
       {
        $product=Product::paginate(3);
        $comment=comments::orderby('id','desc')->get();
        $reply=reply::all();
        $id=Auth::user()->id ;
        $cartnum=cart::where('user_id','=',$id)->count();
        $ordernum=order::where('user_id','=',$id)->count();

        
        return view('home.userpage',compact('product','comment','reply','cartnum','ordernum'));}
        else{

         $product=Product::paginate(3);
         $comment=comments::orderby('id','desc')->get();
         $reply=reply::all();
         return view('home.userpage',compact('product','comment','reply'));

        }
    }
 
    public function redirect()
    {
    $usertype=Auth::user()->usertype;

    if($usertype=='1')
     {
      $total_product=product::all()->count();
      $total_order=order::all()->count();
      $total_user=user::all()->count();
      $order=order::all();
      $total_revenue=0;

      foreach($order as $order){
         $total_revenue = $total_revenue + $order->price *$order->quantity;
      }

      $total_deliverd=order ::where('delivery_status','=','delivered')->get()->count();
      $total_prossising=order ::where('delivery_status','=','processing')->get()->count();


        return view('admin.home',compact('total_product',
        'total_order','total_user','total_revenue','total_deliverd','total_prossising'));

     }
    else
     {
    
        $product=Product::paginate(3);
        $comment=comments::orderby('id','desc')->get();
        $reply=reply::all();
        $id=Auth::user()->id ;
        $cartnum=cart::where('user_id','=',$id)->count();
        $ordernum=order::where('user_id','=',$id)->count();
        return view('home.userpage',compact('product','comment','reply','cartnum','ordernum'));

     }
    }
    

    public function product_details($id)
    {
        $product=product::find($id);

        $id=Auth::user()->id ;
        $cartnum=cart::where('user_id','=',$id)->count();
        $ordernum=order::where('user_id','=',$id)->count();

        return view('home.product_details',compact('product','cartnum','ordernum'));
    }

    public function add_cart  (Request $request,$id)
    {
       if(Auth::id()) 
       {
      
            $user=Auth::user();
            $product=product::find($id);
            $userid=$user->id;

            $product_exist_id=cart::where('product_id','=',$id)
            ->where('user_id','=',$userid)->get('id')->first();

            if($product_exist_id)
            {
               $cart=cart::find($product_exist_id)->first();
               $quantity=$cart->quantity;
               $cart->quantity=$quantity + $request->quantity;
               $cart->price=$product->price*$cart->quantity;

               $cart->save();
               Alert::success('Product added Successfully','we have added your product to the cart');
               return redirect()->back();

            }
            else{
               $cart=new cart;
            $cart->name=$user->name;
            $cart->email=$user->email;
            $cart->phone=$user->phone;
            $cart->address=$user->address;
            $cart->user_id=$user->id;
            $cart->product_title = $product->tilte;
            $cart->quantity=$request->quantity;
            $cart->price=$product->price*$cart->quantity;
            $cart->image=$product->image;
            $cart->product_id=$product->id;
           
            $cart->save();
            Alert::success('Product added Successfully','we have added your product to the cart');

            return redirect()->back();

            }

            

       }
       else 
       {
        return redirect('login');
       }
    }



    public function show_cart()
    {
        if(Auth::id()) 
        {


        $id=Auth::user()->id ;
        $cart=cart::where('user_id','=',$id)->get();

        
        $cartnum=cart::where('user_id','=',$id)->count();
        $ordernum=order::where('user_id','=',$id)->count();
      
        return view ('home.showcart',compact('cart','cartnum','ordernum'));
        }
    else 
       {
        return redirect('login');
       }
    }

    public function remove_cart($id)
    {
       $cart=cart::find($id);
       $cart->delete();
       return redirect()->back();
    }


    public function cash_order(){
      $user=Auth::user();
      $userid=$user->id;
      $data=cart::where('user_id','=',$userid)->get();

      foreach($data as $data){
         $order=new order;

         $order->name=$data->name;
         $order->email=$data->email;
         $order->phone=$data->phone;
         $order->address=$data->address;
         $order->user_id=$data->user_id;
         $order->product_title=$data->product_title;
         $order->price=$data->price;
         $order->quantity=$data->quantity;
         $order->image=$data->image;
         $order->product_id=$data->product_id;
         
         $order->payment_status='cash on delivery';
         $order->delivery_status='processing';
         $order->save();

         $cart_id=$data->id;
         $cart=cart::find($cart_id);
         $cart->delete();





      }

      return redirect()->back()->with('message','we Received yor order . we will
      contact you soon');;





    }

    public function stripe($totalprice)
    {
      $id=Auth::user()->id ;
        $cartnum=cart::where('user_id','=',$id)->count();
        $ordernum=order::where('user_id','=',$id)->count();

return view('home.stripe',compact('totalprice','cartnum','ordernum'));
    }

    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks for payment ." 
        ]);

        $user=Auth::user();
        $userid=$user->id;
        $data=cart::where('user_id','=',$userid)->get();
  
        foreach($data as $data){
           $order=new order;
  
           $order->name=$data->name;
           $order->email=$data->email;
           $order->phone=$data->phone;
           $order->address=$data->address;
           $order->user_id=$data->user_id;
           $order->product_title=$data->product_title;
           $order->price=$data->price;
           $order->quantity=$data->quantity;
           $order->image=$data->image;
           $order->product_id=$data->product_id;
           
           $order->payment_status='paid';
           $order->delivery_status='processing';
           $order->save();
  
           $cart_id=$data->id;
           $cart=cart::find($cart_id);
           $cart->delete();

       }
      
        Session::flash('success', 'Payment successful!');
              
        return back();
    }

    public function show_order()
    {
        if(Auth::id()) 
        {
        $id=Auth::user() ->id ;
        $order=order::where('user_id','=',$id)->get();

        
        $cartnum=cart::where('user_id','=',$id)->count();
        $ordernum=order::where('user_id','=',$id)->count();

        return view ('home.show_order',compact('order','cartnum','ordernum'));
        }
    else 
       {
        return redirect('login');
       }
    }

    public function cancel_order($id)
    {
       $order=order::find($id);
       $order->delivery_status='you have cancel this order';
       $order->save();
       return redirect()->back();
    }

    public function add_comment(Request $request){
      if(Auth::id()){

         $comment=new comments;
         $comment->name=Auth::user()->name;
         $comment->user_id=Auth::user()->id;
         $comment->comment=$request->comment;
         $comment->save();
         return redirect()->back();
      }
      else{

         return redirect('login');
      }
    }

    public function add_reply(Request $request){
      if(Auth::id()){

         $reply=new reply;
         $reply->name=Auth::user()->name;
         $reply->comment_id=$request->commnetId;
         $reply->user_id=Auth::user()->id;
         $reply->reply=$request->reply;
         $reply->save();
         return redirect()->back();
      }
      else{

         return redirect('login');
      }
    }

    public function search_Product(Request $request){
        $comment=comments::orderby('id','desc')->get();
        $reply=reply::all();
      $searchText=$request->search;
      $product=product::where('tilte','LIKE',"%$searchText%")->
      orwhere('catagory','LIKE',"%$searchText%")->
      orwhere('price','LIKE',"%$searchText%")->paginate(3);

      $id=Auth::user()->id ;
        $cartnum=cart::where('user_id','=',$id)->count();
        $ordernum=order::where('user_id','=',$id)->count();

      return view('home.all_product',compact('product','comment','reply','cartnum','ordernum'));
    }



    public function products(){
      $product=Product::paginate(3);
      $comment=comments::orderby('id','desc')->get();
      $reply=reply::all();

      $id=Auth::user()->id ;
      $cartnum=cart::where('user_id','=',$id)->count();
      $ordernum=order::where('user_id','=',$id)->count();

      return view('home.all_product',compact('product','comment','reply','cartnum','ordernum'));
    }


    

}