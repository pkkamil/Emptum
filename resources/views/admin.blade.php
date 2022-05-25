<?php
    $title = "Panel zarządzania";
?>
@extends('layouts.app')

@section('content')
<article class="admin">
    <section class="admin__content">
        <div class="admin__content__main">
            <h2>Panel zarządzania</h2>
            <a href="{{ url('/konto') }}" class="back">Powrót</a>
        </div>
        <div class="admin__content__start">
            <div class="admin__content__start__single">
                <h4>Dodaj nowy produkt</h4>
                <a href="{{ url('/admin/produkt/nowy') }}" class="button button-small dark">Nowy produkt</a>
            </div>
            @if ($carts > 0)
                <div class="admin__content__start__single">
                    <h4>Przejrzyj istniejące koszyki</h4>
                    <a href="{{ url('/admin/koszyki') }}" class="button button-small dark">Istniejące koszyki</a>
                </div>
            @endif
            @if ($orders > 0)
                <div class="admin__content__start__single">
                    <h4>Przejrzyj listę zamówień</h4>
                    <a href="{{ url('/admin/zamowienia') }}" class="button button-small dark">Lista zamówień</a>
                </div>
            @endif
            @if ($products > 0)
                <div class="admin__content__start__single">
                    <h4>Zarządzaj listą produktów</h4>
                    <a href="{{ url('/admin/produkty') }}" class="button button-small dark">Lista produktów</a>
                </div>
            @endif
        </div>
    </section>
</article>
@include('partials.search')
@endsection
