@extends('layouts.app')

@section('content')
<article class="auth">
    <section class="auth__box">
        <h2>Resetowanie hasła</h2>
        <span class="auth__box__subheader">Wyślemy do Ciebie wiadomość z hiperłączem do odzyskania hasła</span>
        @if (session('status'))
            <div class="auth__box__status" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}" class="auth__box__form">
            @csrf
            <label for="email" class="auth__box__form__input">
                <input @error('email') class="incorrect" @enderror type="email" name="email" id="email" placeholder="Adres email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </label>
            @error('email')
                <span class="auth__box__form__incorrect" role="alert">{{ $message }}</span>
            @enderror
            <button type="submit" class="dark">Zresetuj</button>
            <a href="{{ url('/logowanie') }}">Powrót</a>
        </form>
    </section>
</article>
@include('partials.search')
@endsection
