@extends('Customer.Supplier.head')
@section('content')

    <div class="wrapper">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('Customer.Supplier.header')
    
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Edit Item</h3>
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
                  <a href="#">Edit Item</a>
                </li>
              </ul>
            </div>


            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <form method="POST" action="/seller/itemManagement/updateItemDetails" enctype="multipart/form-data">
                    @csrf
                      <div class="card-header">
                        <div class="card-title">Update Item</div>
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
                          <input type="hidden" name="item_ID" value="{{$itemData->item_ID}}" class="form-control input-full" required>
<!-- 
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Select Main Category *</label>
                              <div class="col-md-9 p-0">
                                <select  name="mainCategory" class="form-select" id="mainCategory">
                                    <option selected value="">Select Main Category</option>
                                    <option value="Womens">Women's</option>
                                    <option value="Mens">Men's</option>
                                    <option value="WearingItems">Wearing Items</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Sub Category *</label>
                              <div class="col-md-9 p-0">
                                <select  name="category_ID" class="form-select" id="subCategory">                                 
                                </select>
                              </div>
                            </div> -->


                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Item Name *</label>
                              <div class="col-md-9 p-0">
                                <input type="text" name="name" value="{{$itemData->name}}" class="form-control input-full" required>
                              </div>
                            </div>


                            @php
                              $sizeData = json_decode($itemData->size, true);
                            @endphp    
                            


                            <div class="form-group form-inline">
                              <label class="col-md-3 col-form-label">Size</label>
                              <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                  <input  @if(in_array("S", $sizeData)) checked @endif  type="checkbox" name="sizeS" value="S" class="selectgroup-input">
                                  <span class="selectgroup-button">S</span>
                                </label>
                                <label class="selectgroup-item">
                                  <input @if(in_array("M", $sizeData)) checked @endif  type="checkbox" name="sizeM" value="M" class="selectgroup-input">
                                  <span class="selectgroup-button">M</span>
                                </label>
                                <label class="selectgroup-item">
                                  <input @if(in_array("L", $sizeData)) checked @endif  type="checkbox" name="sizeL" value="L" class="selectgroup-input">
                                  <span class="selectgroup-button">L</span>
                                </label>
                                <label class="selectgroup-item">
                                  <input @if(in_array("XL", $sizeData)) checked @endif  type="checkbox" name="sizeXL" value="XL" class="selectgroup-input">
                                  <span class="selectgroup-button">XL</span>
                                </label>
                              </div>
                            </div>
                        


                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Price *</label>
                              <div class="col-md-9 p-0">
                                <input type="number"  value="{{$itemData->price}}" name="price" class="form-control input-full" required>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Quantity *</label>
                              <div class="col-md-9 p-0">
                                <input type="number" name="quantity"  value="{{$itemData->quantity}}" class="form-control input-full" required>
                              </div>
                            </div>

                            <!-- <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Select Images *</label>
                              <div class="col-md-9 p-0">
                                 <input type="file" name="photo[]" id="photo" class="form-control-file" multiple required accept="image/*">
                              </div>
                            </div> -->

                            <div id="imagePreview" class="row mt-2"></div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Description *</label>
                              <div class="col-md-12 p-0">
                                <textarea  id="summernote" name="description" class="form-control input-full" >  {!! $itemData->description !!}</textarea>
                              </div>
                            </div>


                          <!-- <div class="form-group form-inline">
                          <label class="col-md-3 col-form-label">Color Input</label>
                          <div class="row gutters-xs">
                            <div class="col-auto">
                              <label class="colorinput">
                                <input name="color" type="checkbox" value="dark" class="colorinput-input">
                                <span class="colorinput-color bg-black"></span>
                              </label>
                            </div>
                            <div class="col-auto">
                              <label class="colorinput">
                                <input name="color" type="checkbox" value="primary" class="colorinput-input">
                                <span class="colorinput-color bg-primary"></span>
                              </label>
                            </div>
                            <div class="col-auto">
                              <label class="colorinput">
                                <input name="color" type="checkbox" value="secondary" class="colorinput-input">
                                <span class="colorinput-color bg-secondary"></span>
                              </label>
                            </div>
                            <div class="col-auto">
                              <label class="colorinput">
                                <input name="color" type="checkbox" value="info" class="colorinput-input">
                                <span class="colorinput-color bg-info"></span>
                              </label>
                            </div>
                            <div class="col-auto">
                              <label class="colorinput">
                                <input name="color" type="checkbox" value="success" class="colorinput-input">
                                <span class="colorinput-color bg-success"></span>
                              </label>
                            </div>
                            <div class="col-auto">
                              <label class="colorinput">
                                <input name="color" type="checkbox" value="danger" class="colorinput-input">
                                <span class="colorinput-color bg-danger"></span>
                              </label>
                            </div>
                            <div class="col-auto">
                              <label class="colorinput">
                                <input name="color" type="checkbox" value="warning" class="colorinput-input">
                                <span class="colorinput-color bg-warning"></span>
                              </label>
                            </div>
                          </div>
                        </div> -->

                          </div>
                        </div>
                      </div>
                      <div class="card-action">
                        <button type="submit" class="btn btn-success">Update</button>          
                      </div>
                    </div>
                 </form>
              </div>
            </div>    
          </div>
        </div>

        
<link rel="stylesheet" href="/summernote/summernote-lite.min.css">

<script src="/summernote/summernote-lite.min.js"></script>
<script>
    $('#summernote').summernote({
        tabsize: 2,
        height: 320,
    })
    

</script>


<script>
  $(document).ready(function() {
      $('#mainCategory').change(function() {
          var mainCategory = $(this).val();

          // AJAX request to the backend
          $.ajax({
              url: '/seller/itemManagement/getSubCategories',  // Your backend route
              type: 'GET',
              data: { category: mainCategory },
              success: function(response) {
                  // Clear the subcategory dropdown
                  $('#subCategory').empty();

                  // Add new options from the response data
                  // $('#subCategory').append('<option value="">Select Sub Category</option>');
                  $.each(response.subCategories, function(index, subCategory) {
                      $('#subCategory').append('<option value="'+subCategory.category_ID+'">'+subCategory.name+'</option>');
                  });
              },
              error: function(xhr, status, error) {
                  console.error("Error fetching subcategories: ", error);
              }
          });
      });
  });
</script>


<script>
$(document).ready(function() {
    // Max number of files allowed
    var maxFiles = 4;

    $('#photo').on('change', function() {
        var files = $(this)[0].files;
        var preview = $('#imagePreview');

        // Clear previous previews
        preview.empty();

        if (files.length > maxFiles) {
            alert("You can only upload a maximum of " + maxFiles + " images.");
            $(this).val(''); // Clear the file input
            return;
        }

        // Loop through selected files and show previews
        $.each(files, function(index, file) {
            if (index < maxFiles) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.append(`
                        <div class="col-md-3">
                            <img src="` + e.target.result + `" class="img-thumbnail mb-2" style="width: 100%; height: auto;">
                        </div>
                    `);
                }
                reader.readAsDataURL(file);
            }
        });
    });
});
</script>

<style>
    #imagePreview img {
        max-width: 100px;
        margin-right: 5px;
    }
</style>

@endsection

   