@extends('layout')
@section('content')

<div class="row">
    <div class="d-flex justify-content-between mb-4">

        <h3 class="col">Shopping Cart</h3>
    <div class="col text-right">
        <a href="{{ route('items.index') }}" class="btn btn-danger">Go back and select more items</a>
    </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success w-100">{{ session('success') }}</div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger w-100">{{ session('error') }}</div>
    @endif

    <form method="post" action="{{ route('cart.update') }}">
        @csrf
        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item['id'] }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['price'] }}</td>
                        <td>
                            <input type="number" name="quantities[{{ $item['id'] }}]" value="{{ $item['quantity'] }}" min="1">
                        </td>
                        <td>{{ $item['price'] * $item['quantity'] }}</td>
                        <td>
                            <a href="{{ route('cart.remove', $item['id']) }}">Remove</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update Cart</button>
            <a href="{{ route('payment') }}" class="btn btn-success">Proceed to Payment</a>
        </div>
    </form>
</div>

@endsection
