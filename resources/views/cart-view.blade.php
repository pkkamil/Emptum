<?php
    $basket = true;
    $title = "Koszyk użytkownika o tokenie ".$cart -> token;
?>
@extends('layouts.app')

@section('content')
<article class="cart">
    <section class="cart__content not-empty">
        <h2>Koszyk użytkownika o&nbsp;tokenie <span class="grey">{{ $cart -> token }}</span></h2>
        <a href="{{ url('/admin/koszyki') }}" class="back">Powrót</a>
        <section class="table">
            <div class="th imgname">Produkt</div>
            <div class="th items">Ilość</div>
            <div class="th price">Wartość</div>
            @foreach ($cart -> products as $product)
                <div class="td imgname">
                    <a href="{{ '/p/'.\App\Product::find($product -> product_id) -> link }}">
                        <img src="{{ \App\Product::find($product -> product_id) -> image }}" alt="" class="smaller">
                    </a>
                    <span>
                        <a href="{{ '/p/'.\App\Product::find($product -> product_id) -> link }}">
                            {{ \App\Product::find($product -> product_id) -> name }}
                        </a>
                    </span>
                </div>
                <div class="td items">
                    {{ $product -> items }}
                    @if ($product -> items == 1)
                        <p class="grey small">sztuka</p>
                    @elseif ($product -> items > 1 & $product -> items < 5)
                        <p class="grey small">sztuki</p>
                    @else
                        <p class="grey small">sztuk</p>
                    @endif
                </div>
                <div class="td price nmt">{{ $product -> price }}<span class="grey">zł</span></div>
            @endforeach
        </section>
        <section class="cart__content__informations">
            <span class="created_at">Data utworzenia: {{ $cart -> created_at }}</span>
            <span class="ordered">{{ $cart -> ordered == 1 ? 'Zamówiono powyższe produkty' : 'Jeszcze nie zamówiono powyższych produktów' }}</span>
            @if ($cart -> ordered == 0)
                <span class="button button-small dark delete">Usuń koszyk</span>
            @endif
        </section>
        <section class="cart__content__summary">
            <span class="grey">Łącznie</span>
            <span class="price">{{ $cart -> total }} <p class="grey">zł</p></span>
            <span class="small">W cenie zawarto podatek VAT</span>
        </section>
    </section>
    @if ($cart -> ordered == 0)
        <section class="confirmation">
            <section class="confirmation__box">
                <h4>Czy na pewno chcesz usunąć ten koszyk?</h4>
                <form method="POST" action="{{ route('deleteCart') }}">
                    @csrf
                    <input type="hidden" name="cart_id" value="{{ $cart -> id }}">
                    <button type="submit" class="button-small dark danger">Tak</button>
                    <span class="button button-small dark cancel">Nie</span>
                </form>
            </section>
        </section>
    @endif
</article>
@if ($cart -> ordered == 0)
    <script>
        document.querySelector('.delete').addEventListener('click', () => {
            document.querySelector('.confirmation').style.display = 'flex'
        })

        document.querySelector('.cancel').addEventListener('click', () => {
            document.querySelector('.confirmation').style.display = 'none'
        })
    </script>
@endif
@include('partials.search')
@endsection
