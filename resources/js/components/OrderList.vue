<template>
    <div class="account__content__bottom__orders">
    <h4>Historia zamówień</h4>
        <div class="account__content__bottom__orders__list">
            <div v-if="limit" class="account__content__bottom__orders__list__single" v-for="order in orders.slice(0, 8)" :key="order.id" @click="showDetails(order)" >
                <span><b>Nr zamówienia:</b> {{ order.code }}</span>
                <span><b>Wartość:</b> {{ order.total }} <span class="grey">zł</span></span>
                <span><b>Data zamówienia:</b> {{ format_date(order.ordered_at) }}</span>
            </div>
            <div v-if="!limit" class="account__content__bottom__orders__list__single" v-for="order in orders" :key="order.id" @click="showDetails(order)" >
                <span><b>Nr zamówienia:</b> {{ order.code }}</span>
                <span><b>Wartość:</b> {{ order.total }} <span class="grey">zł</span></span>
                <span><b>Data zamówienia:</b> {{ format_date(order.ordered_at) }}</span>
            </div>
            <div class="account__content__bottom__orders__list__single more" v-show="moreExists" @click="loadMore">
                <span>Zobacz wszystkie</span>
            </div>
            <div class="account__content__bottom__orders__list__single more" v-show="expanded" @click="collapse">
                <span>Zwiń</span>
            </div>
        </div>
        <section class="account__content__bottom__orders__single" v-if="ifSeeDetails">
            <section class="account__content__bottom__orders__single__content order-view">
                <h2>Zamówienie nr <b>{{ currentOrder.code }}</b></h2>
                <span class="date">Złożone dnia {{ format_polish(currentOrder.ordered_at) }}</span>
                <span class="back" @click="closeDetails()">Powrót</span>
                <section class="account__content__bottom__orders__single__content--details order-account-view">
                    <section class="account__content__bottom__orders__single__content__first-column">
                        <h4>Metoda dostawy</h4>
                        <div class="account__content__bottom__orders__single__content__first-column delivery">
                            <label for="delivery1" class="account__content__bottom__orders__single__content__first-column delivery__input" v-if="currentOrder.delivery_method == 'pickup_in_person'">
                                <i class="fas fa-store-alt"></i> Odbiór osobisty
                            </label>
                            <label for="delivery2" class="account__content__bottom__orders__single__content__first-column delivery__input" v-if="currentOrder.delivery_method == 'courier'">
                                <i class="fas fa-truck"></i> Przesyłka kurierska
                            </label>
                        </div>
                        <h4 v-if="currentOrder.delivery_method == 'pickup_in_person'">Miejsce odbioru</h4>
                        <div class="account__content__bottom__orders__single__content__first-column place" v-if="currentOrder.delivery_method == 'pickup_in_person'">
                            <label for="place1" class="account__content__bottom__orders__single__content__first-column place input" v-if="currentOrder.delivery_place == 'krakow'">
                                <div>
                                    <span>Sklep firmowy Kosmo</span>
                                    <span>Kraków</span>
                                    <span>Kosmiczna 15</span>
                                </div>
                            </label>
                            <label for="place2" class="account__content__bottom__orders__single__content__first-column place input" v-if="currentOrder.delivery_place == 'warszawa'">
                                <div>
                                    <span>Żabka</span>
                                    <span>Warszawa</span>
                                    <span>Avengersów 121</span>
                                </div>
                            </label>
                        </div>
                        <h4>Metoda płatności</h4>
                        <div class="account__content__bottom__orders__single__content__first-column payment">
                            <label for="payment1" class="account__content__bottom__orders__single__content__first-column payment input">
                                Płatność przy odbiorze
                            </label>
                        </div>
                    </section>
                    <section class="account__content__bottom__orders__single__content__second-column" v-if="currentOrder.purchaser_type == 'person'">
                        <h4>Informacje o zamawiającym</h4>
                        <div class="account__content__bottom__orders__single__content__second-column type">
                            <label for="type1" class="account__content__bottom__orders__single__content__second-column type__input">
                                <i class="far fa-user"></i> Osoba fizyczna
                            </label>
                        </div>
                        <div class="account__content__bottom__orders__single__content__second-column two px0">
                            <label for="name" class="account__content__bottom__orders__single__content__second-column two__input-small">
                                <input type="text" name="name" id="name" :value="currentOrder.name" placeholder="Imię" disabled>
                            </label>
                            <label for="surname" class="account__content__bottom__orders__single__content__second-column two__input-small">
                                <input type="text" name="surname" id="surname" :value="currentOrder.surname" placeholder="Nazwisko" disabled>
                            </label>
                        </div>
                        <label for="email" class="account__content__bottom__orders__single__content__second-column input">
                            <input type="text" name="email" id="email" :value="currentOrder.email" placeholder="Adres email" disabled>
                        </label>
                        <label for="telephone" class="account__content__bottom__orders__single__content__second-column input">
                            <input type="text" name="telephone" id="telephone" :value="currentOrder.telephone" placeholder="Numer telefonu" disabled>
                        </label>
                        <label for="street" class="account__content__bottom__orders__single__content__second-column input">
                            <input type="text" name="street" id="street" :value="currentOrder.street" placeholder="Ulica" disabled>
                        </label>
                        <div class="account__content__bottom__orders__single__content__second-column three">
                            <label for="house_number" class="account__content__bottom__orders__single__content__second-column three__input-small">
                                <input type="text" name="house_number" id="house_number" :value="currentOrder.house_number" placeholder="Nr domu" disabled>
                            </label>
                            <label for="apartment_number" class="account__content__bottom__orders__single__content__second-column three__input-small">
                                <input type="text" name="apartment_number" id="apartment_number" :value="currentOrder.apartment_number" placeholder="Nr lokalu" disabled>
                            </label>
                            <label for="zip_code" class="account__content__bottom__orders__single__content__second-column three__input-small">
                                <input type="text" name="zip_code" id="zip_code" :value="currentOrder.zip_code" placeholder="Kod pocztowy" disabled>
                            </label>
                        </div>
                        <label for="city" class="account__content__bottom__orders__single__content__second-column input">
                            <input type="text" name="city" id="city" :value="currentOrder.city" placeholder="Miejscowość" disabled>
                        </label>
                    </section>
                    <section class="account__content__bottom__orders__single__content__second-column" v-if="currentOrder.purchaser_type == 'company'">
                        <h4>Informacje o zamawiającym</h4>
                        <div class="account__content__bottom__orders__single__content__second-column type">
                            <label for="type2" class="account__content__bottom__orders__single__content__second-column type__input">
                                <i class="far fa-building"></i> Firma
                            </label>
                        </div>
                        <label for="company_name" class="account__content__bottom__orders__single__content__second-column type__input px0">
                            <input type="text" name="company_name" id="company_name" :value="currentOrder.company_name" placeholder="Nazwa firmy" disabled>
                        </label>
                        <label for="nip_code" class="account__content__bottom__orders__single__content__second-column type__input">
                            <input type="text" name="nip_code" id="nip_code" :value="currentOrder.nip_code" placeholder="NIP" disabled>
                        </label>
                        <div class="account__content__bottom__orders__single__content__second-column two">
                            <label for="name" class="account__content__bottom__orders__single__content__second-column two__input-small">
                                <input type="text" name="name" id="name" :value="currentOrder.name" placeholder="Imię" disabled>
                            </label>
                            <label for="surname" class="account__content__bottom__orders__single__content__second-column two__input-small">
                                <input type="text" name="surname" id="surname" :value="currentOrder.surname" placeholder="Nazwisko" disabled>
                            </label>
                        </div>
                        <label for="email" class="account__content__bottom__orders__single__content__second-column input">
                            <input type="text" name="email" id="email" :value="currentOrder.email" placeholder="Adres email" disabled>
                        </label>
                        <label for="telephone" class="account__content__bottom__orders__single__content__second-column input">
                            <input type="text" name="telephone" id="telephone" :value="currentOrder.telephone" placeholder="Numer telefonu" disabled>
                        </label>
                        <label for="street" class="account__content__bottom__orders__single__content__second-column input">
                            <input type="text" name="street" id="street" :value="currentOrder.street" placeholder="Ulica" disabled>
                        </label>
                        <div class="account__content__bottom__orders__single__content__second-column three">
                            <label for="house_number" class="account__content__bottom__orders__single__content__second-column three__input-small">
                                <input type="text" name="house_number" id="house_number" :value="currentOrder.house_number" placeholder="Nr domu" disabled>
                            </label>
                            <label for="apartment_number" class="account__content__bottom__orders__single__content__second-column three__input-small">
                                <input type="text" name="apartment_number" id="apartment_number" :value="currentOrder.apartment_number" placeholder="Nr lokalu" disabled>
                            </label>
                            <label for="zip_code" class="account__content__bottom__orders__single__content__second-column three__input-small">
                                <input type="text" name="zip_code" id="zip_code" :value="currentOrder.zip_code" placeholder="Kod pocztowy" disabled>
                            </label>
                        </div>
                        <label for="city" class="account__content__bottom__orders__single__content__second-column input">
                            <input type="text" name="city" id="city" :value="currentOrder.city" placeholder="Miejscowość" disabled>
                        </label>
                    </section>
                    <section class="account__content__bottom__orders__single__content__third-column">
                        <h4 v-if="currentOrder.comment">Dodatkowe uwagi</h4>
                        <label for="content" class="order__content__third-column textarea" v-if="currentOrder.comment">
                            <textarea name="comment" id="comment" placeholder="Uwagi" :value="currentOrder.comment" disabled></textarea>
                        </label>
                        <h4>Podsumowanie</h4>
                        <div class="account__content__bottom__orders__single__content__third-column__table ov summary">
                            <div class="account__content__bottom__orders__single__content__third-column__table__single" v-for="product in products" v-bind:key="product.id">
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
                                    <span>{{ product.items }}
                                            <p v-if="product.items == 1">sztuka</p>
                                            <p v-if="product.items > 1 & product.items < 5">sztuki</p>
                                            <p v-if="product.items >= 5">sztuk</p>
                                    </span>
                                </div>
                                <div class="td price">
                                    <span>{{ product.price }} <span class="grey">zł</span></span>
                                </div>
                            </div>
                            <div class="account__content__bottom__orders__single__content__third-column__table__single delivery_price" v-if="currentOrder.delivery_method=='courier'">
                                <div class="td">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="td">
                                    <span>Przesyłka kurierska</span>
                                </div>
                                <div></div>
                                <div class="td price">
                                    <span>20.00 <span class="grey">zł</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="account__content__bottom__orders__single__content__third-column__summary">
                            <span class="grey">Łącznie</span>
                            <span class="price">{{ currentOrder.total }} <p class="grey">zł</p></span>
                            <span class="small">W cenie zawarto podatek VAT</span>
                        </div>
                    </section>
                </section>
            </section>
        </section>
        <section class="widget" v-if="widget">
            <div class="widget__upper">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="status">Wystąpił błąd! Spróbuj ponownie później!</span>
                <i class="fas fa-times close" @click="widget = false"></i>
            </div>
        </section>
    </div>
</template>
<script>
    import moment from 'moment';
    export default {
        props: [
            'user_id',
            '_token',
        ],
         data() {
            return {
                orders: [],
                order: {
                    id: 0,
                    code: '',
                    email: '',
                    status: '',
                    delivery_method: '',
                    delivery_place: '',
                    payment_method: '',
                    purchaser_type: '',
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
                    comment: '',
                    delivery_price: '',
                    total: '',
                    order_at: '',
                },
                currentOrder: {},
                widget: false,
                ifSeeDetails: false,
                day: '',
                monthName: '',
                year: '',
                moreExists: false,
                limit: true,
                expanded: false,
                products: [],
                product: {
                    items: 0,
                    price: '',
                    link: '',
                    image: '',
                    name: ''
                }
            };
        },
        mounted() {
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ user_id: this.user_id, _token: this._token })
            };
            fetch("/api/get-orders", requestOptions)
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
                    if (!res.exception) {
                        this.orders = res;
                        if (this.orders.length > 8)
                            this.moreExists = true
                    }
                })
                .catch(err => {
                    this.widget = true;
                });
            },
        methods: {
            format_date(value) {
                return moment(String(value)).format('D.M.Y')
            },
            format_polish(value) {
                this.day = moment(String(value)).format('D')
                switch (parseInt(moment(String(value)).format('M'))) {
                    case 1:
                        this.monthName = 'stycznia'
                        break;
                    case 2:
                        this.monthName = 'lutego'
                        break;
                    case 3:
                        this.monthName = 'marca'
                        break;
                    case 4:
                        this.monthName = 'kwietnia'
                        break;
                    case 5:
                        this.monthName = 'maja'
                        break;
                    case 6:
                        this.monthName = 'czerwca'
                        break;
                    case 7:
                        this.monthName = 'lipca'
                        break;
                    case 8:
                        this.monthName = 'sierpnia'
                        break;
                    case 9:
                        this.monthName = 'września'
                        break;
                    case 10:
                        this.monthName = 'października'
                        break;
                    case 11:
                        this.monthName = 'listopada'
                        break;
                    case 12:
                        this.monthName = 'grudnia'
                        break;
                }
                this.year = moment(String(value)).format('Y')
                return this.day + ' ' + this.monthName + ' ' + this.year;
            },
            showDetails(order) {
                this.currentOrder = order;
                this.ifSeeDetails = true;
                this.loadOrderedProducts();
            },
            loadMore() {
                this.limit = false;
                this.moreExists = false;
                this.expanded = true;
            },
            collapse() {
                this.limit = true;
                this.moreExists = true;
                this.expanded = false;
            },
            loadOrderedProducts() {
                fetch('/api/get-products-from-cart/' + this.currentOrder.cart_id)
                    .then(res => {
                        if (res.status != 200)
                            this.widget = true;
                        return res;
                    })
                    .then(res => res.json())
                    .then(res => {
                        this.products = res;
                        document.querySelector('.summary').classList.add('loaded')
                    })
            },
            closeDetails() {
                this.ifSeeDetails = false
                this.products = []
            }
        },
    }
</script>
