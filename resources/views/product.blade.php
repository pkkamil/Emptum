<?php
    $title = $product -> name;
?>
@extends('layouts.app')

@section('content')
<article class="product">
    <section class="product__content">
        <img src="{{ $product -> image }}" alt="">
        <section class="product__content__informations">
            <h3>{{ $product -> name }}</h3>
            <span class="price">{{ $product -> price }} <span class="grey">zł</span></span>
            <span class="small">Cena za 1 sztukę</span>
            <form autocomplete="off">
                <span>Ilość:</span>
                <div id="app">
                    <manage-quantity product_id="{{ $product -> id }}"></manage-quantity>
                </div>
                <button class="bright" type="submit">Dodaj do koszyka</button>
                <span class="button dark buy_now">Kup teraz</span>
            </form>
            <section class="product__content__informations__details">
                @foreach (explode(',', $product -> description) as $i)
                    <span>{{ $i }}</span>
                @endforeach
            </section>
        </section>
        <section class="widget widget-product">
            <div class="widget__upper c">
                <i class="fas fa-check icon"></i>
                <span class="status">Dodano produkt do koszyka</span>
                <i class="fas fa-times close"></i>
            </div>
            <div class="widget__product">
                <img class="miniature" src="{{ $product -> image }}" alt="">
                <span>{{ $product -> name }}</span>
            </div>
            <a href="{{ url('/koszyk') }}" class="bright">Przejdź do koszyka</a>
            <a href="{{ url('/zamowienie') }}" class="button dark">Zamówienie</a>
            <span class="close">Kontynuuj zakupy</span>
        </section>
        <section class="dimmer-widget"></section>
    </section>
</article>
<script>
    document.querySelector('.widget__upper .close').addEventListener('click', () => {
        document.querySelector('.widget-product').style.display = 'none'
        if (window.screen.width <= 768)
            document.querySelector('.dimmer-widget').style.display = 'none'
        document.querySelector('.product__content__informations form button').disabled = false
    })

    document.querySelector('.widget span.close').addEventListener('click', () => {
        document.querySelector('.widget-product').style.display = 'none'
        if (window.screen.width <= 768)
            document.querySelector('.dimmer-widget').style.display = 'none'
        document.querySelector('.product__content__informations form button').disabled = false
    })

    // POST

    document.querySelector('.product__content__informations form button').addEventListener('click', (e) => {
        e.preventDefault()
        $.ajax('/api/add-to-cart', {
            type: 'POST',
            data: {
                "product_id": "{{ $product -> id }}",
                "user_id": "{{ Auth::id() }}",
                "quantity": document.querySelector('.product__content__informations__items input').value,

            },
            success: function (data, status, xhr) {
                document.querySelector('.widget__upper .icon').classList.remove('fa-check')
                document.querySelector('.widget__upper .icon').classList.remove('fa-info-circle')
                document.querySelector('.widget__upper .icon').classList.remove('fa-exclamation-triangle')
                if (data.status == 200) {
                    document.querySelector('.widget__upper .status').textContent = 'Dodano produkt do koszyka';
                    document.querySelector('.widget__upper .icon').classList.add('fa-check')
                } else if (data.status == 'error') {
                    document.querySelector('.widget__upper .status').textContent = data.message;
                    document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                } else if (data.status == 'warning') {
                    document.querySelector('.widget__upper .status').textContent = data.message;
                    document.querySelector('.widget__upper .icon').classList.add('fa-info-circle')
                } else if (data.status == 'tryAgain') {
                    document.querySelector('.widget__upper .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                    document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                }
                document.querySelector('.widget-product').style.right = (window.screen.width - document.querySelector('.navbar__content').offsetWidth + 100) / 2 + 'px'
                if (window.screen.width <= 768)
                    document.querySelector('.dimmer-widget').style.display = 'block'
                document.querySelector('.widget-product').style.display = 'block'
                document.querySelector('.product__content__informations form button').disabled = true
            },
            error: function (data, error) {
                document.querySelector('.widget-product').style.right = (window.screen.width - document.querySelector('.navbar__content').offsetWidth + 100) / 2 + 'px'
                if (window.screen.width <= 768)
                    document.querySelector('.dimmer-widget').style.display = 'block'
                document.querySelector('.widget__upper .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                document.querySelector('.widget__upper .icon').classList.remove('fa-check')
                document.querySelector('.widget-product').style.display = 'block'
                document.querySelector('.product__content__informations form button').disabled = true
            }
        });
    })

    if (window.screen.width <= 768) {
        document.addEventListener('mouseup', (e) => {
            if (!document.querySelector('.widget-product').contains(e.target)) {
                document.querySelector('.widget-product').style.display = 'none'
                document.querySelector('.dimmer-widget').style.display = 'none'
                document.querySelector('.product__content__informations form button').disabled = false
            }
        })
    }

    document.querySelector('.product__content__informations form .buy_now').addEventListener('click', (e) => {
        e.preventDefault()
        $.ajax('/api/add-to-cart', {
            type: 'POST',
            data: {
                "product_id": "{{ $product -> id }}",
                "user_id": "{{ Auth::id() }}",
                "quantity": document.querySelector('.product__content__informations__items input').value,

            },
            success: function (data, status, xhr) {
                document.querySelector('.widget__upper .icon').classList.remove('fa-check')
                document.querySelector('.widget__upper .icon').classList.remove('fa-info-circle')
                document.querySelector('.widget__upper .icon').classList.remove('fa-exclamation-triangle')
                if (data.status == 200) {
                    window.location.href = '/zamowienie'
                } else if (data.status == 'error') {
                    document.querySelector('.widget__upper .status').textContent = data.message;
                    document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                    document.querySelector('.widget-product').style.display = 'block'
                    document.querySelector('.product__content__informations form button').disabled = true
                } else if (data.status == 'warning') {
                    document.querySelector('.widget__upper .status').textContent = data.message;
                    document.querySelector('.widget__upper .icon').classList.add('fa-info-circle')
                    document.querySelector('.widget-product').style.display = 'block'
                    document.querySelector('.product__content__informations form button').disabled = true
                } else if (data.status == 'tryAgain') {
                    document.querySelector('.widget__upper .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                    document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                    document.querySelector('.widget-product').style.display = 'block'
                    document.querySelector('.product__content__informations form button').disabled = true
                }
                if (window.screen.width <= 768)
                    document.querySelector('.dimmer-widget').style.display = 'block'
            },
            error: function (data, error) {
                document.querySelector('.widget__upper .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                document.querySelector('.widget__upper .icon').classList.remove('fa-check')
                document.querySelector('.widget-product').style.display = 'block'
                if (window.screen.width <= 768)
                    document.querySelector('.dimmer-widget').style.display = 'block'
                document.querySelector('.product__content__informations form button').disabled = true
            }
        });
    })
</script>
@include('partials.search')
@endsection
