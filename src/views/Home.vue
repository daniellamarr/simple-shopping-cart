<template>
  <Header :cart="cart" />
  <div class="home">
    <div id="welcome">
      <div class="welcome-title">
        <h2>what's trending in</h2>
        <h1>2021</h1>
        <button>
          shop now
        </button>
      </div>
    </div>
    <div id="products">
      <div class="products-inner">
        <div class="title">
          wears & co.
        </div>
        <div class="products">
          <product
            v-for="product in products"
            :key="product.name"
            :product="product"
            :addToCart="addToCart" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Header from '@/components/Header';
import Product from '@/components/Product';
import {getProducts} from '@/api/products';

export default {
  name: 'Home',
  components: {
    Header,
    Product,
  },
  data() {
    return {
      products: [],
      cart: [],
    }
  },
  methods: {
    addToCart(product) {
      let cart = [];
      const fetchCart = localStorage.getItem('cart');
      if (!fetchCart) {
        product.quantity = 1;
        cart.push(product);
      } else {
        const decodedCart = JSON.parse(fetchCart);
        const findCartItem = decodedCart.findIndex(item => item.id === product.id);
        if (findCartItem >= 0) {
          decodedCart[findCartItem].quantity += 1;
          cart = [...decodedCart];
        } else {
          product.quantity = 1;
          cart = [...decodedCart];
          cart.push(product);
        }
      }
      localStorage.setItem('cart', JSON.stringify(cart));
      this.loadCart();
    },
    async fetchProducts() {
      const response = await getProducts();
      const {status, data} = response;
      if (status === 200) {
        this.products = data.data;
      }
    },
    loadCart() {
      const fetchCart = localStorage.getItem('cart');
      if (!fetchCart) {
        this.cart = [];
        return;
      }
      this.cart = JSON.parse(fetchCart);
    },
  },
  mounted() {
    this.loadCart();
    this.fetchProducts();
  }
}
</script>

<style lang="scss" scoped>
  .home {
    padding-bottom: 100px;
  }

  #welcome {
    width: 100%;
    height: 70vh;
    background-image: url(https://images.pexels.com/photos/2853909/pexels-photo-2853909.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-blend-mode: multiply;
    background-color: rgba(0, 0, 0, 0.5);
    background-attachment: fixed;
  }

  .welcome-title {
    position: absolute;
    left: 80px;
    top: 30vh;
    color: $white;
    letter-spacing: 5px;

    h2 {
      font-size: 14px;
    }

    button {
      background-color: $white;
      color: $primary;
      margin-top: 10px;
    }
  }

  #products {
    .products-inner {
      padding: 80px;
      padding-top: 50px;

      .title {
        font-family: $secondary-font;
        font-size: 30px;
        letter-spacing: 10px;
      }

      .products {
        margin-top: 30px;
        padding-bottom: 200px;
        display: grid;
        grid-row-gap: 50px;
        grid-auto-rows: 50px;
        grid-template-columns: repeat(auto-fit, minmax(250px,1fr));
        column-gap: 50px;
        // @include mobile {
        //   padding-left: 0;
        //   padding-right: 0;
        //   margin-top: 30px;
        // }
      }
    }
  }
</style>
