<template>
    <article class="results">
        <section class="results__box">
            <h4>Rezultaty wyszukiwania</h4>
            <form autocomplete="off" method="GET" @submit.prevent=submit>
                <label class="results__box__search" for="q">
                    <input type="text" placeholder="Szukaj" name="q" id="q" autocomplete="OFF" required v-model="q">
                    <button><i class="fas fa-search"></i></button>
                </label>
            </form>
            <section class="results__box__details">
                <label for="sortBy">Sortuj: </label>
                <select name="sortBy" id="sortBy" v-model="sortBy" @change="onChange" required>
                    <option value="NR">Nazwa: Rosnąco</option>
                    <option value="NM">Nazwa: Malejąco</option>
                    <option value="CR">Cena: Rosnąco</option>
                    <option value="CM">Cena: Malejąco</option>
                    <option value="DR">Data: Rosnąco</option>
                    <option value="DM">Data: Malejąco</option>
                </select>
                <span class="grey">{{ products.length }} <p v-if="products.length == 1">produkt</p><p v-if="products.length > 1 & products.length < 5">produkty</p><p v-if="products.length > 4 || products.length == 0">produktów</p></span>
            </section>
            <section class="results__box__list">
                <a :href="product.link" class="results__box__list__single"  v-for="product in products" :key="product.id">
                    <div class="results__box__list__single__image">
                        <img :src="product.image" :alt="product.name" loading="lazy">
                    </div>
                    <span>{{ product.name }}</span>
                    <span>{{ product.price }} <span class="grey">zł</span></span>
                </a>
            </section>
            <section class="results__box__not-found" v-if="loading == false & products.length == 0">
                Nie znaleziono produktu o podanej frazie.
            </section>
            <section class="widget" v-show="widget">
                <div class="widget__upper">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span class="status">Wystąpił błąd! Spróbuj ponownie później!</span>
                    <i class="fas fa-times close" @click="this.widget = false;"></i>
                </div>
            </section>
        </section>
    </article>
</template>
<script>
    export default {
        data() {
            return {
                products: [],
                product: {
                    id: '',
                    name: '',
                    image: '',
                    description: '',
                    price: 0.00,
                    link: '',
                },
                q: '',
                sortBy: 'NR',
                widget: false,
                loading: true,
            };
        },
        mounted() {
            let url = new URL(window.location.href);
            this.q = url.searchParams.get('q');

            let sort = url.searchParams.get('sortBy');
            if (sort) {
                this.sortBy = sort;
            }
            fetch('/api/search/' + this.q + '/' + this.sortBy)
                .then(res => {
                    if (res.status != 200) {
                        if (res.status == 401)
                            document.querySelector('.widget .status').textContent = 'Wystąpił błąd! Brak autoryzacji!';
                        else if (res.status == 429)
                            document.querySelector('.widget .status').textContent = 'Zbyt wiele zapytań! Zwolnij!';
                    else
                        document.querySelector('.widget .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                    }
                    return res;
                })
                .then(res => res.json())
                .then(res => {
                    this.products = res;
                    this.loading = false
                })
                .catch(err => {
                    this.widget = true;
                });
        },
        methods: {
            submit() {
                this.loading = true
                let url = new URL(window.location.href);
                let previous = url.searchParams.get('q');

                if (this.q == previous)
                    return 0

                let queryParams = new URLSearchParams(window.location.search);
                queryParams.set("q", this.q);
                history.replaceState(null, null, "?"+queryParams.toString());

                fetch('/api/search/' + this.q + '/' + this.sortBy)
                    .then(res => {
                        if (res.status != 200) {
                            if (res.status == 401)
                                document.querySelector('.widget .status').textContent = 'Wystąpił błąd! Brak autoryzacji!';
                            else if (res.status == 429)
                                document.querySelector('.widget .status').textContent = 'Zbyt wiele zapytań! Zwolnij!';
                        else
                            document.querySelector('.widget .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                        }
                        return res;
                    })
                    .then(res => res.json())
                    .then(res => {
                        this.products = res;
                    })
                    .catch(err => {
                        this.widget = true;
                    });
                this.loading = false
            },
            onChange() {
                let url = new URL(window.location.href);
                let queryParams = new URLSearchParams(window.location.search);
                queryParams.set("sortBy", this.sortBy);
                history.replaceState(null, null, "?"+queryParams.toString());
                if (this.products.length > 1) {
                    fetch('/api/search/' + url.searchParams.get('q') + '/' + this.sortBy)
                        .then(res => {
                            if (res.status != 200) {
                                if (res.status == 401)
                                    document.querySelector('.widget .status').textContent = 'Wystąpił błąd! Brak autoryzacji!';
                                else if (res.status == 429)
                                    document.querySelector('.widget .status').textContent = 'Zbyt wiele zapytań! Zwolnij!';
                            else
                                document.querySelector('.widget .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                            }
                            return res;
                        })
                        .then(res => res.json())
                        .then(res => {
                            this.products = res;
                        })
                        .catch(err => {
                            this.widget = true;
                        });
                }
            }
        }
    }
</script>
