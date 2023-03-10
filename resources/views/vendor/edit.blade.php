@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Product</h2>

        <form action="{{ route('vendor.product.update', ['id' => $product->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <h4>Product Images:</h4>
                    <div class="row mb-4">
                        @foreach ($product->images as $image)
                            <div class="col-md-4 mb-4">
                                <img src="{{ $image->url }}" alt="{{ $product->name }}" style="max-height: 100px;">
                                <div class="mt-2">
                                    <input type="hidden" name="image_order[{{ $image->id }}]"
                                        value="{{ $image->order }}">
                                    <input type="number" name="new_order[{{ $image->id }}]" min="1"
                                        value="{{ $image->order }}" style="width: 50px;">
                                    <button type="button" class="btn btn-danger btn-sm ml-2"
                                        onclick="deleteImage({{ $image->id }})">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type="file" name="new_images[]" accept="image/*" multiple>
                </div>

                <div class="col-md-6">
                    <h4>Product Details:</h4>
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Quantity:</label>
                        <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}"
                            min="0">
                    </div>
                    <div class="form-group">
                        <label>Category:</label>
                        <select name="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"{{ $product->category_id === $category->id ? ' selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Brand:</label>
                        <select name="brand_id" class="form-control">
                            @foreach ($brands as $brand)
                                <option
                                    value="{{ $brand->id }}"{{ $product->brand_id === $brand->id ? ' selected' : '' }}>
                                    {{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_over_sale" class="form-check-input"
                            value="1"{{ $product->is_over_sale ? ' checked' : '' }}>
                        <label class="form-check-label">Is Over Sale?</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_on_sale" class="form-check-input"
                            value="1"{{ $product->is_on_sale ? ' checked' : '' }}>
                        <label class="form-check-label">Is On Sale?</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_promotion" class="form-check-input"
                            value="1"{{ $product->is_promotion ? ' checked' : '' }}>
                        <label class="form-check-label">Is Promotion?</label>
                    </div>
                    <div class="form-group">
                        <label>Promotion Price:</label>
                        <input type="number" name="promotion_price" class="form-control"
                            value="{{ $product->promotion_price }}" min="0">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        // JavaScript code for deleting an image
        function deleteImage(id) {
            if (confirm('Are you sure you want to delete this image?')) {
                var input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'delete_image_ids[]');
                input.setAttribute('value', id);
                document.querySelector('form').appendChild(input);

                var imageDiv = document.querySelector('div[data-image-id="' + id + '"]');
                imageDiv.parentNode.removeChild(imageDiv);
            }
        }
    </script>
@endsection
