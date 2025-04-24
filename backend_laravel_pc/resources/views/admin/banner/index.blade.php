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
                    <div class="d-sm-flex align-items-center justify-content-end mb-1">
                        <a href="{{route('admin.banner.create')}}" class="btn btn-success">Add New Banner</a>

                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Banner Table</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">#</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->id }}</td>
                                        <td>{{ $banner->title }}</td>
                                        <td>{{ $banner->description }}</td>
                                        <td style="width: 150px">
                                            @if($banner->image)
                                            <img src="{{ asset('storage/'.$banner->image) }}" width="150" height="100">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-space-between">

                                                <a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-primary mr-2 d-flex">
                                                    <i class="fas fa-solid fa-pen mr-2 mt-1 " style="font-size: 15px"></i>
                                                    Edit</a>
                                                <form action="{{ route('admin.banner.delete', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger d-flex">
                                                        <i class="fas fa-solid fa-trash mr-2 mt-1 " style="font-size: 15px"></i>
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
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
