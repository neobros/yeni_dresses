@extends('Admin.head')
@section('content')

    <div class="wrapper">

    @include('Admin.header')
    
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
                <label for="exampleFormControlSelect1">Select Main Category</label>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/admin/categoryManagement/categoryList">Category List</a>
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
                            <th>Type</th>
                            <th></th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          @foreach($categoryList as $key => $data )
                            <tr>
                              <td>{{++$key}}</td>
                              <td>{{$data->name}}</td>

                              @if($data->type == 'Womens')
                                <td> <span class="badge badge-primary">Women's</span> </td>
                              @elseif($data->type == 'Mens')
                                <td> <span class="badge badge-primary">Men's</span> </td>
                              @else
                                <td> <span class="badge badge-primary">Wearing Items</span> </td>
                              @endif

                              <td>

                                <a href="/admin/deleteCategory/{{$data->category_ID}}"> <button style="width: 100px; height: 35px"  class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete?')">Delete</button> </a>
                                          
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

   