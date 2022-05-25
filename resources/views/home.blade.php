<?php
    $lazy = True;
?>
@extends('layouts.app')

@section('content')
<main class="home">
    <article class="home__welcome">
        @if (count($products) != 0)
            <section class="home__welcome__box">
                <h2>Przeglądaj niesamowite produkty</h2>
                <span class="button dark">Przeglądaj</span>
            </section>
        @endif
    </article>
</main>
@include('partials.search')
@include('partials.products')
<script>
    document.querySelector('.home__welcome__box span').addEventListener('click', (e) => {
        window.scrollTo(0, document.querySelector('.products').offsetTop - 30)
    })
</script>
@endsection
