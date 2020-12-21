<template>
  <div class="cart">
    <div class="cart-title">
      cart
    </div>
    <div class="cart-inner">
      <div class="cart-item" v-for="item in cart" :key="item.name">
        <img :src="item.image" alt="">
        <div class="item-details">
          <h5>{{item.name}}</h5>
          <p>{{item.price}}</p>
        </div>
        <div class="badge-view">
          <div class="badge">{{item.quantity}}</div>
        </div>
      </div>
      <div class="total" v-if="cart?.length > 0">
        total: {{totalPrice}}
        <router-link to="/cart">view more</router-link>
      </div>
      <div class="total" v-else>
        no item in cart
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Cart',
  props: {
    cart: [Object]
  },
  data() {
    return {
      totalPrice: 0
    }
  },
  methods: {
    calculateTotalPrice() {
      const sumPrices = 
        this.cart?.length > 0
        ? this.cart.map(item => item.price * item.quantity) : [];
      const prices = sumPrices.reduce((a, b) => a + b, 0);
      this.totalPrice = prices;
    },
  },
  mounted() {
    this.calculateTotalPrice();
  }
}
</script>

<style lang="scss" scoped>
  .cart {
    width: 250px;
    background-color: $white;
    position: fixed;
    right: 80px;
    border-radius: 5px;
    margin-top: 10px;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.2);
    z-index: 3;

    &-inner {
      padding: 10px;
    }

    &-title {
      font-family: $secondary-font;
      margin-bottom: 10px;
      letter-spacing: 5px;
      font-size: 20px;
      background-color: $primary;
      color: $white;
      padding: 10px;
      padding-top: 5px;
      padding-bottom: 5px;
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
    }

    &-item {
      display: flex;
      align-items: center;
      border-bottom: 1px solid $grayDD;
      padding-bottom: 10px;
      margin-bottom: 10px;
      width: 100%;

      img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 3px;
        margin-right: 10px;
      }

      .badge-view {
        position: absolute;
        right: 10px;
      }

      .item-details {
        h5 {
          letter-spacing: 1px;
          font-size: 12px;
          text-transform: lowercase;
        }

        p {
          font-size: 10px;
        }
      }
    }

    .total {
      padding-bottom: 5px;
      font-size: 12px;

      a {
        float: right;
      }
    }
  }
</style>