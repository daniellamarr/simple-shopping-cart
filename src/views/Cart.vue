<template>
  <Header :light="true" :cart="cart" />
  <div id="cart">
    <div class="cart-title">
      CART
    </div>
    <div class="checkout-table">
      <div class="table">
        <table>
          <thead>
            <th>product</th>
            <th>quantity</th>
            <th>price</th>
            <th></th>
          </thead>
          <tbody>
            <tr v-for="item in cart" :key="item.id">
              <td>
                <div class="product-info">
                  <img :src="item.image" alt="">
                  <div>
                    <p>{{item.name}}</p>
                  </div>
                </div>
              </td>
              <td>
                <input
                  type="number"
                  class="quantity"
                  minlength="1"
                  min="1"
                  max="10"
                  :onchange="(e) => updateQuantity(item, e)"
                  :value="item.quantity">
              </td>
              <td>{{item.price * item.quantity}}</td>
              <td>
                <button :onclick="() => removeFromCart(item)">
                  <Icon icon="close" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="checkout">
        <div class="checkout-title">
          <p>CHECKOUT</p>
        </div>
        <div class="form">
          <input type="text" placeholder="Name" v-model="name">
          <input type="email" placeholder="Email" v-model="email">
          <input type="tel" placeholder="Phone Number" v-model="phone">
        </div>
        <div class="error">{{error}}</div>
        <div class="checkout-button">
          <button :onclick="makePayment">
            <loader v-if="loading" />
            <span v-else>Pay N{{totalPrice === 0 ? '0.0' : totalPrice}}</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Icon from 'vue-themify-icons';
import Header from '@/components/Header';
import Loader from '@/icons/Loader';
import {createOrder} from '@/api/orders';

export default {
  name: 'Cart',
  components: {
    Icon,
    Header,
    Loader
  },
  data() {
    return {
      name: '',
      email: '',
      phone: '',
      cart: [],
      totalPrice: 0,
      error: '',
      loading: false,
    }
  },
  methods: {
    loadCart() {
      const fetchCart = localStorage.getItem('cart');
      if (!fetchCart) {
        this.cart = [];
        return;
      }
      this.cart = JSON.parse(fetchCart);
      this.calculateTotalPrice();
    },
    calculateTotalPrice() {
      const sumPrices = 
        this.cart?.length > 0
        ? this.cart.map(item => item.price * item.quantity) : [];
      const prices = sumPrices.reduce((a, b) => a + b, 0);
      this.totalPrice = prices;
    },
    removeFromCart(product) {
      const findCartItem = this.cart.findIndex(item => item.id === product.id);
      this.cart.splice(findCartItem, 1);
      localStorage.setItem('cart', JSON.stringify(this.cart));

      this.loadCart();
    },
    async makePayment() {
      try {
        if (!this.name || !this.email || !this.phone) {
          this.error = 'please fill in all input fields';
          return false;
        }
        this.loading = true;
        this.error = '';

        const paymentProducts = this.cart.map(item => {
          return {
            quantity: item.quantity,
            id: item.id
          }
        })

        const response = await createOrder({
          name: this.name,
          email: this.email,
          phone: this.phone,
          price: this.totalPrice,
          products: paymentProducts
        });

        console.log(response);
        this.loading = false;

        if (response.status === 201) {
          localStorage.removeItem('cart');
          window.alert('Payment successful!');
        }
        this.loadCart();
        this.$router.push('/');
      } catch (err) {
        console.log(err);
        window.alert('We could not complete this transaction at this time');
        this.loading = false;
      }
    },
    updateQuantity(product, e) {
      const fetchCart = localStorage.getItem('cart');
      const decodedCart = JSON.parse(fetchCart);
      const findCartItem = decodedCart.findIndex(item => item.id === product.id);
      if (findCartItem >= 0) {
        decodedCart[findCartItem].quantity = e.target.value;
      }
      localStorage.setItem('cart', JSON.stringify(decodedCart));
      this.loadCart();
    }
  },
  mounted() {
    this.loadCart();
  },
}
</script>

<style lang="scss" scoped>
  #cart {
    padding: 80px;
    padding-top: 120px;

    .cart-title {
      letter-spacing: 20px;
      font-size: 20px;
      font-weight: bold;
    }
  }

  .checkout-table {
    display: flex;
  }

  .table {
    margin-top: 30px;
    width: 65%;

    table {
      width: 100%;

      thead {
        th {
          text-align: left;
          font-weight: 400;
          padding-bottom: 20px;
          border-bottom: 1px solid $grayDD;
        }
      }

      tbody {
        tr {
          td {
            padding-top: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid $grayDD;

            .quantity {
              padding: 10px;
              border-radius: 20px;
              border: 1px solid $grayDD;
              outline: none;
              width: 50px;
              text-align: center;
              font-family: $font-family;
            }

            .product-info {
              display: flex;
              align-items: center;

              img {
                height: 70px;
                width: 70px;
                object-fit: cover;
                border-radius: 5px;
                margin-right: 10px;
              }
            }
          }
        }
      }
    }
  }

  .checkout {
    position: fixed;
    background-color: $primary;
    color: $white;
    width: 25%;
    height: 320px;
    padding: 20px;
    border-radius: 5px;
    right: 80px;
    z-index: 0;

    &-title {
      letter-spacing: 10px;
      font-size: 14px;
      font-weight: bold;
    }

    .form {
      margin-top: 40px;

      input {
        background-color: transparent;
        border: 1px solid $white;
        border-radius: 20px;
        padding: 10px;
        width: calc(100% - 20px);
        color: $white;
        outline: none;
        margin-bottom: 20px;
        font-family: $font-family;

        &::placeholder {
          color: $white;
        }
      }
    }

    .totalPrice {
      letter-spacing: 3px;
      font-size: 20px;
      font-weight: bold;
      margin-top: 50px;
    }

    &-button {
      margin-top: 30px;

      button {
        background-color: $white;
        color: $primary;
        width: 100%;
      }
    }

    .error {
      color: $white;
      font-size: 12px;
    }
  }
</style>
