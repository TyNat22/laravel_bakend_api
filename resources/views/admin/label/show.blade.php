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

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <div style="width: 150px;height:40px;border-radius:0px 15px;" class="bg-success align-item-center row justify-content-center">
                    <h6 class="mt-2 row font-weight-bold text-light text-center align-item-center">{{ $label    ->name }} Table</h6>
                </div>
                {{-- <h6 class="m-0 font-weight-bold text-primary">Product Table</h6> --}}
                <div class="d-flex">
                    <!-- Search Input -->
                    <div class="input-group mr-2" style="width: 200px;">
                        <input type="text" id="search" placeholder="Search..." class="form-control">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="filterTable()">
                                <i class="fas fa-search"></i> <!-- Font Awesome icon -->
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 30px">#</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>CPU</th>
                                <th>RAM</th>
                                <th>Storage</th>
                                <th>VGA</th>
                                <th>Price</th>
                                <th>Action</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach($label->products as $product)
                                <tr>
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>
                                            @if($product->product_image)
                                            <img src="{{ asset('images/'.$product->product_image) }}" width="80" height="50">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->CPU }}</td>
                                        <td>{{ $product->RAM }}</td>
                                        <td>{{ $product->storage}}</td>
                                        <td>{{ $product->VGA }}</td>
                                        <td>{{ $product->product_price }}$</td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{route('admin.product.edit',$product->id)}}" class="btn btn-primary">Edit</a>
                                                <form action="{{route('admin.product.destroy',$product->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>


                                    </tr>
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

            .toast-center {
                top: 10%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>

@endsection
