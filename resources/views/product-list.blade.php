<?php
    $title = "Lista produktów";
?>
@extends('layouts.app')

@section('content')
<article class="admin">
    <section class="admin__content">
        <div class="admin__content__main">
            <h2>Zarządzanie listą produktów</h2>
            <a href="{{ url('/admin') }}" class="back">Powrót</a>
        </div>
        <div class="admin__content__products">
            <section class="table">
                <div class="th id">#</div>
                <div class="th name">Nazwa produktu</div>
                <div class="th quantity">Ilość</div>
                <div class="th price">Cena</div>
                <div class="th date">Data dodania</div>
                <div class="th right">Operacje</div>
                @foreach ($products as $i)
                    <div class="td id">{{ $loop -> iteration + ($products->links()->paginator->perPage() * ($products->links()->paginator->currentPage() - 1))  }}</div>
                    <div class="td name">{{ $i -> name }}</div>
                    <div class="td quantity">{{ $i -> quantity }}</div>
                    <div class="td price">{{ $i -> price }} <span class="grey">zł</span></div>
                    <div class="td date">{{ $i -> created_at }}</div>
                    <div class="td right">
                        <i class="far fa-trash-alt delete" data-product-id="{{ $i -> id }}"></i>
                        <a href="{{ url('/admin/produkty/'.$i -> id) }}"><i class="far fa-eye"></i></a>
                    </div>
                @endforeach
            </section>
        </div>
        {{ $products->links('vendor.pagination.semantic-ui') }}
        <section class="confirmation">
            <section class="confirmation__box">
                <h4>Czy na pewno chcesz usunąć ten produkt?</h4>
                <form method="POST" action="{{ route('deleteProduct') }}">
                    @csrf
                    <input type="hidden" name="product_id" id="product_id" value="">
                    <button type="submit" class="button-small dark danger">Tak</button>
                    <span class="button button-small dark cancel">Nie</span>
                </form>
            </section>
        </section>
    </section>
</article>
<script>
    document.querySelectorAll('.delete').forEach(el => {
        el.addEventListener('click', () => {
            document.querySelector('.confirmation input#product_id').value = el.getAttribute('data-product-id')
            document.querySelector('.confirmation').style.display = 'flex'
        })
    });

    document.querySelector('.cancel').addEventListener('click', () => {
        document.querySelector('.confirmation').style.display = 'none'
    })
</script>
@include('partials.search')
@endsection
