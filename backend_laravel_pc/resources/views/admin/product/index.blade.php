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
    <div class="d-sm-flex row align-items-right justify-content-end mb-1 mr-2">

        <a href="{{route('admin.product.create')}}" class="btn btn-success">
            <i class="fas fa-solid fa-plus mr-2 mt-1 " style="font-size: 15px"></i>
            Add New Product
        </a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div style="width: 150px;height:40px;border-radius:0px 15px;" class="bg-success align-item-center row justify-content-center">
                <h6 class="mt-2 row font-weight-bold text-light text-center align-item-center">Product Table</h6>
            </div>
            <div class="d-flex">
                <!-- Search Input -->
                <form method="GET" action="{{ route('admin.product.filter') }}" class="d-flex" onchange="this.form.submit()">
                    <div class="input-group mr-2" style="width: 200px;">
                        <input type="text" name="search" placeholder="Search..." class="form-control" value="{{ request('query') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> <!-- Font Awesome icon -->
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Category Filter -->
                <form action="{{ route('admin.product.filter') }}" method="GET">
                    <select name="category_id" class="form-control bg-info text-light" style="width: 200px;" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </form>
               <!-- RAM Filter -->
                <form action="{{ route('admin.product.filter') }}" method="GET">
                    <select name="ram" class="form-control bg-warning text-light" style="width: 120px;" onchange="this.form.submit()">

                        <option value=" ">All RAM</option>
                        <option value="4GB" {{ request('ram') == '4GB' ? 'selected' : '' }}>4GB</option>
                        <option value="8GB" {{ request('ram') == '8GB' ? 'selected' : '' }}>8GB</option>
                        <option value="16GB" {{ request('ram') == '16GB' ? 'selected' : '' }}>16GB</option>
                        <option value="32GB" {{ request('ram') == '32GB' ? 'selected' : '' }}>32GB</option>


                    </select>
                </form>
                <!-- Price Range Filter -->
                <form action="{{ route('admin.product.filter') }}" method="GET">
                    <select name="price" class="form-control bg-success text-light" style="width: 150px;" onchange="this.form.submit()">
                        <option value="">All Prices</option> <!-- If selected, shows all products -->
                        <option value="0-500" {{ request('price') == '0-500' ? 'selected' : '' }}>0$ - 500$</option>
                        <option value="500-1000" {{ request('price') == '500-1000' ? 'selected' : '' }}>500$ - 1000$</option>
                        <option value="1000-1500" {{ request('price') == '1000-1500' ? 'selected' : '' }}>1000$ - 1500$</option>
                        <option value="1500-2000" {{ request('price') == '1500-2000' ? 'selected' : '' }}>1500$ - 2000$</option>
                        <option value="2000-999999" {{ request('price') == '2000-999999' ? 'selected' : '' }}>2000$+</option>
                    </select>
                </form>
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
                            <th>
                                <i class="fas fa-bolt"></i>
                                Action
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>
                                    @if($product->product_image)
                                        <img src="{{ asset('storage/'.$product->product_image) }}" width="80" height="50">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->CPU }}</td>
                                <td>{{ $product->RAM }}</td>
                                <td>{{ $product->storage }}</td>
                                <td>{{ $product->VGA }}</td>
                                <td>{{ $product->product_price }}$</td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-primary mr-2 d-flex justify-content-center">
                                            <i class="fas fa-solid fa-pen mr-2 mt-1 " style="font-size: 15px"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger d-flex justify-content-center">
                                                <i class="fas fa-solid fa-trash mr-2 mt-1 " style="font-size: 15px"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-danger">No matching products found.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        // toastr.options = {
        //     "positionClass": "toast-center",  // Custom position
        //     "timeOut": "3000",                 // Auto close after 3 seconds
        //     "closeButton": true,               // Show close button
        //     "progressBar": true                // Show progress bar
        // };

        // @if(session('success'))
        //     toastr.success("{{ session('success') }}");
        // @endif

        // @if(session('error'))
        //     toastr.error("{{ session('error') }}");
        // @endif
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
