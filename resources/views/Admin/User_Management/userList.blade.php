@extends('Admin.head')
@section('content')

    <div class="wrapper">

    @include('Admin.header')
    
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">User List</h3>
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
                  <a href="#">User Management</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/admin/userManagement/userList">User List</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <!-- <div class="card-header">
                    <h4 class="card-title">Basic</h4>
                  </div> -->
                  <div class="card-body">

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
                    
                    <div class="table-responsive">
                      <table
                        id="basic-datatables"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Nic</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Type</th>
                            <th></th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          @foreach($userList as $key => $data )
                            <tr>
                              <td>{{++$key}}</td>
                              <td>{{$data->name}}</td>
                              <td>{{$data->email}}</td>
                              <td>{{$data->nic}}</td>
                              <td>{{$data->phone}}</td>
                              <td>{{$data->address}}</td>

                            @if($data->type == 1)
                              <td> <span class="badge badge-success">Buyer only</span> </td>
                            @else
                              <td> <span class="badge badge-primary">Buyer & Seller</span> </td>
                            @endif

                            <td>
                              
                              <a href="/admin/userManagement/user_update/{{$data->id}}"> <button style="width: 80px; height: 35px"  class="btn btn-info">Info</button> </a>

                              <a href="/admin/userManagement/user_delete/{{$data->id}}"> <button style="width: 80px; height: 35px"  class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete?')">Delete</button> </a>
                                        
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

   