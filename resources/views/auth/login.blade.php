@extends('layouts.app')

@section('content')
<article class="auth">
    <section class="auth__box">
        <h2>Logowanie</h2>
        <form method="POST" action="{{ route('login') }}" class="auth__box__form">
            @csrf
            <label for="email" class="auth__box__form__input">
                <input @error('email') class="incorrect" @enderror type="email" name="email" id="email" placeholder="Adres email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </label>
            <label for="password" class="auth__box__form__input">
                <input @error('password') class="incorrect" @enderror type="password" name="password" id="password" placeholder="Hasło" required autocomplete="current-password">
            </label>
            @error('email')
                <span class="auth__box__form__incorrect" role="alert">{{ $message }}</span>
            @enderror
            @error('password')
                <span class="auth__box__form__incorrect" role="alert">{{ $message }}</span>
            @enderror
            <span class="auth__box__form__remember">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Zapamiętaj</label>
            </span>
            <button type="submit" class="dark">Zaloguj</button>
            <a class="auth__box__form__reset" href="{{ url('/resetowanie') }}">Zapomniałeś hasła?</a>
            <a href="{{ url('/rejestracja') }}">Nie masz jeszcze konta?</a>
        </form>
    </section>
</article>
@include('partials.search')
@endsection
