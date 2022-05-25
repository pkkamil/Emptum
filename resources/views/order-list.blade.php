<?php
    $title = "Lista zamówień";
?>
@extends('layouts.app')

@section('content')
<article class="admin">
    <section class="admin__content">
        <div class="admin__content__main">
            <h2>Przeglądanie listy zamówień</h2>
            <a href="{{ url('/admin') }}" class="back">Powrót</a>
        </div>
        <div class="admin__content__orders">
            <section class="table">
                <div class="th id">#</div>
                <div class="th">Kod</div>
                <div class="th email">email</div>
                <div class="th status">Status</div>
                <div class="th total">Wartość</div>
                <div class="th date">Data zamówienia</div>
                <div class="th right">Operacje</div>
                @foreach ($orders as $i)
                    <div class="td id">{{ $loop -> iteration + ($orders->links()->paginator->perPage() * ($orders->links()->paginator->currentPage() - 1)) }}</div>
                    <div class="td">{{ $i -> code }}</div>
                    <div class="td email">{{ $i -> email }}</div>
                    <div class="td status">
                        {{ $i -> status == 'ordered' ? 'Zamówiono' : '' }}
                        {{ $i -> status == 'accepted' ? 'Zaakceptowano' : '' }}
                        {{ $i -> status == 'sent' ? 'Wysłano' : '' }}
                        {{ $i -> status == 'delivered' ? 'Dostarczono' : '' }}
                        {{ $i -> status == 'cancelled' ? 'Anulowano' : '' }}
                    </div>
                    <div class="td total">{{ $i -> total }} <span class="grey">zł</span></div>
                    <div class="td date">{{ $i -> ordered_at }}</div>
                    <div class="td right">
                        <i class="far fa-trash-alt delete" data-order-id="{{ $i -> id }}"></i>
                        <a href="{{ url('/admin/zamowienia/'.$i -> id) }}"><i class="far fa-eye"></i></a>
                    </div>
                @endforeach
            </section>
        </div>
        {{ $orders->links('vendor.pagination.semantic-ui') }}
        <section class="confirmation">
            <section class="confirmation__box">
                <h4>Czy na pewno chcesz usunąć to zamówienie?</h4>
                <form method="POST" action="{{ route('deleteOrder') }}">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id" value="">
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
            document.querySelector('.confirmation input#order_id').value = el.getAttribute('data-order-id')
            document.querySelector('.confirmation').style.display = 'flex'
        })
    });

    document.querySelector('.cancel').addEventListener('click', () => {
        document.querySelector('.confirmation').style.display = 'none'
    })
</script>
@include('partials.search')
@endsection
