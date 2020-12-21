<template>
  <header>
    <div class="header">
      <div :class="`logo ${light && 'color-primary'}`">
        apollo 11
      </div>
      <nav>
        <div class="cart-icon" :onClick="toggleCart">
          <Icon :icon="`shopping-cart ${light && 'color-primary'}`" />
          <span class="badge">{{cart?.length || 0}}</span>
        </div>
        <cart v-if="cartOpen" :cart="cart" />
      </nav>
      <div class="clear" />
    </div>
  </header>
</template>

<script>
import Icon from 'vue-themify-icons';
import Cart from './Cart';

export default {
  name: 'Header',
  components: {
    Icon,
    Cart
  },
  data() {
    return {
      cartOpen: false,
    }
  },
  props: {
    cart: Array,
    light: Boolean
  },
  methods: {
    toggleCart() {
      this.cartOpen = !this.cartOpen;
    }
  },
}
</script>

<style lang="scss" scoped>
  header {
    width: 100%;
    position: fixed;
    z-index: 2;

    .header {
      padding: 20px;
      padding-left: 80px;
      padding-right: 80px;
    }
  }

  .logo {
    font-weight: bold;
    font-family: $secondary-font;
    letter-spacing: 5px;
    float: left;
    color: $white;
  }

  .color-primary {
    color: $primary !important;
  }

  nav {
    float: right;

    .cart-icon {
      display: flex;
      cursor: pointer;

      i {
        font-size: 20px;
        color: $white;
      }
    }
  }
</style>