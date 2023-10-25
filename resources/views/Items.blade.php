{{-- @extends('layout')
@section('content')

<div class="row">
    <div class="d-flex justify-content-between mb-4">
        <h3>Store Items List</h3>
    </div>

    @if(session()->has('success'))
        <label class="alert alert-success w-100">{{ session('success') }}</label>
    @elseif(session()->has('error'))
        <label class="alert alert-danger w-100">{{ session('error') }}</label>
    @endif

    <form method="post" action="#">
        @csrf
        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th>Select</th>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_items[]" value="{{ $item->id }}">
                        </td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                            <input type="number" class="form-control" name="quantities[{{ $item->id }}]" value="1" min="1">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Add To Cart</button>
        </div>
    </form>
</div>

@endsection --}}


@extends('layout')
@section('content')

<div class="row">
    <div class="d-flex justify-content-between mb-4">
        <h3>Store Items List</h3>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success w-100">{{ session('success') }}</div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger w-100">{{ session('error') }}</div>
    @endif

    <table class="table table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->price }}</td>
                    <td>
                        <form method="post" action="{{ route('cart.add', $item->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
