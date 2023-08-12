<!DOCTYPE html>
<html lang="en">
  <head>
@include('admin.css')
<style>
.center{
    margin :auto;
    width:100%;
    text-align: center;
    margin-top:30px;
    border:3px solid white;
    font-size: 12px;
    font-weight:12px;

}
.h2_font{
    text-align: center;
    padding-top: 40px ;
    font-size: 40px ;
    padding-bottom: 40px ;
}
.img_size{
    width: 100px;
    height:100px;
    padding-top: 10px ;
    padding-left: 10px;
} 
.th_color{
    background: skyblue;
}

</style>

  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->

@include('admin.sidebar')

      <!-- partial -->

@include('admin.header')     

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">

          
          @if(session() -> has ('message'))

<div class="alert alert-success"  >
    <button type ="button" class = "close" data-dismiss=alert
    aria-hidden="true">x</button>

    {{session()->get('message')}}
</div>

@endif

<table class="center">

<h2 class="h2_font"> All Orders </h2> 

<div style =" padding-left:400px ;padding-bottom:30px;">
  <form action ="{{url('search')}}" method="get">
    @csrf
    <input style ="color: black" type="text" name="search" placeholder="search for something">
    <input type="submit" value="Search" class="btn btn-outline-primary">
  </form>
</div>



   <tr class="th_color">
 
<th style="padding:10px;">Name</th>
<th style="padding:10px;">Phone</th>
<th style="padding:10px;">Email</th>


<th style="padding:10px;">Product_title</th>
<th style="padding:10px;">Price</th>
<th style="padding:10px;">quantity</th>
<th style="padding:10px;">image</th>
<th style="padding:10px;">product_id</th>
<th style="padding:10px;">payment_status</th>
<th style="padding:10px;">delivery_status</th>

<th style="padding:10px;">Delivered</th>
<th style="padding:10px;">Print PDF</th>
<th style="padding:10px;">Send email</th>


   </tr>
   @forelse($order as $order)
   <tr>
 
    <td style="padding:10px;">{{$order->name}}</td>
    <td style="padding:10px;">{{$order->phone}}</td>
    <td style="padding:10px;">{{$order->email}}</td>

    <td style="padding:10px;">{{$order->product_title}}</td>
    <td style="padding:10px;">${{$order->price}}</td>
    <td style="padding:10px;">{{$order->quantity}}</td>
    <td>
        <img class="img_size" src="/product/{{$order->image}}">
    </td>
    <td style="padding:10px;">{{$order->product_id}}</td>
    <td style="padding:10px;">{{$order->payment_status}}</td>
    <td style="padding:10px;">{{$order->delivery_status}}</td>
 
    <td>
    @if($order->delivery_status=='processing')

<a class="btn btn-primary"  onclick="return confirm('Are you sure this product is delivered ')"
href="{{url('delivered',$order->id)}}">Delivered<a>

    @else
<p>Delivered</p>

    @endif  
    </td>

    <td>
      <a class="btn btn-secondary"  href="{{url('print_pdf',$order->id)}}">Print PDF<a>
    </td>

    <td>
      <a class="btn btn-info"  href="{{url('send_email',$order->id)}}">send email<a>
    </td>

   </tr>

   @empty

<tr>
  <td colspan="16">
    No Data Found
  </td>
</tr>

   @endforelse
</table>

          </div>
        </div>


    <!-- container-scroller -->
    <!-- plugins:js -->
@include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>