<?php
    $title = "Dodawanie nowego produktu";
?>
@extends('layouts.app')

@section('content')
<article class="admin">
    <section class="admin__content">
        <div class="admin__content__main">
            <h2>Dodawanie nowego produktu</h2>
            <a href="{{ url('/admin') }}" class="back">Powrót</a>
        </div>
        <div id="app">
            <new-product user_id="{{ Auth::id() }}" _token="{{ csrf_token() }}"></new-product>
        </div>
    </section>
</article>
@include('partials.search')
@endsection
