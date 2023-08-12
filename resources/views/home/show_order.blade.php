<!DOCTYPE html>
<html>
   <head>



      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="home/images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />


      <style type="text/css">
.div_center
{

text-align: center;
padding-top: 40px ;
}
h2{
    padding-top: 30px ;
    width:50%;
   
}
.input_color{
    color:black;
}
.center{
    margin :auto;
    width:100%;
    text-align: center;
    padding: 30px;
  
}
table,th,td{
    border :1px solid grey;
    
}
.th_deg{

  font-size: 20px;  
  padding: 5px;
  background: skyblue;
}

.img_deg{
height: 10px;
width: 10px;

}
</style>
   </head>
   <body>
      <div class="hero_area">


         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->

         @if(session() -> has ('message'))

<div class="alert alert-success"  >
    <button type ="button" class = "close" data-dismiss=alert
    aria-hidden="true">x</button>

    {{session()->get('message')}}
</div>

@endif


      <div class="center">
        <table>
            <tr>
                <th class="th_deg">Name</th>
                <th class="th_deg">Email </th>
                <th class="th_deg">Phone</th>
            
                <th class="th_deg">Product title</th>
                <th class="th_deg">Price</th>
                <th class="th_deg">Quantity</th>
                <th class="th_deg">Image</th>
                <th class="th_deg">Product id</th>
                <th class="th_deg">Payment status</th>
                <th class="th_deg">delivery status</th>
                <th class="th_deg">cancel oreder</th>
            </tr>

          

            @foreach($order as $order) 
             <tr>
             <td style="padding:10px;">{{$order->name}}</td>

    <td style="padding:10px;">{{$order->email}}</td>
    <td style="padding:10px;">{{$order->phone}}</td>

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
    <a class="btn btn-danger"  onclick="return confirm('Are you sure to cancel this order ?')" 
                href="{{url('cancel_order' ,$order->id)}}" >
                    cancel_order </a> 
    @else
    <p style="color : blue;">Not Allow</p>      
    @endif          
    </td>
             </tr>

                   
            @endforeach

        </table>
        <div>
          
        
        </div>

        <div><br>

          
        </div>
</div>

      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
      </div>
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="js/custom.js"></script>
   </body>
</html>