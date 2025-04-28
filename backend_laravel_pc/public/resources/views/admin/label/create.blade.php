@extends('admin.layouts.app')

@section('content')
     <!-- Page Heading -->

    <div class="card shadow m-4 p-4" style="width: 800px;">
        <form action="{{ route('admin.label.store') }}" method="POST">
            @csrf
            <h1>Create</h1>
            <hr>
            <div class="mb-3">
              <label for="exampleInputname" class="form-label">Label Name</label>
              <input type="text" name="name" placeholder="label name" class="form-control" id="exampleInputName1" aria-describedby="nameHelp" required>

            </div>

            <button type="submit" class="btn btn-primary">Save</button>
          </form>
    </div>
@endsection
