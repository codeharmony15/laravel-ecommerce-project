<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catagory;
use App\Models\Product;
use App\Models\Order;
use PDF;
use Notification;
use App\Notifications\MyFirstNotification;

class AdminController extends Controller
{
    public function view_catagory()
   
    {
        $data=catagory::all();
        return view('admin.catagory' ,compact('data'));
    }

    public function add_catagory(Request $request)
    {
       $data =new catagory ;
       $data-> catagory_name= $request->catagory;
       $data ->save();
       return redirect()-> back()->with('message','Catagory Added Succesfuly');
     }

     public function delete_catagory($id)
     {
        $data=catagory::find($id);
        $data->delete();
        return redirect()->back()->with('message','Catagory Deleted Succesfuly');
     }

     public function view_product()
   
     {
         $catagory=catagory::all();
         return view('admin.product',compact('catagory'));
     }

     public function add_product(Request $request)
    {
       $product=new product ;
       $product-> tilte= $request->title;
       $product-> descrition= $request->description;
       $product-> price= $request->price ;
       $product-> discount_price= $request->discount_price;
       $product-> quantity= $request->quantity ;
       $product-> catagory= $request->catagory ;

       $image=$request->image;
       $imagename=time().'.'.$image->getClientOriginalExtension();
       $request->image->move('product',$imagename);
       $product->image=$imagename;

       $product ->save();
       return redirect()-> back()->with('message','product Added Succesfuly');
     }

     public function show_product()
   
     {
         $product=product::all();
         return view('admin.show_product',compact('product'));
     }

     public function delete_product($id)
     {
        $product=product::find($id);
        $product->delete();
        return redirect()->back()->with('message','product Deleted Succesfuly');
     }

     public function update_product($id)
     {
        $product=product::find($id);
        $catagory=catagory::all();
      
    
        return view('admin.update_product',compact('product'),compact('catagory'));
     }

     public function update_product_confirm(Request $request,$id)
     {
        $product=product::find($id);
       
       $product-> tilte= $request->title;
       $product-> descrition= $request->description;
       $product-> price= $request->price ;
       $product-> discount_price= $request->discount_price;
       $product-> quantity= $request->quantity ;
       $product-> catagory= $request->catagory ;

       $image=$request->image;
       $imagename=time().'.'.$image->getClientOriginalExtension();
       $request->image->move('product',$imagename);
       $product->image=$imagename;
       $product->save();
      
    
       return redirect()-> back()->with('message','product Updated Succesfuly');

     }

     public function view_order()
   
    {
        $order=order::all();
        return view('admin.view_order' ,compact('order'));
    }


    public function delivered($id){

      $order =order::find($id);
      $order->delivery_status="delivered";
      $order->payment_status="paid";
      $order->save();
      return redirect()-> back();
    }

    public function print_pdf($id){

         $order =order::find($id);

         $pdf=PDF::loadView('admin.pdf',compact('order'));
         return $pdf->download('order_details.pdf');
    }

    public function send_email($id){

      $order =order::find($id);
      return view('admin.email_info',compact('order'));

    }

    public function send_user_email(Request $request,$id){
      $order =order::find($id);
      $details = [
        'greeting'=> $request->greeting,
        'firstline'=> $request->firstline,
        'body'=> $request->body,
        'button'=> $request->button,
        'url'=> $request->url,
        'lastline'=> $request->lastline,
      ];

      Notification::send($order,new MyFirstNotification($details));


    }

    public function searchdata(Request $request){
      $searchText=$request->search;
      $order=order::where('name','LIKE',"%$searchText%")->
      orwhere('phone','LIKE',"%$searchText%")->
      orwhere('email','LIKE',"%$searchText%")->get();
      return view('admin.view_order',compact('order'));
    }

   
}
