<?php
    $order = true;
    $title = "Zanim zamówisz";
?>
@extends('layouts.app')

@section('content')
<article class="before-order">
    <section class="before-order__content">
        <section class="before-order__content__box">
            <h2>Nie masz konta?</h2>
            <a href="{{ url('/zamowienie') }}" class="button dark" onclick="event.preventDefault(); document.getElementById('form-before-order').submit();">Kontynuuj jako gość</a>
            <form id="form-before-order" action="{{ route('go-to-order') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <span class="grey">lub</span>
            <a href="{{ url('/rejestracja') }}" class="button bright">Załóż konto</a>
        </section>
        <section class="before-order__content__auth">
            <h2>Logowanie</h2>
            <form method="POST" action="{{ route('order-login') }}" class="before-order__content__auth__form">
                @csrf
                <label for="email" class="before-order__content__auth__form__input">
                    <input @error('email') class="incorrect" @enderror type="email" name="email" id="email" placeholder="Adres email" value="{{ old('email') }}" required autocomplete="email">
                </label>
                <label for="password" class="before-order__content__auth__form__input">
                    <input @error('password') class="incorrect" @enderror type="password" name="password" id="password" placeholder="Hasło" required autocomplete="current-password">
                </label>
                @error('email')
                    <span class="before-order__content__auth__form__incorrect" role="alert">{{ $message }}</span>
                @enderror
                @error('password')
                    <span class="before-order__content__auth__form__incorrect" role="alert">{{ $message }}</span>
                @enderror
                <button type="submit" class="dark">Zaloguj</button>
                @if (Route::has('password.request'))
                    <a class="before-order__content__auth__form__reset" href="{{ route('password.request') }}">Zapomniałeś hasła?</a>
                @endif
            </form>
        </section>
    </section>
</article>
@endsection
