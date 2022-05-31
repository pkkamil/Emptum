<?php
    $title = "Zamówienie użytkownika o nr ".$order -> code;
    $lazy = True;
?>
@extends('layouts.app')

@section('content')
<article class="order">
    <section class="order__content order-view">
        <h2>Zamówienie o&nbsp;nr <span class="grey">{{ $order -> code }}</span></h2>
        <a href="{{ url('/admin/zamowienia') }}" class="back">Powrót</a>
        <section class="order__content--details">
            <section class="order__content__first-column">
                <h4>Metoda dostawy</h4>
                <div class="order__content__first-column delivery">
                    @if ($order -> delivery_method == 'pickup_in_person')
                        <label for="delivery1" class="order__content__first-column delivery__input">
                            <i class="fas fa-store-alt"></i> Odbiór osobisty
                        </label>
                    @else
                        <label for="delivery2" class="order__content__first-column delivery__input">
                            <i class="fas fa-truck"></i> Przesyłka kurierska
                        </label>
                    @endif
                </div>
                @if ($order -> delivery_method == 'pickup_in_person')
                    <h4>Miejsce odbioru</h4>
                    <div class="order__content__first-column place">
                        <label for="place" class="order__content__first-column place input">
                            <div class="order__content__first-column place__details">
                                <span>{{ $order -> deliveryPlace -> name }}</span>
                                <span>{{ $order -> deliveryPlace -> city }}</span>
                                <span>{{ $order -> deliveryPlace -> street . ' '. $order -> deliveryPlace -> house_number }}{{ $order -> deliveryPlace -> apartment_number ? '/'.$order -> deliveryPlace -> apartment_number : '' }}</span>
                            </div>
                        </label>
                    </div>
                @endif
                <h4>Metoda płatności</h4>
                <div class="order__content__first-column payment">
                    <label for="payment1" class="order__content__first-column payment input">
                        Płatność przy odbiorze
                    </label>
                </div>
            </section>
            @if ($order -> purchaser_type == 'person')
                <section class="order__content__second-column">
                    <h4>Informacje o zamawiającym</h4>
                    <div class="order__content__second-column type">
                        <label for="type1" class="order__content__second-column type__input">
                            <i class="far fa-user"></i> Osoba fizyczna
                        </label>
                    </div>
                    <div class="order__content__second-column two px0">
                        <label for="name" class="order__content__second-column two__input-small">
                            <input type="text" name="name" id="name" value="{{ $order -> name }}" placeholder="Imię" disabled>
                        </label>
                        <label for="surname" class="order__content__second-column two__input-small">
                            <input type="text" name="surname" id="surname" value="{{ $order -> surname }}" placeholder="Nazwisko" disabled>
                        </label>
                    </div>
                    <label for="email" class="order__content__second-column input">
                        <input type="text" name="email" id="email" value="{{ $order -> email }}" placeholder="Adres email" disabled>
                    </label>
                    <label for="telephone" class="order__content__second-column input">
                        <input type="text" name="telephone" id="telephone" value="{{ $order -> telephone }}" placeholder="Numer telefonu" disabled>
                    </label>
                    <label for="street" class="order__content__second-column input">
                        <input type="text" name="street" id="street" value="{{ $order -> street }}" placeholder="Ulica" disabled>
                    </label>
                    <div class="order__content__second-column three">
                        <label for="house_number" class="order__content__second-column three__input-small">
                            <input type="text" name="house_number" id="house_number" value="{{ $order -> house_number }}" placeholder="Nr domu" disabled>
                        </label>
                        <label for="apartment_number" class="order__content__second-column three__input-small">
                            <input type="text" name="apartment_number" id="apartment_number" value="{{ $order -> apartment_number }}" placeholder="Nr lokalu" disabled>
                        </label>
                        <label for="zip_code" class="order__content__second-column three__input-small">
                            <input type="text" name="zip_code" id="zip_code" value="{{ $order -> zip_code }}" placeholder="Kod pocztowy" disabled>
                        </label>
                    </div>
                    <label for="city" class="order__content__second-column input">
                        <input type="text" name="city" id="city" value="{{ $order -> city }}" placeholder="Miejscowość" disabled>
                    </label>
                </section>
            @else
                <section class="order__content__second-column" v-if="purchaser.type == 'company'">
                    <h4>Informacje o zamawiającym</h4>
                    <div class="order__content__second-column type">
                        <label for="type2" class="order__content__second-column type__input">
                            <i class="far fa-building"></i> Firma
                        </label>
                    </div>
                    <label for="company_name" class="order__content__second-column type__input px0">
                        <input type="text" name="company_name" id="company_name" value="{{ $order -> company_name }}" placeholder="Nazwa firmy" disabled>
                    </label>
                    <label for="nip_code" class="order__content__second-column type__input">
                        <input type="text" name="nip_code" id="nip_code" value="{{ $order -> nip_code }}" placeholder="NIP" disabled>
                    </label>
                    <div class="order__content__second-column two">
                        <label for="name" class="order__content__second-column two__input-small">
                            <input type="text" name="name" id="name" value="{{ $order -> name }}" placeholder="Imię" disabled>
                        </label>
                        <label for="surname" class="order__content__second-column two__input-small">
                            <input type="text" name="surname" id="surname" value="{{ $order -> surname }}" placeholder="Nazwisko" disabled>
                        </label>
                    </div>
                    <label for="email" class="order__content__second-column input">
                        <input type="text" name="email" id="email" value="{{ $order -> email }}" placeholder="Adres email" disabled>
                    </label>
                    <label for="telephone" class="order__content__second-column input">
                        <input type="text" name="telephone" id="telephone" value="{{ $order -> telephone }}" placeholder="Numer telefonu" disabled>
                    </label>
                    <label for="street" class="order__content__second-column input">
                        <input type="text" name="street" id="street" value="{{ $order -> street }}" placeholder="Ulica" disabled>
                    </label>
                    <div class="order__content__second-column three">
                        <label for="house_number" class="order__content__second-column three__input-small">
                            <input type="text" name="house_number" id="house_number" value="{{ $order -> house_number }}" placeholder="Nr domu" disabled>
                        </label>
                        <label for="apartment_number" class="order__content__second-column three__input-small">
                            <input type="text" name="apartment_number" id="apartment_number" value="{{ $order -> apartment_number }}" placeholder="Nr lokalu" disabled>
                        </label>
                        <label for="zip_code" class="order__content__second-column three__input-small">
                            <input type="text" name="zip_code" id="zip_code" value="{{ $order -> zip_code }}" placeholder="Kod pocztowy" disabled>
                        </label>
                    </div>
                    <label for="city" class="order__content__second-column input">
                        <input type="text" name="city" id="city" value="{{ $order -> city }}" placeholder="Miejscowość" disabled>
                    </label>
                </section>
            @endif
            <section class="order__content__third-column">
                @if ($order -> comment != NULL)
                    <h4>Dodatkowe uwagi</h4>
                    <label for="content" class="order__content__third-column textarea">
                        <textarea name="comment" id="comment" placeholder="Uwagi" disabled>{{ $order -> comment }}</textarea>
                    </label>
                @endif
                <h4>Podsumowanie</h4>
                <div class="order__content__third-column__table">
                    @foreach ($order -> cart -> products as $product)
                        <div class="order__content__third-column__table__single">
                            <div class="td">
                                <a href="{{ \App\Product::find($product -> product_id) -> link }}">
                                    <img src="{{ \App\Product::find($product -> product_id) -> image }}" alt="">
                                </a>
                            </div>
                            <div class="td">
                                <a href="{{ \App\Product::find($product -> product_id) -> link }}">
                                    <span>{{ \App\Product::find($product -> product_id) -> name }}</span>
                                </a>
                            </div>
                            <div class="td">
                                <span>{{ $product -> items }}
                                    @if ($product -> items == 1)
                                        <p>sztuka</p>
                                    @elseif ($product -> items > 1 & $product -> items < 5)
                                        <p>sztuki</p>
                                    @else
                                        <p>sztuk</p>
                                    @endif
                                </span>
                            </div>
                            <div class="td price">
                                <span>{{ $product -> price}} <span class="grey">zł</span></span>
                            </div>
                        </div>
                    @endforeach
                    @if ($order -> delivery_method == 'courier')
                        <div class="order__content__third-column__table__single delivery-price">
                            <div class="td">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="td">
                                <span>Przesyłka kurierska</span>
                            </div>
                            <div></div>
                            <div class="td price">
                                <span>{{ $order -> delivery_price }} <span class="grey">zł</span></span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="order__content__third-column__informations">
                    <div id="app">
                        <order-status user_id="{{ Auth::id() }}" order_id="{{ $order -> id }}" _token="{{ csrf_token() }}" previous_status="{{ $order -> status }}"></order-status>
                    </div>
                    <span class="ordered_at"><b>Data zamówienia:</b> {{ $order -> ordered_at }}</span>
                </div>
                <div class="order__content__third-column__summary">
                    <span class="grey">Łącznie</span>
                    <span class="price">{{ $order -> total }} <p class="grey">zł</p></span>
                    <span class="small">W cenie zawarto podatek VAT</span>
                </div>
            </section>
        </section>
    </section>
</article>
@include('partials.search')
@endsection
