<?php
    $title = "Konto";
    $lazy = True;
?>
@extends('layouts.app')

@section('content')
<article class="account">
    <section class="account__content">
        <div class="account__content__main">
            <h2>Twoje konto</h2>
            <a href="{{ url('/wyloguj') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i class="fas fa-user"></i> Wyloguj</a>
            <form id="frm-logout" action="{{ route('logout-user') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            @if (Auth::user() -> role == 'admin')
                <br>
                <a href="{{ url('/admin') }}" class="panel"><i class="fas fa-tools"></i> Panel zarządzania</a>
            @endif
        </div>
        <div class="account__content__bottom">
            @if (count($orders) > 0)
                <div id="app">
                    <order-list user_id="{{ Auth::id() }}" _token="{{ csrf_token() }}"></order-list>
                </div>
            @else
                <div class="account__content__bottom__orders">
                    <h4>Historia zamówień</h4>
                    <p class="nothing-ordered">Nie zamówiłeś jeszcze żadnego produktu.</p>
                    <a href="{{ url('/katalog') }}" class="button dark">Katalog</a>
                </div>
            @endif
            <div class="account__content__bottom__informations">
                <h4>Informacje o koncie</h4>
                @if (count($addresses) == 0)
                    <a href="{{ url('/adresy') }}"><i class="fas fa-home"></i> Twoje adresy (0)</a>
                @else
                    <div class="account__content__bottom__informations__default">
                        <span>{{ $addresses[0] -> name.' '.$addresses[0] -> surname }}</span>
                        <span>{{ $addresses[0] -> street.' '.$addresses[0] -> house_number }}{{ $addresses[0] -> apartment_number ? '/'.$addresses[0] -> apartment_number : '' }}</span>
                        <span>{{ $addresses[0] -> zip_code.' '.$addresses[0] -> city }}</span>
                    </div>
                    <a href="{{ url('/adresy') }}"><i class="fas fa-home"></i> Twoje adresy ({{ count($addresses) }})</a>
                @endif
            </div>
        </div>
    </section>
</article>
@include('partials.search')
@endsection
