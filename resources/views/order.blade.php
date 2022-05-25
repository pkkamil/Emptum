<?php
    $order_page = true;
    $lazy = True;
    $title = "Tworzenie zamówienia";
?>
@extends('layouts.app')

@section('content')
<div id="app">
    @auth
        <order user_id="{{ Auth::id() }}" email="{{ Auth::user() -> email }}" name="{{ Auth::user() -> name }}" surname="{{ Auth::user() -> surname }}" _token="{{ csrf_token() }}"></order>
    @endauth
    @guest
        <order user_id="{{ Auth::id() }}" _token="{{ csrf_token() }}"></order>
    @endguest
</div>
@endsection
