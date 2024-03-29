@extends('layouts.app')
@section('title', 'Product Form')
@section('content')
    <div class="container">
        <h2>Product Form</h2>
        <a href="{{ route('vendor.product.index') }}" class="btn btn-secondary mb-4">Back</a>
        <form
            action="{{ route('vendor.product.action', ['id' => request('id') == 'new' ? 'new' : $product->id, 'action' => request('id') == 'new' ? 'create' : 'update']) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <input hidden name="id" value="{{ request('id') == 'new' ? 'new' : $product->id }}">
            <div class="row">
                <div class="col-md-6">
                    @if (request('id') == 'new')
                        <h4>Product Images:</h4>
                        <div class="row mb-4">
                            <h2>To prevent errors, please enter the details and submit it first.</h2>
                        </div>
                    @else
                        <h4>Product Images:</h4>
                        <div class="row mb-4">
                            @foreach ($product->productPicture->sortBy('order') as $image)
                                <div class="col-md-4 mb-4">
                                    <img src="{{ asset($image->path) }}" alt="{{ $product->name }}" style="max-height: 100px;">
                                    <input type="number" name="image_order[{{ $image->id }}]" class="form-control mt-2"
                                        value="{{ $image->order }}">
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-danger btn-sm ml-2"
                                            onclick="deleteImage({{ $image->id }})">Delete</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="file" name="new_image[]" accept="image/*" multiple>

                    @endif


                </div>

                <div class="col-md-6">
                    <h4>Product Details:</h4>
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" class="form-control" required value="{{ $product->name }}">
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
                    </div>
                    @if(request('id') == 'new')
                    <div class="form-group">
                        <label>Quantity:</label>
                        <input type="number" name="quantity" class="form-control" required
                            value="{{ $product->quantity }}" min="0">
                    </div>
                    @else
                    <div class="form-group">
                        <label>Current Quantity:</label>
                        <input type="number" name="old_quantity" class="form-control" required
                            value="{{ $product->quantity }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>New Quantity:</label>
                        <input type="number" name="quantity" class="form-control" required
                            value="0" min="0">
                    </div>
                    @endif
                    <div class="form-group">
                        <label>Price:</label>
                        <input type="number" id="price" name="price" class="form-control"
                            value="{{ $product->price }}" min="0">
                    </div>
                    <div class="form-group">
                        <label>ISBN:</label>
                        <input type="text" name="isbn" class="form-control" required
                            value="{{ $product->isbn }}">
                    </div>
                    <div class="form-group">
                        <label>Author:</label>
                        <input type="text" name="author" class="form-control" required
                            value="{{ $product->author }}">
                    </div>
                    <div class="form-group">
                        <label>Publisher:</label>
                        <input type="text" name="publisher" class="form-control" required
                            value="{{ $product->publisher }}">
                    </div>
                    <div class="form-group">
                        <label>Release date:</label>
                        <input type="date" name="release_date" class="form-control" required
                            value="{{ $product->release_date }}" >
                    </div>
                    <div class="form-group">
                        <label>Pages:</label>
                        <input type="number" name="pages" class="form-control" required
                            value="{{ $product->pages }}">
                    </div>
                    <div class="form-group">
                        <label>Category:</label>
                        <select name="category_id" class="form-control" required>
                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"{{ $product->category_id === $category->id ? ' selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Brand:</label>
                        <select name="brand_id" class="form-control" required>
                            @foreach ($brands as $brand)
                                <option
                                    value="{{ $brand->id }}"{{ $product->brand_id === $brand->id ? ' selected' : '' }}>
                                    {{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="hidden" name="isOverSale" value="0">
                        <input type="checkbox" name="isOverSale" class="form-check-input"
                            value="1"{{ $product->isOverSale ? ' checked' : '' }}>
                        <label class="form-check-label">Is Over Sale?</label>
                    </div>
                    <div class="form-check">
                        <input type="hidden" name="isOnSale" value="0">
                        <input type="checkbox" name="isOnSale" class="form-check-input"
                            value="1"{{ $product->isOnSale ? ' checked' : '' }}>
                        <label class="form-check-label">Is On Sale?</label>
                    </div>
                    
                    <div class="form-check">
                        <input type="hidden" name="isPromotion" value="0">
                        <input type="checkbox" onclick="switchBox()" id="isPromotion" name="isPromotion"
                            class="form-check-input" value="1"{{ $product->isPromotion ? ' checked' : '' }}>
                        <label class="form-check-label">Is Promotion?</label>
                    </div>
                    <div class="form-group">
                        <label>Promotion Price:</label>
                        <input type="hidden" name="promoPrice" value="{{ $product->promoPrice > 0 ? $product->promoPrice : 0 }}">
                        <input type="number" id="promoPrice" name="promoPrice" class="form-control" default="0"
                            value="{{ $product->promoPrice }}" disabled min="0">
                    </div>

                    <div class="form-group">
                        <label>Continue Edit</label>&nbsp;
                        <input type="checkbox" name="continue_edit" value="1"
                            {{ request('id') == 'new' ? 'checked readonly' : '' }}>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        // JavaScript code for deleting an image
        function deleteImage(id) {
            if (confirm('Are you sure you want to delete this image?')) {
                window.location.href =
                    '{{ route('vendor.product.action', ['id' => request('id') == 'new' ? 'new' : $product->id, 'action' => 'deleteImage']) }}/' +
                    id;
            }
        }

        function switchBox() {
            if (document.getElementById('isPromotion').checked) {
                document.getElementById('promoPrice').disabled = false;
            } else {
                document.getElementById('promoPrice').disabled = true;
            }
        }
    </script>
@endsection
