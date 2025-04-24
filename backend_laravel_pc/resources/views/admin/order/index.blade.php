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
    @elseif (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'error!',
            text: '{{ error("error") }}',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-1">
        {{-- <a href="" class="btn btn-success">Add New Product</a> --}}
    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div style="width: 150px;height:40px;border-radius:0px 15px;" class="bg-success align-item-center row justify-content-center">
                                <h6 class="mt-2 row font-weight-bold text-light text-center align-item-center">Order Table</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">#</th>
                                            <th>customer_name</th>
                                            <th>customer_email</th>
                                            <th>qty</th>
                                            <th>Price</th>
                                            <th>payment_status</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td> <!-- Accessing Eloquent object property -->
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ $order->user->email }}</td>
                                                <td>
                                                    @foreach ($order->carts as $cart)
                                                    <!-- Display product name and quantity -->

                                                        {{ $cart->quantity }}

                                                @endforeach
                                                </td>
                                                <td>${{ $order->total_price }}</td>
                                                <td>{{ $order->payment_status }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td class="d-flex">
                                                    <button class="btn btn-success">show</button>
                                                    <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
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
