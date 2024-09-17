@extends('dashboard::layouts.master')

@section('content')
    <h1>Selamat Datang !</h1>

    <p>Halo {{ auth()->user()->name }}</p>
@endsection
