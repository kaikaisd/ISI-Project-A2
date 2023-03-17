
@section('content')
<table class="table">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cartItems as $cartItem)
            <tr>
                <td>{{ $cartItem->product->name }}</td>
                <td>
                    <form action="{{ route('cart.update', $cartItem->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1">
                        <button type="submit">Update</button>
                    </form>
                </td>
                <td>{{ $cartItem->price }}</td>
                <td>{{ $cartItem->quantity * $cartItem->price }}</td>
                <td>
                    <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td>Total: {{ $total }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>