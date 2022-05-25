<?php
    $basket = true;
    $title = "Twój koszyk";
    $lazy = True;
?>
@extends('layouts.app')

@section('content')
<article class="cart">
    @if(isset($cart))
        <div id="app">
            <cart cart_id="{{ $cart[0] -> cart_id }}" _token="{{ csrf_token() }}"></cart>
        </div>
    @else
        <section class="cart__content">
            <h4 class="cart__content__information">Twój koszyk jest pusty</h4>
            <a href="/katalog" class="button dark">Kontynuuj zakupy</a>
            @include('partials.products')
        </section>
    @endif
</article>
@include('partials.search')
@endsection
