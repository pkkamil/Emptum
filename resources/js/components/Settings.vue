<template>
    <section class="admin__content__settings">
        <div class="admin__content__settings__basic">
            <div class="admin__content__settings__basic__homepage-background">
                <h4>Zmiana tła strony powitalnej</h4>
                <label for="homepage-background" class="admin__content__settings__basic__homepage-background__image">
                    <img v-if="settings.homepage_background" :src="settings.homepage_background" alt="Tło strony powitalnej">
                    <i class="fas fa-camera"></i>
                </label>
                <input accept="image/*" name="homepage-background" id="homepage-background" type="file" @change="showCropper()">
                <span>Zaleca się zdjęcia o rozdzielczości Full HD i&nbsp;proporcjach 16:9</span>
            </div>
            <div class="admin__content__settings__basic__welcome">
                <div class="admin__content__settings__basic__welcome__box-text">
                    <h4>Zmiana tekstu okna powitalnego</h4>
                    <label for="welcome-box-text" class="admin__content__settings__basic__welcome-box-text__input input">
                        <input type="text" name="welcome-box-text" id="welcome-box-text" v-model="settings.welcome_box_text" placeholder="Przeglądaj wspaniałe produkty" required @change="changeWelcomeBoxText()">
                    </label>
                </div>
                <div class="admin__content__settings__basic__welcome__box-button-text">
                    <h4>Zmiana tekstu przycisku okna powitalnego</h4>
                    <label for="welcome-box-button-text" class="admin__content__settings__basic__welcome-box-button-text__input input">
                        <input type="text" name="welcome-box-button-text" id="welcome-box-button-text" v-model="settings.welcome_box_button_text" placeholder="Przeglądaj" required @change="changeWelcomeBoxButtonText()">
                    </label>
                </div>
            </div>
        </div>
        <section class="admin__content__new-product__background" v-if="ifCropper">
            <section class="admin__content__new-product__background__crop-image">
                <Cropper ref="cropper" :src="image" class="cropper-container" :max-container-width="900" :max-container-height="600" :canvas= "{ minHeight: 800, minWidth: 450, maxHeight: 2160, maxWidth: 3840 }" :stencil-props="{ aspectRatio: 16/9 }" />
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
    </section>
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
                settings: {
                    homepage_background: '/images/bg-homepage.jpg',
                    welcome_box_text: '',
                    welcome_box_button_text: '',
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
            this.loadSettings()
        },
        methods: {
            loadSettings() {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ user_id: this.user_id, _token: this._token })
                };
                fetch("/api/load-settings", requestOptions)
                    .then(res => res.json())
                    .then(res => {
                        this.settings.welcome_box_text = res['welcome_box_text']
                        this.settings.welcome_box_button_text = res['welcome_box_button_text']
                    })
                    .catch(err => {
                        this.result.type = 'fail'
                        this.result.message = 'Wystąpił problem!<p class="to-hide"> Spróbuj ponownie później!</p>'
                        this.widget = true
                    })
                    .finally(() => {
                        this.setRighWidgetPosition()
                    });
            },
            showCropper() {
                this.image = URL.createObjectURL(event.target.files[0])
                if (this.image)
                    this.ifCropper = true
            },
            crop() {
                const { canvas } = this.$refs.cropper.getResult();
                this.settings.homepage_background = canvas.toDataURL()
                this.ifCropper = false
                this.changeHomepageBackground()
            },
            changeHomepageBackground() {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ user_id: this.user_id, _token: this._token, image: this.settings.homepage_background })
                };
                fetch("/api/change-homepage-background", requestOptions)
                    .then(res => res.json())
                    .then(res => {
                        this.result.type = 'success'
                        this.result.message = 'Zmieniono tło strony<p class="to-hide"> powitalnej</p>'
                        this.widget = true
                    })
                    .catch(err => {
                        this.result.type = 'fail'
                        this.result.message = 'Wystąpił problem!<p class="to-hide"> Spróbuj ponownie później!</p>'
                        this.widget = true
                    })
                    .finally(() => {
                        this.setRighWidgetPosition()
                    });
            },
            changeWelcomeBoxText() {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ user_id: this.user_id, _token: this._token, value: this.settings.welcome_box_text })
                };
                fetch("/api/change-welcome-box-text", requestOptions)
                    .then(res => res.json())
                    .then(res => {
                        this.result.type = 'success'
                        this.result.message = 'Zmieniono tekst okna<p class="to-hide"> powitalnego</p>'
                        this.widget = true
                    })
                    .catch(err => {
                        this.result.type = 'fail'
                        this.result.message = 'Wystąpił problem!<p class="to-hide"> Spróbuj ponownie później!</p>'
                        this.widget = true
                    })
                    .finally(() => {
                        this.setRighWidgetPosition()
                    });
            },
            changeWelcomeBoxButtonText() {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ user_id: this.user_id, _token: this._token, value: this.settings.welcome_box_button_text })
                };
                fetch("/api/change-welcome-box-button-text", requestOptions)
                    .then(res => res.json())
                    .then(res => {
                        this.result.type = 'success'
                        this.result.message = 'Zmieniono tekst przycisku<p class="to-hide"> okna powitalnego</p>'
                        this.widget = true
                    })
                    .catch(err => {
                        this.result.type = 'fail'
                        this.result.message = 'Wystąpił problem!<p class="to-hide"> Spróbuj ponownie później!</p>'
                        this.widget = true
                    })
                    .finally(() => {
                        this.setRighWidgetPosition()
                    });
            },
            setRighWidgetPosition() {
                document.querySelector('.widget').style.right = (window.screen.width - document.querySelector('.navbar__content').offsetWidth + 100) / 2 + 'px'
            }
        }
    }
</script>
