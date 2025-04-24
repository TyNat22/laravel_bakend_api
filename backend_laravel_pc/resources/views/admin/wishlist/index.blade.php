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

                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div style="width: 150px;height:40px;border-radius:0px 15px;" class="bg-success align-item-center row justify-content-center">
                                <h6 class="mt-2 row font-weight-bold text-light text-center align-item-center">Wishlist Table</h6>
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
                                            <th>product_image</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($wishlists as $wishlist)
                                        <tr>
                                            <td>{{ $wishlist->id }}</td>
                                            <td>{{ $wishlist->user->name }}</td>
                                            <td>{{ $wishlist->product->product_name }}</td>
                                            <td>
                                                <img src="{{ asset('images/'.$wishlist->product->product_image) }}" width="80" height="50">
                                            </td>




                                        <td>
                                            <a href="{{route('admin.wishlist.user',$wishlist->user->id)}}" class="btn btn-info">show User</a>
                                            <a href="{{route('admin.wishlist.product',$wishlist->product->id)}}" class="btn btn-info">show Product</a>
                                            <form action="" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this favourite product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                        </tr>
                                        @endforeach
                                        {{-- @foreach($categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td style="width: 150px">
                                                    @if($category->image)
                                                    <img src="{{ asset('images/'.$category->image) }}" width="150" height="100">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-space-between">
                                                        <a href="{{route('admin.category.show',$category->id)}}" class="btn btn-primary mr-2">Show</a>
                                                        <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-primary mr-2">Edit</a>
                                                        <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach --}}







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
