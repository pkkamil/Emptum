<template>
    <span class="status"><b>Status zamówienia:</b>
        <select name="status" id="status" v-model="status" @change='change'>
            <option value="ordered">Zamówiono</option>
            <option value="accepted">Zaakceptowano</option>
            <option value="sent">Wysłano</option>
            <option value="delivered">Dostarczono</option>
            <option value="returned">Zwrócono</option>
            <option value="cancelled">Anulowano</option>
        </select>
        <section class="widget" v-show="widget">
            <div class="widget__upper">
                <i class="fas fa-check" v-if="result.type == 'success'"></i>
                <i class="fas fa-exclamation-triangle" v-if="result.type == 'fail'"></i>
                <span class="status widget-span" v-html="result.message"></span>
                <i class="fas fa-times close" @click="widget = false"></i>
            </div>
        </section>
    </span>
</template>
<script>
    export default {
        props: [
            'previous_status',
            'user_id',
            'order_id',
            '_token'
        ],
         data() {
            return {
                status: '',
                widget: false,
                 result: {
                    type: '',
                    message: '',
                },
            };
        },
        mounted() {
            this.status = this.previous_status
        },
        methods: {
            change() {
                const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ user_id: this.user_id, _token: this._token, order_id: this.order_id, status: this.status })
                };
                fetch("/api/change-order-status", requestOptions)
                    .then(res => res.json())
                    .then(res => {
                        this.result.type = 'success'
                        this.result.message = 'Pomyślnie zmieniono status<p class="to-hide"> zamówienia</p>!'
                        this.widget = true
                        this.prepareWidget()
                    })
                    .catch(err => {
                        this.result.type = 'fail'
                        this.result.message = 'Wystąpił problem!<p class="to-hide"> Spróbuj ponownie później!</p>'
                        this.widget = true
                        this.prepareWidget()
                    });
            },
            prepareWidget() {
                document.querySelector('.widget').style.right = (window.screen.width - document.querySelector('.navbar__content').offsetWidth + 100) / 2 + 'px'
            }
        }
    }
</script>
