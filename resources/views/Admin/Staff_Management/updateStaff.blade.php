@extends('Admin.head')
@section('content')

    <div class="wrapper">

    @include('Admin.header')
    
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Edit Staff Details</h3>
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
                  <a href="#">Edit Staff Details</a>
                </li>
              </ul>
            </div>


            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <form method="POST" action="/admin/staffManagement/updateStaffDetails">
                    @csrf
                      <div class="card-header">
                        <div class="card-title">Update Details</div>
                      </div>

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
                        <div class="row">
                          <div class="col-md-12">                    
                          <input type="hidden" name="id" value="{{$userData->id }}" class="form-control input-full" required>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">User Name *</label>
                              <div class="col-md-9 p-0">
                                <input type="text" name="name" value="{{$userData->name }}" class="form-control input-full" required>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">User email *</label>
                              <div class="col-md-9 p-0">
                                <input type="email" name="email" readonly value="{{$userData->email }}" class="form-control input-full" required>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">User NIC *</label>
                              <div class="col-md-9 p-0">
                                <input type="text" name="nic" value="{{$userData->nic }}" class="form-control input-full" required>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">User Phone Number *</label>
                              <div class="col-md-9 p-0">
                                <input type="number" name="phone" value="{{$userData->phone }}" class="form-control input-full" required>
                              </div>
                            </div>


                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">User Address *</label>
                              <div class="col-md-9 p-0">
                                <input type="text" name="address" value="{{$userData->address }}" class="form-control input-full" required>
                              </div>
                            </div>
                      

                            <!-- <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Staff Member Password *</label>
                              <div class="col-md-9 p-0">
                                <input type="password" name="password" class="form-control input-full" required>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Staff Member Confirm Password *</label>
                              <div class="col-md-9 p-0">
                                <input type="password" name="password_confirmation" class="form-control input-full" required>
                              </div>
                            </div> -->


                          </div>
                        </div>
                      </div>
                      <div class="card-action">
                        <button class="btn btn-success">Update</button>          
                      </div>
                    </div>
                 </form>
              </div>
            </div>    
          </div>
        </div>

@endsection

   