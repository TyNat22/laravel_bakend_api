@extends('admin.layouts.app')

@section('content')
     <!-- Page Heading -->

    <div class="card shadow m-4 p-4" style="width: 800px;">
        <form action="{{route('admin.banner.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <h1>Create</h1>
            <hr>
            <div class="mb-3">
              <label for="exampleInputname" class="form-label">Banner title</label>
              <input type="text" name="title" class="form-control" id="exampleInputName1" aria-describedby="nameHelp">

            </div>
            <div class="mb-3">
              <label for="exampleInputdescription1" class="form-label">Banner Description</label>
              <input type="text" name="description" class="form-control" id="exampleInputdescription1">
            </div>
            <div class="mb-3">
                <label for="exampleInputdescription1" class="form-label">Banner Image</label>

                <input type="file" name="image" class="form-control" wire:model="photo" accept="image/*">
              </div>

            <button type="submit" class="btn btn-primary">Save</button>
          </form>
    </div>
@endsection
