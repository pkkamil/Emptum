<template>
    <section class="addresses__content__bottom">
        <div class="addresses__content__bottom__new">
            <h4>Dodaj nowy adres</h4>
            <form class="addresses__content__bottom__new__form" method="POST" @submit.prevent=submit autocomplete="off" v-if="address.type == 'person'">
                <div class="addresses__content__bottom__new__form__type">
                    <label for="type1" class="addresses__content__bottom__new__form__type__input">
                        <input type="radio" name="type" id="type1" value='person' v-model="address.type" checked><i class="far fa-user"></i> Osoba fizyczna
                    </label>
                    <label for="type2" class="addresses__content__bottom__new__form__type__input">
                        <input type="radio" name="type" id="type2" value='company' v-model="address.type"><i class="far fa-building"></i> Firma
                    </label>
                </div>
                <div class="addresses__content__bottom__new__form__two">
                    <label for="name" class="addresses__content__bottom__new__form__two__input-small">
                        <input type="text" name="name" id="name" placeholder="Imię" required v-model="address.name">
                    </label>
                    <label for="surname" class="addresses__content__bottom__new__form__two__input-small">
                        <input type="text" name="surname" id="surname" placeholder="Nazwisko" required v-model="address.surname">
                    </label>
                </div>
                <label for="telephone" class="addresses__content__bottom__new__form__input px1">
                    <input type="text" name="telephone" id="telephone" placeholder="Numer telefonu" v-model="address.telephone">
                </label>
                <label for="street" class="addresses__content__bottom__new__form__input px2">
                    <input type="text" name="street" id="street" placeholder="Ulica" required v-model="address.street">
                </label>
                <div class="addresses__content__bottom__new__form__three px3a">
                    <label for="house_number" class="addresses__content__bottom__new__form__three__input-small">
                        <input type="text" name="house_number" id="house_number" placeholder="Nr domu" v-model="address.house_number">
                    </label>
                    <label for="apartment_number" class="addresses__content__bottom__new__form__three__input-small">
                        <input type="text" name="apartment_number" id="apartment_number" placeholder="Nr lokalu" v-model="address.apartment_number">
                    </label>
                    <label for="zip_code" class="addresses__content__bottom__new__form__three__input-small">
                        <input type="text" name="zip_code" id="zip_code" placeholder="Kod pocztowy" required v-model="address.zip_code">
                    </label>
                </div>
                <label for="city" class="addresses__content__bottom__new__form__input px4">
                    <input type="text" name="city" id="city" placeholder="Miejscowość" required v-model="address.city">
                </label>
                <button class="dark">Zapisz adres</button>
            </form>
            <form class="addresses__content__bottom__new__form" method="POST" @submit.prevent=submit autocomplete="off" v-if="address.type == 'company'">
                <div class="addresses__content__bottom__new__form__type">
                    <label for="type1" class="addresses__content__bottom__new__form__type__input">
                        <input type="radio" name="type" id="type1" value='person' v-model="address.type" checked><i class="far fa-user"></i> Osoba fizyczna
                    </label>
                    <label for="type2" class="addresses__content__bottom__new__form__type__input">
                        <input type="radio" name="type" id="type2" value='company' v-model="address.type"><i class="far fa-building"></i> Firma
                    </label>
                </div>
                <label for="company_name" class="addresses__content__bottom__new__form__input">
                    <input type="text" name="company_name" id="company_name" placeholder="Nazwa firmy" v-model="address.company_name">
                </label>
                <label for="nip_code" class="addresses__content__bottom__new__form__input px1">
                    <input type="text" name="nip_code" id="nip_code" placeholder="NIP" required v-model="address.nip_code" maxLength="10">
                </label>
                <div class="addresses__content__bottom__new__form__two px2">
                    <label for="name" class="addresses__content__bottom__new__form__two__input-small">
                        <input type="text" name="name" id="name" placeholder="Imię" required v-model="address.name">
                    </label>
                    <label for="surname" class="addresses__content__bottom__new__form__two__input-small">
                        <input type="text" name="surname" id="surname" placeholder="Nazwisko" required v-model="address.surname">
                    </label>
                </div>
                <label for="telephone" class="addresses__content__bottom__new__form__input px3">
                    <input type="text" name="telephone" id="telephone" placeholder="Numer telefonu" v-model="address.telephone">
                </label>
                <label for="street" class="addresses__content__bottom__new__form__input px4">
                    <input type="text" name="street" id="street" placeholder="Ulica" required v-model="address.street">
                </label>
                <div class="addresses__content__bottom__new__form__three px5">
                    <label for="house_number" class="addresses__content__bottom__new__form__three__input-small">
                        <input type="text" name="house_number" id="house_number" placeholder="Nr domu" v-model="address.house_number">
                    </label>
                    <label for="apartment_number" class="addresses__content__bottom__new__form__three__input-small">
                        <input type="text" name="apartment_number" id="apartment_number" placeholder="Nr lokalu" v-model="address.apartment_number">
                    </label>
                    <label for="zip_code" class="addresses__content__bottom__new__form__three__input-small">
                        <input type="text" name="zip_code" id="zip_code" placeholder="Kod pocztowy" required v-model="address.zip_code">
                    </label>
                </div>
                <label for="city" class="addresses__content__bottom__new__form__input px6">
                    <input type="text" name="city" id="city" placeholder="Miejscowość" required v-model="address.city">
                </label>
                <button class="dark">Zapisz adres</button>
            </form>
        </div>
        <div class="addresses__content__bottom__box">
            <h4 v-if="addresses.length != 0">Adresy</h4>
            <div class="addresses__content__bottom__box__list">
                <div class="addresses__content__bottom__box__list__single" v-for="address in addresses" :key="address.id">
                    <span><i class="far fa-user" v-if="address.type === 'person'"></i><i class="far fa-building" v-else></i> {{ address.name + ' ' + address.surname }}</span>
                    <span>{{ address.street + ' ' + address.house_number}}{{ address.apartment_number ? '/' + address.apartment_number : '' }}</span>
                    <span>{{ address.zip_code + ' ' + address.city }}</span>
                    <div>
                        <span :class="[editing_id === address.id ? 'dark' : 'bright', 'button']"  @click="editAddress(address.id)">Edytuj</span>
                        <span class="button bright" @click="deleteAddress(address.id)">usuń</span>
                    </div>
                </div>
            </div>
        </div>
        <section class="widget" v-show="widget">
            <div class="widget__upper">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="status">Wystąpił błąd! Spróbuj ponownie później!</span>
                <i class="fas fa-times close" @click="widget = false"></i>
            </div>
        </section>
    </section>
</template>

<script>
    export default {
        props: [
            'user_id',
            '_token',
        ],
         data() {
            return {
                addresses: [],
                address: {
                    id: '',
                    type: 'person',
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
                editing: false,
                editing_id: 0,
                widget: false,
            };
        },
        mounted() {
            this.updateList()
        },
        methods: {
            submit() {
                if (this.editing == false) {
                    const requestOptions = {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ type: this.address.type, name: this.address.name, surname: this.address.surname, company_name: this.address.company_name, nip_code: this.address.nip_code, telephone: this.address.telephone, street: this.address.street, house_number: this.address.house_number, apartment_number: this.address.apartment_number, zip_code: this.address.zip_code, city: this.address.city, user_id: this.user_id, _token: this._token })
                    };
                    fetch("/api/add-new-address", requestOptions)
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
                                this.clearForm()
                                this.updateList()
                            }
                        })
                        .catch(err => {
                            this.widget = true;
                        });
                } else {
                    const requestOptions = {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ type: this.address.type, name: this.address.name, surname: this.address.surname, company_name: this.address.company_name, nip_code: this.address.nip_code, telephone: this.address.telephone, street: this.address.street, house_number: this.address.house_number, apartment_number: this.address.apartment_number, zip_code: this.address.zip_code, city: this.address.city, user_id: this.user_id, _token: this._token, address_id: this.address.id })
                    };
                    fetch("/api/edit-address", requestOptions)
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
                                this.clearForm()
                                this.updateList()
                                this.editing = false;
                            }
                        })
                        .catch(err => {
                            this.widget = true;
                        });
                }
            },
            updateList() {
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
            },
            clearForm() {
                this.address.name = ''
                this.address.surname = ''
                this.address.company_name = ''
                this.address.nip_code = ''
                this.address.telephone = ''
                this.address.street = ''
                this.address.house_number = ''
                this.address.apartment_number = ''
                this.address.zip_code = ''
                this.address.city = ''
            },
            editAddress(id) {
                if (this.editing_id == id) {
                    this.editing_id = 0
                    this.clearForm()
                    this.editing = false
                } else {
                    const requestOptions = {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ user_id: this.user_id, _token: this._token, address_id: id })
                    };
                    fetch("/api/show-address", requestOptions)
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
                                this.address = res
                                this.editing = true
                                this.editing_id = this.address.id
                            }
                        })
                        .catch(err => {
                            this.widget = true;
                        });
                }
            },
            deleteAddress(id) {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ user_id: this.user_id, _token: this._token, address_id: id })
                };
                fetch("/api/delete-address", requestOptions)
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
                            this.updateList()
                    })
                    .catch(err => {
                        this.widget = true;
                    });
            }
        },
    }
</script>
