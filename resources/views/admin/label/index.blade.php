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
                        <a href="{{route('admin.label.create')}}" class="btn btn-success">Add New Label</a>

                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Category Table</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">#</th>
                                            <th>Name</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($labels as $label)
                                            <tr>
                                                <td>{{ $label->id }}</td>
                                                <td>{{ $label->name }}</td>


                                                <td>

                                                    <div class="d-flex justify-content-space-between">
                                                        <a href="{{ route('admin.label.show', $label->id) }}" class="btn btn-info mr-2">Show</a>
                                                        <a href="{{ route('admin.label.edit', $label->id) }}" class="btn btn-primary mr-2">Edit</a>
                                                        <form action="{{route('admin.label.delete',$label->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        {{-- <tr>
                                            <td>1</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>
                                               <button class="btn btn-primary btn-block">Edit</button>
                                               <button class="btn btn-danger btn-block">Edit</button>
                                            </td>

                                        </tr> --}}






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
