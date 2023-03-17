@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
    <div class="container">
        @if (Auth::check())
            <form action="{{ route('order.store') }}" method="POST">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <h2>Checkout</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItem as $key)
                                    <tr>
                                        <td><img src="{{ $key->product->productPicture[0]->path }}" width="50"
                                                alt="{{ $key->product->name }}"></td>
                                        <td>{{ $key->product->name }}</td>
                                        <td width='3'><input id="quantity[{{ $key->product_id }}]" type="number"
                                                value="{{ $key->quantity }}"
                                                onChange='onChangeQuantity({{ $key->product_id }})' /></td>
                                        <td class="{{ $key->product->isPromotion == 1 ? 'text-danger' :'' }}">${{ $key->product->isPromotion == 1 ? $key->product->promoPrice : $key->product->price }}</td>
                                        <td class="{{ $key->product->isPromotion == 1 ? 'text-danger' :'' }}">${{ $key->product->isPromotion == 1 ? $key->product->promoPrice * $key->quantity : $key->product->price * $key->quantity }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger"
                                                onclick="deleteCart({{ $key->product_id }})"><i
                                                    class="fa-solid fa-trash"></i></button>
																										&nbsp;
																						<a href="{{ route('product.detail', ['id' => $key->product_id]) }}" class="btn btn-primary"><i class="fa-sharp fa-solid fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5">Total</td>
                                    <td>${{ $totalPrice }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <h2>Shipping Information</h2>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" disabled value="{{ auth()->user()->name }}" class="form-control"
                                id="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" disabled value="{{ auth()->user()->address }}" id="address" rows="3"
                                placeholder="Enter address"></textarea>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12 d-grid gap-2">
                        <button id="submit" type="submit" class="btn btn-primary btn-lg"
                            onclick="this.disabled = true">Place Order</button>
                    </div>
                </div>
            </form>
        @else
            <div class="alert alert-danger">Please login to checkout.</div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function onChangeQuantity(pid) {
            let uid = {{ auth()->user()->id }};
            let quantity = document.getElementById('quantity[' + pid + ']').value;
            var url = "{{ route('cart.update') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: uid,
                    product_id: pid,
                    quantity: quantity
                },
                success: function(data) {
                    location.reload();
                }
            });
        }

        function deleteCart(pid) {
            let uid = {{ auth()->user()->id }};
            var url = "{{ route('cart.destroy') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE',
                    user_id: uid,
                    product_id: pid
                },
                success: function(data) {
                    location.reload();
                }
            });
        }
        $(document).ready(function() {
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endsection
