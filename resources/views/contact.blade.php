<?php
    $title = "Kontakt";
?>
@extends('layouts.app')

@section('content')
<article class="contact">
    <section class="contact__box">
        <h2>Skontaktuj się z nami!</h2>
        <form action="" autocomplete="OFF" class="contact__box__form">
            @csrf
            <label for="name" class="contact__box__form__input">
                <input type="text" name="name" id="name" placeholder="Imię" @auth value="{{ Auth::user() -> name }}" @endauth autocomplete="OFF" required>
            </label>
            <label for="surname" class="contact__box__form__input">
                <input type="text" name="surname" id="surname" placeholder="Nazwisko" @auth value="{{ Auth::user() -> surname }}" @endauth autocomplete="OFF" required>
            </label>
            <label for="email" class="contact__box__form__input">
                <input type="email" name="email" id="email" placeholder="Adres email" @auth value="{{ Auth::user() -> email }}" @endauth autocomplete="OFF" required>
            </label>
            <label for="telephone" class="contact__box__form__input">
                <input type="text" name="telephone" id="telephone" placeholder="Numer telefonu" @auth value="{{ Auth::user() -> telephone }}" @endauth autocomplete="OFF">
            </label>
            <label for="content" class="contact__box__form__input__textarea">
                <textarea name="content" id="content" placeholder="Wiadomość" required minlength="10"></textarea>
            </label>
            <button type="submit" class="dark">Wyślij wiadomość</button>
        </form>
    </section>
</article>
@include('partials.search')
@endsection
