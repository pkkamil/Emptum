<template>
    <form class="admin__content__new-product" autocomplete="off" @submit.prevent=submit method="POST">
        <div class="admin__content__new-product__single">
            <label for="image" class="admin__content__new-product__single__image">
                <img v-if="product.image" :src="product.image" alt="">
                <i class="fas fa-camera"></i>
            </label>
            <input accept="image/*" name="image" id="image" type="file" @change="onChange()">
        </div>
        <div class="admin__content__new-product__single">
            <label for="product_name" class="admin__content__new-product__single__input">
                <input type="text" name="product_name" id="product_name" v-model="product.name" placeholder="Nazwa produktu" required @change="generateLink()">
            </label>
            <label for="link" class="admin__content__new-product__single__input">
                <input type="text" name="link" id="link" v-model="product.link" placeholder="Automatycznie wygenerowany link" required @change="checkLink()">
            </label>
            <div class="admin__content__new-product__single__two">
                <label for="quantity" class="admin__content__new-product__single__two__input-small">
                    <input type="number" name="quantity" id="quantity" v-model="product.quantity" placeholder="Ilość sztuk" required>
                </label>
                <label for="price" class="admin__content__new-product__single__two__input-small">
                    <input type="text" name="price" id="price" v-model="product.price" placeholder="Cena [zł]" required>
                </label>
            </div>
        </div>
        <div class="admin__content__new-product__single">
            <label for="description" class="admin__content__new-product__single__textarea">
                <textarea name="description" id="description" v-model="product.description" placeholder="Opis produktu" required></textarea>
            </label>
            <button type="submit" class="button-small dark">Dodaj produkt</button>
        </div>
        <section class="admin__content__new-product__background" v-if="ifCropper">
            <section class="admin__content__new-product__background__crop-image">
                <Cropper ref="cropper" :src="image" class="cropper-container" :max-container-width="900" :max-container-height="600" :canvas= "{ minHeight: 100, minWidth: 100, maxHeight: 600, maxWidth: 600 }" :stencil-props="{ aspectRatio: 1 }" />
                <span class="button button-small dark" @click="crop()">Przytnij</span>
                <span class="button button-small bright" @click="ifCropper = false">Wróć</span>
            </section>
        </section>
        <section class="widget" v-show="widget">
            <div class="widget__upper">
                <i class="fas fa-check" v-if="result.type == 'success'"></i>
                <i class="fas fa-exclamation-triangle" v-if="result.type == 'fail'"></i>
                <span class="status" v-html="result.message"></span>
                <i class="fas fa-times close" @click="widget = false"></i>
            </div>
        </section>
    </form>
</template>
<script>
    import { Cropper } from 'vue-advanced-cropper'
    import 'vue-advanced-cropper/dist/style.css';
    export default {
        props: [
            'user_id',
            '_token',
        ],
        components: {
            Cropper,
        },
        data() {
            return {
                product: {
                    id: '',
                    name: '',
                    image: '',
                    description: '',
                    quantity: '',
                    price: '',
                    link: '',
                },
                result: {
                    type: '',
                    message: '',
                },
                image: '',
                ifCropper: false,
                widget: false,
            };
        },
        mounted() {
            this.reloadID()
        },
        methods: {
            reloadID() {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ user_id: this.user_id, _token: this._token })
                };
                fetch("/api/get-last-productid", requestOptions)
                    .then(res => res.json())
                    .then(res => {
                        this.product.id = res;
                    })
            },
            submit() {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: this.product.id, name: this.product.name, description: this.product.description, image: this.product.image, price: this.product.price, quantity: this.product.quantity, link: this.product.link, user_id: this.user_id, _token: this._token })
                 };
                fetch("/api/add-new-product", requestOptions)
                    .then(res => res.json())
                    .then(res => {
                        this.result.type = 'success'
                        this.result.message = 'Pomyślnie dodano<p class="to-hide"> nowy produkt</p>!'
                        this.product = {}
                        this.reloadID()
                        this.widget = true
                    })
                    .catch(err => {
                        this.result.type = 'fail'
                        this.result.message = 'Wystąpił problem!<p class="to-hide"> Spróbuj ponownie później!</p>'
                        this.widget = true
                    })
                    .finally(() => {
                        this.setRighWidgetPosition()
                    })
            },
            onChange() {
                this.image = URL.createObjectURL(event.target.files[0])
                if (this.image)
                    this.ifCropper = true
            },
            crop() {
                const { canvas } = this.$refs.cropper.getResult();
                this.product.image = canvas.toDataURL()
                this.ifCropper = false
            },
            generateLink() {
                this.product.link = '/p/' + this.product.id + '-' + this.product.name.replace(/\s+/g, '-').toLowerCase()
            },
            checkLink() {
                if (!this.product.link.includes('/p/' + this.product.id + '-'))
                    this.product.link = '/p/' + this.product.id + '-' + this.product.link.replace(/\s+/g, '-').toLowerCase()
            },
            setRighWidgetPosition() {
                document.querySelector('.widget').style.right = (window.screen.width - document.querySelector('.navbar__content').offsetWidth + 100) / 2 + 'px'
            }
        }
    }
</script>
