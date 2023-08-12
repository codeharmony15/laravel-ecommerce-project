
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
<h1> Order Details </h1>

 
    NAME :<h3 style="padding:10px;">{{$order->name}}</h3>
    Phone :<h3 style="padding:10px;">{{$order->phone}}</h3>
    Email :<h3 style="padding:10px;">{{$order->email}}</h3>
    Address :<h3 style="padding:10px;">{{$order->address}}</h3>
    User ID :<h3 style="padding:10px;">{{$order->user_id}}</h3>
    Product Titel :<h3 style="padding:10px;">{{$order->product_title}}</h3>
    Price :<h3 style="padding:10px;">{{$order->Price}}</h3>
    Quantity :<h3 style="padding:10px;">{{$order->quantity}}</h3>

        <img class="img_size" src="/product/{{$order->image}}">

    Product ID<h3 style="padding:10px;">{{$order->product_id}}</h3>
    Payment_status :<h3 style="padding:10px;">{{$order->payment_status}}</h3>
    Delivery_status :<h3 style="padding:10px;">{{$order->delivery_status}}</h3>
 
    



