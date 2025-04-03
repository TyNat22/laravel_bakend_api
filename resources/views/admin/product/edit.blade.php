@extends('admin.layouts.app')

@section('content')
     <!-- Page Heading -->

    <div class="card shadow m-4 p-4">

        <form action="{{ route('admin.product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h5 class="text-gray p-0 m-0">Edit</h5>
            <hr class="">
            <div class="form-row">
              <div class="form-group col-md-5">
                <label for="">Name</label>
                <input type="text" class="form-control" value="{{$product->product_name}}" name="product_name" required>
              </div>
              <div class="form-group col-md-4">
                <label for="">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="">Label</label>
                <select name="label_id" class="form-control">
                    <option value="">None</option> <!-- Represents no selection -->
                    @foreach($labels as $label) <!-- Loop through your labels if needed -->
                        <option value="{{ $label->id }}">{{ $label->name }}</option>
                    @endforeach
                </select>
            </div>
            </div>
            <div class="form-group">
              <label for="">SSD</label>
              <input type="text" class="form-control" name="storage" value="{{$product->storage}}" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="">CPU</label>
                  <input type="text" name="CPU" class="form-control" value="{{$product->CPU}}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="">VGA</label>
                    <input type="text" name="VGA" value="{{$product->VGA}}" class="form-control" placeholder="Intel Iris Plus Graphics" required>
                  </div>

              </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="">RAM</label>
                <input type="text" class="form-control" name="RAM" value="{{$product->RAM}}" required>
              </div>
              <div class="form-group col-md-4">
                <label for="">Price</label>
                <input type="text" name="product_price" value="{{$product->product_price}}" class="form-control" required>
              </div>

              <div class="form-group col-md-2">
                <label for="">Rating</label>
                <input type="text" name="product_rating" value="{{$product->product_rating}}" class="form-control" required>
              </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="">Operating System</label>
                  <input type="text" name="OS" class="form-control" value="{{$product->OS}}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Screen</label>
                    <input type="text" name="SCREEN" class="form-control" value="{{$product->SCREEN}}" required>
                  </div>

              </div>
            <div class="form-group">
                <div class="mb-3">
                    <label for="" class="form-label">Currently Image</label><br>
                    @if($product->product_image)
                        <img src="{{ asset('storage/images/product/'.$product->product_image) }}" height="100" width="150"><br><br>
                    @endif
                    <input type="file" name="product_image" class="form-control" accept="image/*" >
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
    </div>
@endsection
