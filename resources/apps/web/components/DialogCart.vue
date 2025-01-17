<template>
    <noodle-dialog :visible="visible" title="Your Cart" @close="close">
        <noodle-container :loading="loading">
            <div class="dialog-cart-wrapper">
                <div class="cart-items">
                    <div class="cart-item" v-for="(item,index) in cart_items" :key="index">
                        <div class="cart-item__remove">
                            <i class="bi bi-x-circle" @click="removeItem(index)"></i>
                        </div>
                        <div class="cart-item__image">
                            <img :src="item.image" alt="">
                        </div>
                        <div class="cart-item__main">
                            <div class="cart-item__title">
                                <div class="title">{{ item.title }}</div>
                                <div class="metas">{{metaValue(item.meta_data)}}</div>
                            </div>
                            <div class="cart-item__price text-bull-cyan">€{{ item.price }}</div>
                            <div class="cart-item__qty">
                                <noodle-number-control v-model="item.quantity" @change="onQuantityChange(index)"/>
                            </div>
                        </div>
                        <div class="cart-item__total text-bull-cyan">€{{ item.total }}</div>
                    </div>
                </div>
                <div class="cart-totals">
                    <div class="cart-total">
                        <div class="cart-total__label cart-total__total">Cart Total</div>
                        <div class="cart-total__value">€{{ total }}</div>
                    </div>
                </div>
                <div class="cart-actions">
                    <div class="cart-action">
                        <button class="btn btn-danger text-uppercase" @click="onCheckout">Check Out</button>
                    </div>
                    <div class="cart-action">
                        <button class="btn btn-danger text-uppercase" @click="close">Continue</button>
                    </div>
                </div>
            </div>
        </noodle-container>
    </noodle-dialog>
</template>

<script>
import HttpClient from "../HttpClient";
import NoodleDialog from "./NoodleDialog.vue";
import NoodleNumberControl from "./NoodleNumberControl.vue";

export default {
    name: "DialogCart",
    components: {NoodleNumberControl, NoodleDialog},
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            visible: false,
            cart_items: [],
            loading: true
        }
    },
    computed: {
        total() {
            let total = 0;
            this.cart_items.forEach((item) => {
                total += parseFloat(item.total);
            });
            return total.toFixed(2);
        }
    },
    watch: {
        value(val) {
            if (val !== this.visible) {
                this.visible = val;
            }

            if (val) {
                this.fetchList();
            }
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        fetchList() {
            HttpClient.get('/carts').then((res) => {
                res.data.items.forEach((item) => {
                    Object.defineProperty(item, 'total', {
                        get() {
                            return (this.price * this.quantity).toFixed(2);
                        },
                    });
                });
                this.cart_items = res.data.items;
            }).catch(reason => {
                console.log(reason.message);
            }).finally(() => {
                this.loading = false;
            });
        },
        removeItem(index) {
            let item = this.cart_items[index];
            this.loading = true;
            HttpClient.delete(`/carts/${item.id}`).then((res) => {
                this.cart_items.splice(index, 1);
            }).catch(reason => {

            }).finally(() => {
                this.loading = false;
            });
        },
        onQuantityChange(index) {
            let item = this.cart_items[index];
            let {quantity, id} = item;
            this.loading = true;
            HttpClient.put(`/carts/${id}`, {
                quantity: quantity
            }).then((res) => {

            }).catch(reason => {

            }).finally(() => {
                this.loading = false;
            });
        },
        onCheckout() {
            window.location.href = '/checkout';
        },
        metaValue(meta_data) {
            return meta_data.map((item) => {
                return item.value;
            }).join(', ');
        }
    },
    mounted() {
        this.visible = this.value;
    }
}
</script>

<style scoped>

</style>