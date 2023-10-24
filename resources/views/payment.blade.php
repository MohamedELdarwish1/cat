@extends('layout')
@section('content')

<div class="row">
    <div class="d-flex justify-content-between mb-4">
        <h3>Payment</h3>

        <a style=" margin-right: auto;" href="{{ route('cart.index') }}" class="btn btn-success ml-auto">
            Cancel and go back to the shopping cart
        </a>
    </div>


    @if(session()->has('error'))
        <div class="alert alert-danger w-100">{{ session('error') }}</div>
    @endif
    <br>
    <br>
    </div>
    <form method="post" action="{{ route('process-payment') }}">
        @csrf
        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            {{-- <input type="text" name="address" id="address" class="form-control" required> --}}
            <select  name="payment_method"  id="payment_method">
                <option class="form-control" selected disabled value="Store Credits">Store Credits</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Telephone Number</label>
            <input type="text" name="telephone" id="telephone" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Place Transaction</button>
        </div>
    </form>
</div>

@endsection
