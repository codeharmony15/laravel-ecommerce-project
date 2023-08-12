<!DOCTYPE html>
<html lang="en">
  <head>
@include('admin.css')
<style>
.center{
    margin :auto;
    width:80%;
    text-align: center;
    margin-top:30px;
    border:3px solid white;

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
    padding-left: 40px;
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

<h2 class="h2_font"> All Products </h2> 
   <tr class="th_color">
<th >Product title</th>
<th>Description</th>
<th>Quantity</th>
<th>Catagory</th>
<th>Price</th>
<th>Discount price</th>
<th>Product Image</th>
<th>Delete</th>
<th>Update</th>
   </tr>
   @foreach($product as $product)
   <tr>
    <td>{{$product->tilte}}</td>
    <td>{{$product->descrition}}</td>
    <td>{{$product->quantity}}</td>
    <td>{{$product->catagory}}</td>
    <td>{{$product->price}}</td>
    <td>{{$product->discount_price}}</td>
    <td>
        <img class="img_size" src="/product/{{$product->image}}">
    </td>
 
<td><a onclick="return confirm('Are you sure to delete this')" class="btn btn-danger" 
href="{{url('delete_product',$product->id)}}">Delete<a></td>

<td><a  class="btn btn-success" 
href="{{url('update_product',$product->id)}}">Update<a></td>

   
   </tr>

   @endforeach
</table>

          </div>
        </div>


    <!-- container-scroller -->
    <!-- plugins:js -->
@include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>