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

                        <a href="{{route('admin.user.create')}}" class="btn btn-success">
                            <i class="fas fa-solid fa-plus"></i>
                            Add New User
                        </a>

                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">User Table</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Start_Date</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{$user->id}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->role}}</td>
                                                <td>{{$user->created_at}}</td>
                                                <td class="d-flex justify-content-space-between">
                                                    @if($user->role !== 'admin')


                                                    <button type="button" class="btn btn-primary mr-2" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-solid fa-pen"></i>

                                                        Edit
                                                    </button>
                                                    <form action="{{route('admin.user.delete',$user->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-solid fa-trash"></i>
                                                            Delete
                                                        </button>
                                                    </form>

                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        {{-- @foreach($categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description }}</td>

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
