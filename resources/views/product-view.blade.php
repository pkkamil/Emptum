<?php
    $title = "Edycja produktu o ID ".$product -> id;
    $lazy = True;
?>
@extends('layouts.app')

@section('content')
<article class="admin">
    <section class="admin__content">
        <div class="admin__content__main">
            <h2>Zarządzanie produktem o&nbsp;ID&nbsp;<span class="grey">{{ $product -> id }}</span></h2>
            <a href="{{ url('/admin/produkty') }}" class="back">Powrót</a>
        </div>
        <div id="app">
            <edit-product user_id="{{ Auth::id() }}" product_id="{{ $product -> id }}" _token="{{ csrf_token() }}"></edit-product>
        </div>
    </section>
</article>
@include('partials.search')
@endsection
