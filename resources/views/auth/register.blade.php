@extends('layouts.app')

@section('content')
<article class="auth">
    <section class="auth__box">
        <h2>Rejestracja</h2>
        <form method="POST" action="{{ route('register') }}" class="auth__box__form">
            @csrf
            <div class="auth__box__form__two">
                <label for="name" class="auth__box__form__two__input-small">
                    <input @error('name') class="incorrect" @enderror type="text" name="name" id="name" placeholder="Imię" value="{{ old('name') }}"  autocomplete="OFF" required autofocus>
                </label>
                <label for="surname" class="auth__box__form__two__input-small">
                    <input @error('surname') class="incorrect" @enderror type="text" name="surname" id="surname" placeholder="Nazwisko" value="{{ old('surname') }}"  autocomplete="OFF" required>
                </label>
            </div>
            @error('name')
                <span class="auth__box__form__incorrect" role="alert">{{ $message }}</span>
            @enderror
            @error('surname')
                <span class="auth__box__form__incorrect" role="alert">{{ $message }}</span>
            @enderror
            <label for="email" class="auth__box__form__input">
                <input @error('email') class="incorrect" @enderror type="email" name="email" id="email" placeholder="Adres email" value="{{ old('email') }}" required autocomplete="email">
            </label>
            @error('email')
                <span class="auth__box__form__incorrect" role="alert">{{ $message }}</span>
            @enderror
            <label for="password" class="auth__box__form__input">
                <input @error('password') class="incorrect" @enderror type="password" name="password" id="password" placeholder="Hasło" required autocomplete="new-password">
            </label>
            <label for="password_confirmation" class="auth__box__form__input">
                <input @error('password') class="incorrect" @enderror type="password" name="password_confirmation" id="password_confirmation" placeholder="Potwierdzenie hasła" required autocomplete="new-password">
            </label>
            @error('password')
                <span class="auth__box__form__incorrect" role="alert">{{ $message }}</span>
            @enderror
            <button type="submit" class="dark">Stwórz</button>
            <a href="{{ url('/logowanie') }}">Posiadasz już konto?</a>
        </form>
    </section>
</article>
@include('partials.search')
@endsection
