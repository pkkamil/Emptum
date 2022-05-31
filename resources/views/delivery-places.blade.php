<?php
    $title = "Miejsca odbioru";
    $lazy = True;
?>
@extends('layouts.app')
@section('content')
    <article class="admin">
        <section class="admin__content">
            <div class="admin__content__main">
                <h2>Zarządzanie miejscami odbioru</h2>
                <a href="{{ url('/admin') }}" class="back">Powrót</a>
            </div>
            <div id="app">
                <delivery-places user_id="{{ Auth::id() }}" _token="{{ csrf_token() }}"></delivery-places>
            </div>
        </section>
    </article>
@endsection
