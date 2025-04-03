@extends('admin.layouts.app')

@section('content')
     <!-- Page Heading -->

    <div class="card shadow m-4 p-4">

        <form action="{{route('admin.order.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <h5 class="text-gray p-0 m-0">Create</h5>
            <hr>
            <div class="form-row">

              <div class="form-group col-md-6">
                <label for="">Customer Name</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group col-md-5">
                <label for="">Product</label>
                <select name="product_id" class="form-control">
                    <option value="">Select Product</o  ption> <!-- Represents no selection -->
                    @foreach($products as $product) <!-- Loop through your labels if needed -->
                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
            </div>
            </div>
            <div class="form-group">
              <label for="">Quantity</label>
              <input type="text" class="form-control" name="quantity" placeholder="25" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
    </div>
@endsection
