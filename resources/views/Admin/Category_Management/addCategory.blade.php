@extends('Admin.head')
@section('content')

    <div class="wrapper">

    @include('Admin.header')
    
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Add Category</h3>
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
                  <a href="#">Category Management</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/categoryManagement/addCategory">Category Add</a>
                </li>
              </ul>
            </div>


            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <form method="POST" action="/admin/categoryManagement/storeCategory">
                    @csrf
                      <div class="card-header">
                        <div class="card-title">Add Category</div>
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
                            <div class="form-group">
                              <label for="exampleFormControlSelect1">Select Main Category</label>
                              <div class="col-md-9 p-0">
                                <select  name="mainCategory"  class="form-select" id="exampleFormControlSelect1">
                                  <option value="Womens">Women's</option>
                                  <option value="Mens">Men's</option>
                                  <option value="WearingItems">Wearing Items</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Sub Category Name</label>
                              <div class="col-md-9 p-0">
                                <input type="text" name="subCategory" class="form-control input-full" required placeholder="Enter Sub Category Name">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-action">
                        <button class="btn btn-success">Submit</button>          
                      </div>
                    </div>
                 </form>
              </div>
            </div>




            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Category Details</h4>
                  </div>
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

   