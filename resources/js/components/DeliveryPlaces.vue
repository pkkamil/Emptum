<template>
    <section class="admin__content__delivery-places">
        <div class="admin__content__delivery-places__new">
            <h4>Dodaj nowe miejsce odbioru</h4>
            <form class="admin__content__delivery-places__new__form" method="POST" @submit.prevent=submit autocomplete="off">
                <label for="name" class="admin__content__delivery-places__new__form__input">
                    <input type="text" name="name" id="name" placeholder="Nazwa miejsca odbioru" required v-model="place.name">
                </label>
                <label for="street" class="admin__content__delivery-places__new__form__input">
                    <input type="text" name="street" id="street" placeholder="Ulica" required v-model="place.street">
                </label>
                <div class="admin__content__delivery-places__new__form__three">
                    <label for="house_number" class="admin__content__delivery-places__new__form__three__input-small">
                        <input type="text" name="house_number" id="house_number" placeholder="Nr domu" required v-model="place.house_number">
                    </label>
                    <label for="apartment_number" class="admin__content__delivery-places__new__form__three__input-small">
                        <input type="text" name="apartment_number" id="apartment_number" placeholder="Nr lokalu" v-model="place.apartment_number">
                    </label>
                    <label for="zip_code" class="admin__content__delivery-places__new__form__three__input-small">
                        <input type="text" name="zip_code" id="zip_code" placeholder="Kod pocztowy" required v-model="place.zip_code">
                    </label>
                </div>
                <label for="city" class="admin__content__delivery-places__new__form__input">
                    <input type="text" name="city" id="city" placeholder="Miejscowość" required v-model="place.city">
                </label>
                <button class="dark">Zapisz miejsce<span class="toHide"> odbioru</span></button>
            </form>
        </div>
        <div class="admin__content__delivery-places__box">
            <h4 v-if="places.length != 0">Miejsca odbioru</h4>
            <div class="admin__content__delivery-places__box__list">
                <div class="admin__content__delivery-places__box__list__single" v-for="place in places" :key="place.id">
                    <span>{{ place.name }}</span>
                    <span>{{ place.street + ' ' + place.house_number}}{{ place.apartment_number ? '/' + place.apartment_number : '' }}</span>
                    <span>{{ place.zip_code + ' ' + place.city }}</span>
                    <div>
                        <span :class="[editing_id === place.id ? 'dark' : 'bright', 'button']"  @click="editPlace(place.id)">Edytuj</span>
                        <!-- <span class="button bright" @click="ifWantDelete = true;">usuń</span> -->
                    </div>
                </div>
            </div>
        </div>
        <section class="widget" v-show="widget">
            <div class="widget__upper">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="status" v-html="result.message"></span>
                <i class="fas fa-times close" @click="widget = false"></i>
            </div>
        </section>
        <!-- <section class="confirmation vue" v-if="ifWantDelete">
            <section class="confirmation__box">
                <h4>Czy na pewno chcesz usunąć to miejsce odbioru?</h4>
                    <button type="submit" class="button-small dark danger" @click="deletePlace(place.id)">Tak</button>
                    <span class="button button-small dark cancel" @click="ifWantDelete = false">Nie</span>
            </section>
        </section> -->
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
                places: [],
                place: {
                    id: '',
                    name: '',
                    street: '',
                    house_number: '',
                    apartment_number: '',
                    zip_code: '',
                    city: '',
                },
                result: {
                    message: '',
                },
                editing: false,
                editing_id: 0,
                widget: false,
                // ifWantDelete: false,
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
                        body: JSON.stringify({ name: this.place.name, street: this.place.street, house_number: this.place.house_number, apartment_number: this.place.apartment_number, zip_code: this.place.zip_code, city: this.place.city, user_id: this.user_id, _token: this._token })
                    };
                    fetch("/api/add-new-delivery-place", requestOptions)
                        .then(res => {
                            if (!res.ok) {
                                if (res.status == 401)
                                    this.result.message = 'Wystąpił błąd!<p class="to-hide"> Brak autoryzacji!</p>'
                                else if (res.status == 429)
                                    this.result.message = 'Zbyt wiele zapytań!<p class="to-hide"> Zwolnij!</p>'
                                else
                                    this.result.message = 'Wystąpił błąd!<p class="to-hide"> Spróbuj ponownie później!</p>'
                                    this.widget = true
                            }
                            return res
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (!res.exception) {
                                this.clearForm()
                                this.updateList()
                            }
                        })
                        .catch(err => {
                            this.widget = true
                        });
                } else {
                    const requestOptions = {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ name: this.place.name, street: this.place.street, house_number: this.place.house_number, apartment_number: this.place.apartment_number, zip_code: this.place.zip_code, city: this.place.city, user_id: this.user_id, _token: this._token, place_id: this.place.id })
                    };
                    fetch("/api/edit-delivery-place", requestOptions)
                        .then(res => {
                            if (!res.ok) {
                            if (res.status == 401)
                                this.result.message = 'Wystąpił błąd!<p class="to-hide"> Brak autoryzacji!</p>'
                            else if (res.status == 429)
                                this.result.message = 'Zbyt wiele zapytań!<p class="to-hide"> Zwolnij!</p>'
                            else
                                this.result.message = 'Wystąpił błąd!<p class="to-hide"> Spróbuj ponownie później!</p>'
                                this.widget = true
                            }
                            return res
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (!res.exception) {
                                this.clearForm()
                                this.updateList()
                                this.editing = false;
                                this.editing_id = 0
                            }
                        })
                        .catch(err => {
                            this.widget = true
                        });
                }
            },
            updateList() {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ _token: this._token })
                };
                fetch("/api/get-delivery-places", requestOptions)
                    .then(res => {
                        if (!res.ok) {
                            if (res.status == 401)
                               this.result.message = 'Wystąpił błąd! Brak autoryzacji!'
                            else if (res.status == 429)
                               this.result.message = 'Zbyt wiele zapytań! Zwolnij!'
                            else
                               this.result.message = 'Wystąpił błąd! Spróbuj ponownie później!'
                            this.widget = true
                        }
                        return res
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (!res.exception)
                            this.places = res
                    })
                    .catch(err => {
                        this.widget = true
                    });
            },
            clearForm() {
                this.place.name = ''
                this.place.street = ''
                this.place.house_number = ''
                this.place.apartment_number = ''
                this.place.zip_code = ''
                this.place.city = ''
            },
            editPlace(id) {
                if (this.editing_id == id) {
                    this.editing_id = 0
                    this.clearForm()
                    this.editing = false
                } else {
                    const requestOptions = {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ _token: this._token, place_id: id })
                    };
                    fetch("/api/show-delivery-place", requestOptions)
                        .then(res => {
                            if (!res.ok) {
                            if (res.status == 401)
                                this.result.message = 'Wystąpił błąd!<p class="to-hide"> Brak autoryzacji!</p>'
                            else if (res.status == 429)
                                this.result.message = 'Zbyt wiele zapytań!<p class="to-hide"> Zwolnij!</p>'
                            else
                                this.result.message = 'Wystąpił błąd!<p class="to-hide"> Spróbuj ponownie później!</p>'
                                this.widget = true
                            }
                            return res
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (!res.exception) {
                                this.place = res
                                this.editing = true
                                this.editing_id = this.place.id
                            }
                        })
                        .catch(err => {
                            this.widget = true
                        });
                }
            },
            // deletePlace(id) {
            //     const requestOptions = {
            //         method: "POST",
            //         headers: { "Content-Type": "application/json" },
            //         body: JSON.stringify({ user_id: this.user_id, _token: this._token, place_id: id })
            //     };
            //     fetch("/api/delete-delivery-place", requestOptions)
            //         .then(res => {
            //             if (!res.ok) {
            //                 if (res.status == 401)
            //                    this.result.message = 'Wystąpił błąd! Brak autoryzacji!'
            //                 else if (res.status == 429)
            //                    this.result.message = 'Zbyt wiele zapytań! Zwolnij!'
            //                 else
            //                    this.result.message = 'Wystąpił błąd! Spróbuj ponownie później!'
            //                 this.widget = true
            //             }
            //             return res
            //         })
            //         .then(res => res.json())
            //         .then(res => {
            //             if (!res.exception)
            //                 this.updateList()
            //             this.ifWantDelete = false
            //             this.editing = false
            //             this.clearForm()
            //         })
            //         .catch(err => {
            //             this.widget = true
            //         });
            // },
            checkStatus() {
                if (!res.ok) {
                    if (res.status == 401)
                       this.result.message = 'Wystąpił błąd! Brak autoryzacji!'
                    else if (res.status == 429)
                       this.result.message = 'Zbyt wiele zapytań! Zwolnij!'
                    else
                       this.result.message = 'Wystąpił błąd! Spróbuj ponownie później!'
                    this.widget = true
                }
            return res
            }
        },
    }
</script>
