<template>
    <section class="cart__content not-empty">
        <h2>Twój koszyk</h2>
        <!-- <h2>Twój koszyk <i class="fas fa-sync" @click="showCart()"></i></h2> -->
        <section class="table">
            <div class="th">Produkt</div>
            <div class="th">Ilość</div>
            <div class="th price">Wartość</div>
            <template v-for="product in products">
                <div class="td imgname" :key="product.id + 'a'">
                    <a :href="product.link">
                        <img :src="product.image" alt="">
                    </a>
                    <span>
                        <a :href="product.link">{{ product.name }}</a>
                    </span>
                </div>
                <div class="td quantity" :key="product.id  + 'b'">
                    <label for="items" class="items">
                        <i class="fas fa-minus" @click="decrement(product)"></i>
                        <input type="number" v-model="product.items" :max="product.quantity" min="1" @input="input(product)" @change="change(product)">
                        <i class="fas fa-plus" @click="increment(product)"></i>
                    </label>
                    <i class="far fa-trash-alt trash" @click="remove(product)"></i>
                </div>
                <div class="td price" :key="product.id  + 'c'">{{ product.price }}<span class="grey"> zł</span></div>
            </template>
        </section>
        <section class="cart__content__summary">
            <span class="grey">Łącznie</span>
            <span class="price">{{ total ? total : '0.00' }} <p class="grey">zł</p></span>
            <span class="small">W cenie zawarto podatek VAT</span>
            <a href="/zamowienie" class="button dark">Przejdź do zamówienia</a>
        </section>
        <section class="widget" v-show="widget">
            <div class="widget__upper">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="status">Zbyt wiele zapytań!<p class="to-hide"> Zwolnij!</p></span>
                <i class="fas fa-times close" @click="widget = false"></i>
            </div>
        </section>
    </section>
</template>

<script>
    import debounce from 'lodash.debounce'
    export default {
        props: [
            'cart_id',
            '_token',
        ],
         data() {
            return {
                products: [],
                product: {
                    id: '',
                    name: '',
                    image: '',
                    link: '',
                    price: '',
                    quantity: 0,
                    items: 0,
                },
                total: 0.00,
                count: 0,
                loading: true,
                widget: false,
            };
        },
        created() {
            this.updateCart = debounce(this.updateCart, 1000)
        },
        mounted() {
            fetch('/api/get-products-from-cart/' + this.cart_id)
                .then(res => {
                    if (res.status != 200)
                        this.widget = true;
                    return res;
                })
                .then(res => res.json())
                .then(res => {
                    this.products = res;
                })
            fetch('/api/get-total/' + this.cart_id)
                .then(res => res.json())
                .then(res => {
                    this.total = parseFloat(res).toFixed(2);
                })
        },
        methods: {
            showCart() {
                fetch('/api/get-products-from-cart/' + this.cart_id)
                    .then(res => res.json())
                    .then(res => {
                        this.products = res;
                    })
                fetch('/api/get-total/' + this.cart_id)
                    .then(res => res.json())
                    .then(res => {
                        this.total = parseFloat(res).toFixed(2);
                    })
            },
            updateCart(product) {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ cart_id: this.cart_id, product_id: product.id, items: product.items, _token: this._token })
                };
                fetch("/api/update-cart", requestOptions)
                    .then(res => {
                        if (res.status != 200) {
                            if (res.status == 401)
                                document.querySelector('.widget .status').innerHTML = 'Wystąpił błąd!<p class="to-hide"> Brak autoryzacji!</p>';
                            else if (res.status == 429)
                                document.querySelector('.widget .status').innerHTML = 'Zbyt wiele zapytań!<p class="to-hide"> Zwolnij!</p>';
                            else
                                document.querySelector('.widget .status').innerHTML = 'Wystąpił błąd!<p class="to-hide"> Spróbuj ponownie później!</p>';
                            }
                            return res;
                        })
                    .then(res => res.json())
                    .then(res => {
                        this.showCart()
                    })
                    .catch(err => {
                        this.widget = true;
                    });
            },
            increment(product) {
                if (product.items < product.quantity) {
                    product.items++;
                    this.updateCart(product)
                }
            },
            decrement(product) {
                if (product.items > 1) {
                    product.items--;
                    this.updateCart(product)
                }
            },
            input(product) {
                if (product.items > product.quantity)
                    product.items = product.quantity
            },
            change(product) {
                if (product.items < 1)
                    product.items = 1
                this.updateCart(product)
            },
            remove(product) {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ cart_id: this.cart_id, product_id: product.id, _token: this._token })
                };
                fetch("/api/remove-from-cart", requestOptions)
                    .then(res => {
                        if (res.status != 200) {
                            if (res.status == 401)
                                document.querySelector('.widget .status').innerHTML = 'Wystąpił błąd!<p class="to-hide"> Brak autoryzacji!</p>';
                            else if (res.status == 429)
                                document.querySelector('.widget .status').innerHTML = 'Zbyt wiele zapytań!<p class="to-hide"> Zwolnij!</p>';
                            else
                                document.querySelector('.widget .status').innerHTML = 'Wystąpił błąd!<p class="to-hide"> Spróbuj ponownie później!</p>';
                        }
                        return res;
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (this.products.length == 1)
                            window.location.reload()
                        else
                            this.showCart()
                    })
                    .catch(err => {
                        this.widget = true;
                    });
            }
        }
    }
</script>
