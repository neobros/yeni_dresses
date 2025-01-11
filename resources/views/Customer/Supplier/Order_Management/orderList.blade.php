@extends('Customer.Supplier.head')
@section('content')

    <div class="wrapper">

    @include('Customer.Supplier.header')
    
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Order List</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                <a href="#">Item Management</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/seller/categoryManagement/orderList">Order List</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <!-- <div class="card-header">
                    <h4 class="card-title">Basic</h4>
                  </div> -->

                  @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <strong>{{ \Session::get('success') }}</strong>
                    </div>
                    @endif
                    @if (\Session::has('delete'))
                    <div class="alert alert-danger">
                        <strong>{{ \Session::get('delete') }}</strong>
                    </div>
                    @endif
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="basic-datatables"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <!-- <th>Price</th> -->
                            <th>Delevery Type</th>
                            <th></th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          @foreach($orderData as $key => $data )
                            <tr>
                                    @php
                                        $orderItemCart = json_decode($data->photo, true);
                                    @endphp

                              <td>{{++$key}}</td>
                              <td>{{$data->name}}</td>

                              <td>
                                  <figure class="product-media">
                                        <a href="#">
                                            <img style="width: 12%;" src="{{ asset('uploads/' . $orderItemCart[0]) }}" alt="Product image">
                                        </a>
                                  </figure>
                              </td>

                              <td>{{$data->quantity}}</td>
                              <!-- <td>{{$data->price}}.00</td> -->
                          
                                    @if($data->order_status == 1)
                                      <td> <span class="badge badge-primary">Free Shipping</span> </td>
                                    @else
                                     <td> <span class="badge badge-success">Take Away</span> </td>
                                    @endif
          

                              <td>

                                <a href="#"> <button style="width: 110px; height: 35px"  class="btn btn-success">More</button> </a>
                                <!-- <a href="#"> <button style="width: 100px; height: 35px"  class="btn btn-info">Edit</button> </a>
                                <a href="/seller/deleteItem/{{$data->item_ID}}"> <button style="width: 100px; height: 35px"  class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete?')">Delete</button> </a> -->
                                          
                              </td>


                            </tr>  
                          @endforeach      
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

          

           
            </div>
          </div>
        </div>

@endsection

   