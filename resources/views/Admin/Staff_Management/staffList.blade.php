@extends('Admin.head')
@section('content')

    <div class="wrapper">

    @include('Admin.header')
    
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Staff List</h3>
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
                <a href="#">Staff Management</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/admin/staffManagement/staffList">Staff List</a>
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
                            <th>Email</th>
                            <th>Nic</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Join Date</th>
                            <th></th>
                          </tr>
                        </thead>
                        
                        <tbody>
                        @foreach($staffList as $key => $data )
                            <tr>
                              <td>{{++$key}}</td>
                              <td>{{$data->name}}</td>
                              <td>{{$data->email}}</td>
                              <td>{{$data->nic}}</td>
                              <td>{{$data->phone}}</td>
                              <td>{{$data->address}}</td>
                              <td>{{$data->join_date}}</td>
                              <td>
                                
                                <a href="/admin/staffManagement/updateStaff/{{$data->id}}"> <button style="width: 80px; height: 35px"  class="btn btn-info">Edit</button> </a>

                                <a href="/admin/deleteStaff/{{$data->id}}"> <button style="width: 80px; height: 35px"  class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete?')">Delete</button> </a>
                                          
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

   