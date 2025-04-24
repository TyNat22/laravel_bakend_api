@extends('admin.layouts.app')

@section('content')
     <!-- Page Heading -->

    <div class="card shadow m-4 p-4" style="width: 800px;">
        <form action="{{route('admin.category.update',$category->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h1>Edit</h1>
            <hr>
            <div class="mb-3">
              <label for="exampleInputname" class="form-label">Category Name</label>
              <input type="text" name="name"  value="{{ $category->name }}" class="form-control" id="exampleInputName1" aria-describedby="nameHelp">

            </div>
            <div class="mb-3">
              <label for="exampleInputdescription1" class="form-label">Category Description</label>
              <input type="text"  name="description" value="{{ $category->description }}" class="form-control" id="exampleInputdescription1">
            </div>
            <div class="mb-3">
                <label for="exampleInputdescription1" class="form-label">Current Image</label><br>

                @if($category->image)
                <img src="{{ asset('storage/images/'.$category->image) }}" alt="Current Image" height="100" width="100"><br><br>
                @endif

                <input type="file" name="image" class="form-control" accept="image/*">
              </div>

            <button type="submit" class="btn btn-primary">Update</button>
          </form>
    </div>
@endsection
