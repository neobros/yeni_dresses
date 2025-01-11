@extends('Customer.Supplier.head')
@section('content')

<div class="wrapper">
    @include('Customer.Supplier.header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Inquiry List</h3>
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
                        <a href="/seller/itemManagement/itemList">Inquiry List</a>
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
                                        <th>Inquiry ID</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Item Name</th>
                                        <th>Message</th>
                                        <th>Reply</th>
                                        <th>Replied At</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach($inquiryList as $key => $inquiry)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $inquiry->user_name }}</td>
                                            <td>{{ $inquiry->user_email }}</td>
                                            <td>{{ $inquiry->item_name }}</td>
                                            <td>{{ $inquiry->inquiry_message }}</td>
                                            <td>{{ $inquiry->inquiry_reply ?? 'No reply yet' }}</td>
                                            <td>{{ $inquiry->replied_at ?? 'Pending' }}</td>
                                            <td>{{ $inquiry->inquiry_created_at }}</td>
                                            <td>
                                                <button class="btn btn-success reply-btn" 
                                                        data-id="{{ $inquiry->inquiry_id }}"
                                                        data-message="{{ $inquiry->inquiry_message }}">
                                                    Reply
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

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="replyForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel">Reply to Inquiry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="inquiry_id" id="inquiryId">
                        <div class="form-group">
                            <label for="inquiryMessage">Inquiry Message</label>
                            <textarea class="form-control" id="inquiryMessage" rows="3" readonly></textarea>
                        </div>
                        <div class="form-group">
                            <label for="replyText">Reply</label>
                            <textarea class="form-control" name="reply" id="replyText" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reply scripts and alert libs -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            console.error("CSRF token meta tag is missing.");
            return;
        }

        document.querySelectorAll('.reply-btn').forEach(button => {
            button.addEventListener('click', () => {
                const inquiryId = button.getAttribute('data-id');
                const inquiryMessage = button.getAttribute('data-message');

                document.getElementById('inquiryId').value = inquiryId;
                document.getElementById('inquiryMessage').value = inquiryMessage;

                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('replyModal'));
                modal.show();
            });
        });

        document.getElementById('replyForm').addEventListener('submit', (e) => {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            // Send AJAX request to save the reply
            fetch('/seller/itemManagement/saveReply', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Reply saved successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        location.reload(); // Reload the page after the Alert closes
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to save reply.',
                        text: data.message || 'An unexpected error occurred.',
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'There was a problem saving your reply. Please try again later.',
                });
                console.error('Error:', error);
            });
        });
    });

</script>


@endsection
