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
                        {{-- <a href="{{route('admin.category.create')}}" class="btn btn-success">Add New Rate</a> --}}

                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div style="width: 150px;height:40px;border-radius:0px 15px;" class="bg-success align-item-center row justify-content-center">
                                <h6 class="mt-2 row font-weight-bold text-light text-center align-item-center">Rate Table</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">#</th>
                                            <th>user_name</th>
                                            <th>product_name</th>
                                            <th>rate</th>
                                            <th>review</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($ratings as $rating)
                                            <tr>
                                                <td>{{ $rating->id }}</td>
                                                <td>{{ $rating->user->name }}</td>
                                                <td>{{ $rating->product->product_name }}</td>
                                                <td>{{ $rating->rating }} / 5</td>
                                                <td>{{ $rating->review }}</td>
                                                <td>
                                                    <a href="{{route('admin.rate.showUser',$rating->user->id)}}" class="btn btn-info">Show User</a>
                                                    {{-- <button class="btn btn-primary">Show User</button> --}}
                                                    <a href="{{ route('admin.rate.showProduct', $rating->product->id) }}" class="btn btn-info">
                                                        Show Product
                                                    </a>
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
