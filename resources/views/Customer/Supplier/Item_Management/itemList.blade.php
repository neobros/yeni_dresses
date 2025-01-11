@extends('Customer.Supplier.head')
@section('content')

    <div class="wrapper">

    @include('Customer.Supplier.header')
    
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Category List</h3>
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
                  <a href="/seller/itemManagement/itemList">Item List</a>
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
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Category</th>
                            <th></th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          @foreach($itemList as $key => $data )
                            <tr>
                              <td>{{++$key}}</td>
                              <td>{{$data->name}}</td>
                              <td>{{$data->price}}.00</td>
                              <td>{{$data->quantity}}</td>

                                <td> <span class="badge badge-primary">{{$data->category_type}}  => {{$data->category_name}}</span> </td>

                              <td>

                                <a href="/product/{{$data->item_ID}}" target="_blank"><button style="width: 130px; height: 35px"  class="btn btn-success">Watch add</button> </a>
                                <a href="/seller/itemManagement/updateItem/{{$data->item_ID}}"> <button style="width: 100px; height: 35px"  class="btn btn-info">Edit</button> </a>
                                <a href="/seller/deleteItem/{{$data->item_ID}}"> <button style="width: 100px; height: 35px"  class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete?')">Delete</button> </a>
                                          
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

   