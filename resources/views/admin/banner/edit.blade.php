@extends('admin.layouts.app')

@section('content')
     <!-- Page Heading -->

    <div class="card shadow m-4 p-4" style="width: 800px;">
        <form action="{{route('admin.banner.update',$banner->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h1>Edit</h1>
            <hr>
            <div class="mb-3">
              <label for="exampleInputname" class="form-label">Banner title</label>
              <input type="text" name="title" value="{{ $banner->title }}" class="form-control" id="exampleInputName1" aria-describedby="nameHelp">

            </div>
            <div class="mb-3">
              <label for="exampleInputdescription1" class="form-label">Banner Description</label>
              <input type="text" name="description" value="{{ $banner->description }}" class="form-control" id="exampleInputdescription1">
            </div>
            <div class="mb-3">
                <label for="exampleInputdescription1" class="form-label">Current Image</label><br>

                @if($banner->image)
                <img src="{{ asset('storage/'.$banner->image) }}" alt="Current Image" height="100" width="100"><br><br>
                @endif

                <input type="file" name="image" class="form-control" accept="image/*">
              </div>

            <button type="submit" class="btn btn-primary">Save</button>
          </form>
    </div>
@endsection
