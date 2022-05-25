<?php
    $title = "Lista koszyków";
?>
@extends('layouts.app')

@section('content')
<article class="admin">
    <section class="admin__content">
        <div class="admin__content__main">
            <h2>Przeglądanie istniejących koszyków</h2>
            <a href="{{ url('/admin') }}" class="back">Powrót</a>
        </div>
        <div class="admin__content__carts">
            <section class="table">
                <div class="th id">#</div>
                <div class="th token">Token</div>
                <div class="th user">Użytkownik</div>
                <div class="th total">Wartość</div>
                <div class="th ordered">Zamówiono</div>
                <div class="th date">Data utworzenia</div>
                <div class="th right">Operacje</div>
                @foreach ($carts as $i)
                    <div class="td id">{{ $loop -> iteration + ($carts->links()->paginator->perPage() * ($carts->links()->paginator->currentPage() - 1)) }}</div>
                    <div class="td token">{{ $i -> token }}</div>
                    <div class="td user">{{ $i -> user_id != null ? 'TAK' : 'NIE' }}</div>
                    <div class="td total">{{ $i -> total }} <span class="grey">zł</span></div>
                    <div class="td ordered">{{ $i -> ordered == 1 ? 'TAK' : 'NIE'  }}</div>
                    <div class="td date">{{ $i -> created_at }}</div>
                    <div class="td right">
                        @if ($i -> ordered == 0)
                            <i class="far fa-trash-alt delete" data-cart-id="{{ $i -> id }}"></i>
                        @endif
                        <a href="{{ url('/admin/koszyki/'.$i -> id) }}"><i class="far fa-eye"></i></a>
                    </div>
                @endforeach
            </section>
        </div>
        {{ $carts->links('vendor.pagination.semantic-ui') }}
        <section class="confirmation">
            <section class="confirmation__box">
                <h4>Czy na pewno chcesz usunąć ten koszyk?</h4>
                <form method="POST" action="{{ route('deleteCart') }}">
                    @csrf
                    <input type="hidden" name="cart_id" id="cart_id" value="">
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
            document.querySelector('.confirmation input#cart_id').value = el.getAttribute('data-cart-id')
            document.querySelector('.confirmation').style.display = 'flex'
        })
    });

    document.querySelector('.cancel').addEventListener('click', () => {
        document.querySelector('.confirmation').style.display = 'none'
    })
</script>
@include('partials.search')
@endsection
