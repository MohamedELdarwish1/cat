@extends('layout')
@section('content')
@if(session()->has('success'))
<div class="alert alert-success w-100">{{ session('success') }}</div>
@elseif(session()->has('error'))
<div class="alert alert-danger w-100">{{ session('error') }}</div>
@endif
@endsection
