<?php
    $title = "Twoje zapisane adresy";
    $lazy = True;
?>
@extends('layouts.app')

@section('content')
<article class="addresses">
    <section class="addresses__content">
        <h2>Twoje zapisane adresy</h2>
        <a href="{{ url('/konto') }}" class="back">Powrót</a>
        <div id="app">
            <addresses user_id="{{ Auth::id() }}" _token="{{ csrf_token() }}"></addresses>
        </div>
    </section>
</article>
@include('partials.search')
@endsection
