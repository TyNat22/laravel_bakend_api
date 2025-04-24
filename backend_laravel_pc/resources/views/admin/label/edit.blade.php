
@extends('admin.layouts.app')

@section('content')
     <!-- Page Heading -->

    <div class="card shadow m-4 p-4" style="width: 800px;">
        <form action="{{ route('admin.label.update',$label->id) }}" method="POST">
            @csrf
            @method('PUT')
            <h1>Update</h1>
            <hr>
            <div class="mb-3">
              <label for="exampleInputname" class="form-label">Label Name</label>
              <input type="text" name="name" value="{{ $label -> name}}" class="form-control" id="exampleInputName1" aria-describedby="nameHelp" required>

            </div>

            <button type="submit" class="btn btn-primary">Update</button>
          </form>
    </div>
@endsection
