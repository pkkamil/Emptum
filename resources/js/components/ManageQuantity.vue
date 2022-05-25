<template>
    <label for="items" class="product__content__informations__items">
        <i class="fas fa-minus" @click="decrement"></i>
        <input type="number" name="items" id="items" v-model="items" value="1" :max="this.quantity" min="1" @input="input" @change="change">
        <i class="fas fa-plus" @click="increment"></i>
    </label>
</template>

<script>
    export default {
        props: [
            'product_id',
        ],
         data() {
            return {
                items: 1,
                quantity: 0,
            };
        },
        mounted() {
            fetch('/api/get-quantity/' + this.product_id)
                .then(res => res.json())
                .then(res => {
                    this.quantity = res;
            })
        },
        methods: {
            increment() {
                if (this.items < this.quantity)
                    this.items++;
            },
            decrement() {
                if (this.items > 1)
                    this.items--;
            },
            input() {
                if (this.items > this.quantity)
                    this.items = this.quantity
            },
            change() {
                if (this.items < 1)
                    this.items = 1
            }
        }
    }
</script>
