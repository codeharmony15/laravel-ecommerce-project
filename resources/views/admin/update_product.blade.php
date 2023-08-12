<!DOCTYPE html>
<html lang="en">
  <head>

    <base href="/public">
    
@include('admin.css')

<style type="text/css">
.div_center
{

text-align: center;
padding-top: 40px ;
}
.font_size{
    font-size: 40px ;
    padding-bottom: 40px ;
}
.text_color{
    color:black;
}
label{
    display: inline-block;
    width: 200px;
}
.div_design{
    padding-bottom: 15px;
}
.center{
    margin :auto;
    width:50%;
    text-align: center;
    margin-top:30px;
    border:3px solid white;
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

<div class="div_center">

<h1 class="font_size"> Update Products </h1> 

<form action="{{url('/update_product_confirm', $product->id)}}" method="post" enctype="multipart/form-data" >

@csrf 

<div class="div_design">
<label>Product Title : </label>
<input type="text" class="text_color" name="title" 
placeholder="Write Title" required="" value="{{$product->tilte}}">
</div>

<div class="div_design">
<label>Product description : </label>
<input type="text" class="text_color" name="description" 
placeholder="Write Description" required="" value="{{$product->descrition}}" >
</div>

<div class="div_design">
<label>Product price : </label>
<input type="number" class="text_color" name="price"
 placeholder="Write price"required="" value="{{$product->price}}">
</div>

<div class="div_design">
<label>discount price : </label>
<input type="number" class="text_color" name="discount_price"
 placeholder="Write discount price " value="{{$product->discount_price}}" >
</div>

<div class="div_design">
<label>Product quantity : </label>
<input type="number" min="0" class="text_color"
 name="quantity" placeholder="Write quantity" required="" value="{{$product->quantity}}">
</div>

<div class="div_design">
<label>Product Catagory: </label>
<select class="text_color" name="catagory" required="" >
    <option value="{{$product->catagory}}" > {{$product->catagory}}</option>
    @foreach($catagory as $catagory )
    <option>{{$catagory->catagory_name}}</option>
    @endforeach
</select>
</div>

<div class="div_design">
<label>Current Product image  : </label>
<img style="margin:auto;" height="100" width="100" src="/product/{{$product->image}}">
</div>

<div class="div_design">
<label>Change Product image  : </label>
<input type="file"  name="image" required="" >
</div>


<div class="div_design"> 

<input type="submit" value="Update Product" class="btn btn-primary">
</div>

</form>
</div>










           </div>
        </div>


    <!-- container-scroller -->
    <!-- plugins:js -->
@include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>