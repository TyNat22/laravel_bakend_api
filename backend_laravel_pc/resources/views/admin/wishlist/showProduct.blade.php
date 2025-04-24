@extends('admin.layouts.app')

@section('content')
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
     <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-1">
                        <a href="{{ route('admin.rate') }}" class="btn btn-primary">Back</a>

                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            @foreach($wishlists as $wishlist)

                                <h6 class="mt-2 row font-weight-bold text-info text-center align-item-center">{{$wishlist->product->product_name }} Table</h6>


                            @endforeach

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">#</th>
                                            <th>User_name</th>
                                            <th>User_email</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($wishlists as $wishlist)
                                            <tr>
                                                <td>{{ $wishlist->id }}</td>
                                                <td>{{ $wishlist->product->product_name }}</td>
                                                    <td>
                                                        <img src="{{ asset('images/'.$wishlist->product->product_image) }}" width="80" height="50">
                                                    </td>
                                                <td>

                                                    <button class="btn btn-danger">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <script>
                        toastr.options = {
                            "positionClass": "toast-center",  // Custom position
                            "timeOut": "3000",                 // Auto close after 3 seconds
                            "closeButton": true,               // Show close button
                            "progressBar": true                // Show progress bar
                        };

                        @if(session('success'))
                            toastr.success("{{ session('success') }}");
                        @endif

                        @if(session('error'))
                            toastr.error("{{ session('error') }}");
                        @endif
                    </script>

                    <style>
                        /* Custom center position */
                        .toast-center {
                            top: 10%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                        }
                    </style>

@endsection
