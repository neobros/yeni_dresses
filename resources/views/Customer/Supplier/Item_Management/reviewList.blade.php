@extends('Customer.Supplier.head')
@section('content')

<div class="wrapper">
    @include('Customer.Supplier.header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Review List</h3>
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
                        <a href="/seller/itemManagement/reviewList">Review List</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
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
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Total Reviews</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach($groupedReviews as $itemId => $itemReviews)
                                        <tr>
                                            <td>{{ $itemId }}</td>
                                            <td>{{ $itemReviews[0]->item_name }}</td>
                                            <td>{{ count($itemReviews) }}</td>
                                            <td>
                                                <button class="btn btn-success" data-toggle="modal" data-target="#reviewModal" 
                                                    data-item-id="{{ $itemId }}" 
                                                    data-item-name="{{ $itemReviews[0]->item_name }}"
                                                    data-reviews="{{ json_encode($itemReviews) }}">
                                                    See Reviews
                                                </button>
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
    
    <!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Item Reviews</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 id="item-name"></h6>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Rating</th>
                            <th>Content</th>
                            <th>Helpful</th>
                            <th>Unhelpful</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody id="review-details">
                        <!-- Reviews will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $('#reviewModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var itemName = button.data('item-name');
        var reviews = button.data('reviews');
        
        $('#reviewModalLabel').text('Reviews for ' + itemName);
        $('#review-details').html('');
        
        console.log("clicked")
        reviews.forEach(function(review) {
            $('#review-details').append(`
                <tr>
                    <td>${review.user_name}</td>
                    <td>${review.review_rating}</td>
                    <td>${review.review_content}</td>
                    <td>${review.helpful_count}</td>
                    <td>${review.unhelpful_count}</td>
                    <td>${review.review_created_at}</td>
                </tr>
            `);
        });
    });
</script>
@endsection

