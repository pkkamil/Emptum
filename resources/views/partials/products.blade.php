<article class="products">
    @if (isset($catalog))
        <h4>Produkty</h4>
    @else
        <h4>Najczęściej kupowane produkty</h4>
    @endif
    <section class="products__list">
        @if (count($products) != 0)
            @foreach ($products as $product)
                <a href="{{ $product -> link }}" class="products__list__single">
                    <div class="products__list__single__image">
                        <img src="{{ $product -> image }}" alt="{{ $product -> name }}" loading="lazy">
                    </div>
                    <span>{{ $product -> name }}</span>
                    <span>{{ $product -> price }} <span class="grey">zł</span></span>
                </a>
            @endforeach
        @else
            <span class="empty">Obecnie żaden produkt nie znajduje się w sprzedaży!<br>Jak tylko zostaną dodane jakieś produkty, zobaczysz je tutaj!<br>Wróć później!</span>
        @endif
    </section>
</article>
