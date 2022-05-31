<?php
    $title = "Ustawienia strony";
    $lazy = True;
?>
@extends('layouts.app')
@section('content')
    <article class="admin">
        <section class="admin__content">
            <div class="admin__content__main">
                <h2>Edytowanie ustawień strony</h2>
                <a href="{{ url('/admin') }}" class="back">Powrót</a>
            </div>
            <div id="app">
                <settings user_id="{{ Auth::id() }}" _token="{{ csrf_token() }}"></settings>
            </div>
        </section>
    </article>
@endsection
