<nav class="navbar">
    <div class="navbar__content">
        <i class="fas fa-bars navbar__content__menu navbar__content__menu__open"></i>
        <i class="fas fa-times navbar__content__menu navbar__content__menu__close"></i>
        <div class="navbar__content__title">
            <a href="{{ url('/') }}">Emptum</a>
        </div>
        @if (!isset($order_page))
            <ul class="navbar__content__links">
            <li><a href="{{ url('/katalog') }}">Katalog produktów</a></li>
            <li><a href="{{ url('/kontakt') }}">Kontakt</a></li>
            </ul>
            <div class="navbar__content__icons">
                @if (!isset($search))
                    <span class="navbar__content__icons__search"><i class="fas fa-search"></i></span>
                @endif
                @guest
                    <a href="{{ url('/logowanie') }}"><i class="far fa-user"></i></a>
                @endguest
                @auth
                    <a href="{{ url('/konto') }}"><i class="far fa-user"></i></a>
                @endauth
                <a href="{{ url('/koszyk') }}"><i class="fab fa-opencart"></i></a>
            </div>
        @else
            <div class="navbar__content__icons">
                <a href="{{ url('/koszyk') }}" class="back">Wróć do koszyka</a>
            </div>
        @endif
    </div>
</nav>
<nav class="navbar--mobile">
    <article class="navbar--mobile__links">
        <section class="navbar--mobile__links__single">
            <a href="{{ url('/') }}"><i class="fas fa-home"></i></a>
        </section>
        <section class="navbar--mobile__links__single">
            <a href="{{ url('/katalog') }}"><i class="fas fa-book-open"></i></a>
        </section>
        <section class="navbar--mobile__links__single">
            <a href="{{ url('/kontakt') }}"><i class="fas fa-phone"></i></a>
        </section>
        <section class="navbar--mobile__links__single navbar--mobile__links__single--search">
            <i class="fas fa-search"></i>
        </section>
        <section class="navbar--mobile__links__single">
            @guest
                <a href="{{ url('/logowanie') }}"><i class="far fa-user"></i></a>
            @endguest
            @auth
                <a href="{{ url('/konto') }}"><i class="far fa-user"></i></a>
            @endauth
        </section>
        <section class="navbar--mobile__links__single">
            <a href="{{ url('/koszyk') }}"><i class="fab fa-opencart"></i></a>
        </section>
    </article>
</nav>
