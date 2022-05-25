<template>
    <article class="order">
        <form class="order__content" method="POST" @submit.prevent=submit autocomplete="off">
            <section class="order__content__first-column">
                <h4>Metoda dostawy</h4>
                <div class="order__content__first-column delivery">
                    <label for="delivery1" class="order__content__first-column delivery__input">
                        <input type="radio" name="delivery" id="delivery1" value='pickup_in_person' @change="changePlace()" v-model="delivery_method" checked><i class="fas fa-store-alt"></i> Odbiór osobisty
                    </label>
                    <label for="delivery2" class="order__content__first-column delivery__input">
                        <input type="radio" name="delivery" id="delivery2" value='courier' @change="changePlace()" v-model="delivery_method"><i class="fas fa-truck"></i> Przesyłka kurierska
                    </label>
                </div>
                <h4 v-if="delivery_method == 'pickup_in_person'">Miejsce odbioru</h4>
                <div class="order__content__first-column place" v-if="delivery_method == 'pickup_in_person'">
                    <label for="place1" class="order__content__first-column place input">
                        <input type="radio" name="place" id="place1" value='krakow' v-model="delivery_place" checked>
                        <div>
                            <span>Sklep firmowy Kosmo</span>
                            <span>Kraków</span>
                            <span>Kosmiczna 15</span>
                        </div>
                    </label>
                    <label for="place2" class="order__content__first-column place input">
                        <input type="radio" name="place" id="place2" v-model="delivery_place" value='warszawa'>
                        <div>
                            <span>Żabka</span>
                            <span>Warszawa</span>
                            <span>Avengersów 121</span>
                        </div>
                    </label>
                </div>
                <h4>Metoda płatności</h4>
                <div class="order__content__first-column payment">
                    <label for="payment1" class="order__content__first-column payment input">
                        <input type="radio" name="payment" id="payment1" value='cash_on_delivery' v-model="payment_method" checked>Płatność przy odbiorze
                    </label>
                </div>
                <h4 v-if="this.user_id && haveAddress">Zapisane adresy</h4>
                <span v-if="this.user_id && haveAddress" class="button-small dark" @click="showAddresses()">Wybierz</span>
            </section>
            <section class="order__content__second-column" v-if="purchaser.type == 'person'">
                <h4>Informacje o zamawiającym</h4>
                <div class="order__content__second-column type">
                    <label for="type1" class="order__content__second-column type__input">
                        <input type="radio" name="type" id="type1" value='person' v-model="purchaser.type" checked><i class="far fa-user"></i> Osoba fizyczna
                    </label>
                    <label for="type2" class="order__content__second-column type__input">
                        <input type="radio" name="type" id="type2" value='company' v-model="purchaser.type"><i class="far fa-building"></i> Firma
                    </label>
                </div>
                <div class="order__content__second-column two px0">
                    <label for="name" class="order__content__second-column two__input-small">
                        <input type="text" name="name" id="name" placeholder="Imię" v-model="purchaser.name" required>
                    </label>
                    <label for="surname" class="order__content__second-column two__input-small">
                        <input type="text" name="surname" id="surname" placeholder="Nazwisko" v-model="purchaser.surname" required>
                    </label>
                </div>
                <label for="email" class="order__content__second-column input">
                    <input type="text" name="email" id="email" placeholder="Adres email" v-model="purchaser.email" required>
                </label>
                <label for="telephone" class="order__content__second-column input">
                    <input type="text" name="telephone" id="telephone" placeholder="Numer telefonu" v-model="purchaser.telephone">
                </label>
                <label for="street" class="order__content__second-column input">
                    <input type="text" name="street" id="street" placeholder="Ulica" v-model="purchaser.street" required>
                </label>
                <div class="order__content__second-column three">
                    <label for="house_number" class="order__content__second-column three__input-small">
                        <input type="text" name="house_number" id="house_number" placeholder="Nr domu" v-model="purchaser.house_number">
                    </label>
                    <label for="apartment_number" class="order__content__second-column three__input-small">
                        <input type="text" name="apartment_number" id="apartment_number" placeholder="Nr lokalu" v-model="purchaser.apartment_number">
                    </label>
                    <label for="zip_code" class="order__content__second-column three__input-small">
                        <input type="text" name="zip_code" id="zip_code" placeholder="Kod pocztowy" v-model="purchaser.zip_code" required>
                    </label>
                </div>
                <label for="city" class="order__content__second-column input">
                    <input type="text" name="city" id="city" placeholder="Miejscowość" v-model="purchaser.city" required>
                </label>
                <label for="rules" class="order__content__second-column input">
                    <input type="checkbox" name="rules" id="rules" required v-model="accept_rules"> Akceptuję regulamin serwisu
                </label>
            </section>
            <section class="order__content__second-column" v-if="purchaser.type == 'company'">
                <h4>Informacje o zamawiającym</h4>
                <div class="order__content__second-column__type">
                    <label for="type1" class="order__content__second-column type__input">
                        <input type="radio" name="type" id="type1" value='person' v-model="purchaser.type" checked><i class="far fa-user"></i> Osoba fizyczna
                    </label>
                    <label for="type2" class="order__content__second-column type__input">
                        <input type="radio" name="type" id="type2" value='company' v-model="purchaser.type"><i class="far fa-building"></i> Firma
                    </label>
                </div>
                <label for="company_name" class="order__content__second-column type__input px0">
                    <input type="text" name="company_name" id="company_name" placeholder="Nazwa firmy" v-model="purchaser.company_name">
                </label>
                <label for="nip_code" class="order__content__second-column type__input">
                    <input type="text" name="nip_code" id="nip_code" placeholder="NIP" required v-model="purchaser.nip_code" maxlength="10">
                </label>
                <div class="order__content__second-column two">
                    <label for="name" class="order__content__second-column two__input-small">
                        <input type="text" name="name" id="name" placeholder="Imię" v-model="purchaser.name" required>
                    </label>
                    <label for="surname" class="order__content__second-column two__input-small">
                        <input type="text" name="surname" id="surname" placeholder="Nazwisko" v-model="purchaser.surname" required>
                    </label>
                </div>
                <label for="email" class="order__content__second-column input">
                    <input type="text" name="email" id="email" placeholder="Adres email" v-model="purchaser.email" required>
                </label>
                <label for="telephone" class="order__content__second-column input">
                    <input type="text" name="telephone" id="telephone" placeholder="Numer telefonu" v-model="purchaser.telephone">
                </label>
                <label for="street" class="order__content__second-column input">
                    <input type="text" name="street" id="street" placeholder="Ulica" v-model="purchaser.street" required>
                </label>
                <div class="order__content__second-column three">
                    <label for="house_number" class="order__content__second-column three__input-small">
                        <input type="text" name="house_number" id="house_number" placeholder="Nr domu" v-model="purchaser.house_number">
                    </label>
                    <label for="apartment_number" class="order__content__second-column three__input-small">
                        <input type="text" name="apartment_number" id="apartment_number" placeholder="Nr lokalu" v-model="purchaser.apartment_number">
                    </label>
                    <label for="zip_code" class="order__content__second-column three__input-small">
                        <input type="text" name="zip_code" id="zip_code" placeholder="Kod pocztowy" v-model="purchaser.zip_code" required>
                    </label>
                </div>
                <label for="city" class="order__content__second-column input">
                    <input type="text" name="city" id="city" placeholder="Miejscowość" v-model="purchaser.city" required>
                </label>
                <label for="rules" class="order__content__second-column input">
                    <input type="checkbox" name="rules" id="rules" required v-model="accept_rules"> Akceptuję regulamin serwisu
                </label>
            </section>
            <section class="order__content__third-column">
                <h4>Dodatkowe uwagi</h4>
                <label for="content" class="order__content__third-column textarea">
                    <textarea name="comment" id="comment" placeholder="Uwagi" v-model="comment" required maxlength="500"></textarea>
                </label>
                <h4>Podsumowanie</h4>
                <div class="order__content__third-column">
                    <div class="order__content__third-column__table">
                        <div class="order__content__third-column__table__single" v-for="product in products" :key="product.id">
                            <div class="td">
                                <a :href="product.link">
                                    <img :src="product.image" alt="">
                                </a>
                            </div>
                            <div class="td">
                                <a :href="product.link">
                                    <span>{{ product.name }}</span>
                                </a>
                            </div>
                            <div class="td">
                                <span>{{ product.items }} <p v-if="product.items == 1">sztuka</p><p v-if="product.items > 1 & product.items < 5">sztuki</p><p v-if="product.items > 4">sztuk</p></span>
                            </div>
                            <div class="td price">
                                <span>{{ product.price }} <span class="grey">zł</span></span>
                            </div>
                        </div>
                        <div class="order__content__third-column__table__single delivery_price" v-if="delivery_method == 'courier'">
                            <div class="td">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="td">
                                <span>Przesyłka kurierska</span>
                            </div>
                            <div class="td"></div>
                            <div class="td price">
                                <span>20.00 <span class="grey">zł</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="order__content__third-column__summary">
                        <span class="grey">Łącznie</span>
                        <span class="price">{{ total }} <p class="grey">zł</p></span>
                        <span class="small">W cenie zawarto podatek VAT</span>
                        <button type="submit" class="dark">Złóż zamówienie</button>
                    </div>
                </div>
            </section>
        </form>
        <section class="order__addresses" v-if="ifSeeAddresses">
            <section class="order__addresses__content">
                <h2>Twoje zapisane adresy</h2>
                <span class="back" @click="ifSeeAddresses = false">Powrót</span>
                <div class="order__addresses__content__list">
                    <div class="order__addresses__content__list__single" v-for="address in addresses" :key="address.id">
                        <span><i class="far fa-user" v-if="address.type === 'person'"></i><i class="far fa-building" v-else></i> {{ address.name + ' ' + address.surname }}</span>
                        <span>{{ address.street + ' ' + address.house_number}}{{ address.apartment_number ? '/' + address.apartment_number : '' }}</span>
                        <span>{{ address.zip_code + ' ' + address.city }}</span>
                        <div>
                            <span class="button bright" @click="chooseAddress(address)">Wybierz</span>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        <section class="widget" v-show="widget">
            <div class="widget__upper">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="status">Wystąpił błąd! Spróbuj ponownie później!</span>
                <i class="fas fa-times close" @click="widget = false"></i>
            </div>
        </section>
    </article>
</template>

<script>
    export default {
        props: [
            'user_id',
            '_token',
            'email',
            'name',
            'surname'
        ],
         data() {
            return {
                delivery_method: 'pickup_in_person',
                delivery_place: 'krakow',
                payment_method: 'cash_on_delivery',
                purchaser: {
                    id: '',
                    type: 'person',
                    name: this.name,
                    surname: this.surname,
                    company_name: '',
                    nip_code: '',
                    telephone: '',
                    email: this.email,
                    street: '',
                    house_number: '',
                    apartment_number: '',
                    zip_code: '',
                    city: '',
                },
                accept_rules: false,
                products: [],
                product: {
                    id: 0,
                    image: '',
                    link: '',
                    name: '',
                    items: 0,
                    price: 0.00,
                },
                addresses: [],
                address: {
                    id: '',
                    type: '',
                    name: '',
                    surname: '',
                    company_name: '',
                    nip_code: '',
                    telephone: '',
                    street: '',
                    house_number: '',
                    apartment_number: '',
                    zip_code: '',
                    city: '',
                },
                comment: '',
                delivery_price: 0.00,
                total: 0.00,
                ifSeeAddresses: false,
                haveAddress: false,
                widget: false,
            };
        },
        mounted() {
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ user_id: this.user_id, _token: this._token })
            };
            fetch('/api/get-products-from-cart', requestOptions)
                .then(res => res.json())
                .then(res => {
                    this.products = res;
                })
            fetch('/api/get-total', requestOptions)
                .then(res => res.json())
                .then(res => {
                    this.total = res.total;
                })
            if (this.user_id) {
                fetch('/api/if-user-have-address', requestOptions)
                    .then(res => res.json())
                    .then(res => {
                        this.haveAddress = res.haveAddress;
                    })
            }
        },
        methods: {
            submit() {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        name: this.purchaser.name,
                        surname: this.purchaser.surname,
                        type: this.purchaser.type,
                        company_name: this.purchaser.company_name,
                        nip_code: this.purchaser.nip_code,
                        telephone: this.purchaser.telephone,
                        email: this.purchaser.email,
                        street: this.purchaser.street,
                        house_number: this.purchaser.house_number,
                        apartment_number: this.purchaser.apartment_number,
                        zip_code: this.purchaser.zip_code,
                        city: this.purchaser.city,
                        comment: this.comment,
                        delivery_method: this.delivery_method,
                        delivery_place: this.delivery_place,
                        payment_method: this.payment_method,
                        delivery_price: this.delivery_price,
                        total: this.total,
                        user_id: this.user_id,
                        _token: this._token
                    })
                };
                fetch("/api/create-new-order", requestOptions)
                    .then(res => {
                        if (!res.ok) {
                            if (res.status == 401)
                                document.querySelector('.widget .status').textContent = 'Wystąpił błąd! Brak autoryzacji!';
                            else if (res.status == 429)
                                document.querySelector('.widget .status').textContent = 'Zbyt wiele zapytań! Zwolnij!';
                            else
                                document.querySelector('.widget .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                            this.widget = true;
                        }
                        return res;
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.status == 200)
                            if (res.redirect)
                                window.location.href = '/konto';
                            else
                                window.location.href = '/'
                    })
                    .catch(err => {
                        this.widget = true;
                    });
            },
            showAddresses() {
                this.ifSeeAddresses = true;
                if (this.addresses.length == 0) {
                    const requestOptions = {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ user_id: this.user_id, _token: this._token })
                    };
                    fetch("/api/get-addresses", requestOptions)
                        .then(res => {
                            if (!res.ok) {
                                if (res.status == 401)
                                    document.querySelector('.widget .status').textContent = 'Wystąpił błąd! Brak autoryzacji!';
                                else if (res.status == 429)
                                    document.querySelector('.widget .status').textContent = 'Zbyt wiele zapytań! Zwolnij!';
                                else
                                    document.querySelector('.widget .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                                this.widget = true;
                            }
                            return res;
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (!res.exception)
                                this.addresses = res;
                        })
                        .catch(err => {
                            this.widget = true;
                        });
                }
            },
            chooseAddress(address) {
                this.purchaser = {...address};
                this.purchaser.email = this.email;
                this.ifSeeAddresses = false;
            },
            changePlace() {
                this.total = parseFloat(this.total);
                if (this.delivery_method == 'courier') {
                    this.total = parseFloat(this.total + 20.00).toFixed(2)
                    this.delivery_price = 20
                }
                else
                    this.total = parseFloat(this.total - 20.00).toFixed(2)
            }
        }
    }
</script>
