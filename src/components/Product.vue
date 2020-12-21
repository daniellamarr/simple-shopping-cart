<template>
  <div class="product" :style="`background-image: url(${product.image});`">
    <div class="item-overlay">
      <div class="details">
        <h4>{{product.name}}</h4>
        <h5>{{product.price}}</h5>
        <button :onclick="() => addToCart(product)">
          <Icon icon="plus" />
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import Icon from 'vue-themify-icons';

export default {
  name: 'Product',
  components: {
    Icon,
  },
  props: {
    product: {
      name: String,
      image: String,
      price: String
    },
    addToCart: Function
  }
}
</script>

<style lang="scss" scoped>
  .product {
    background-size: cover;
    background-position: center;
    border-radius: 5px;
    width: 300px;
    height: 400px;
    transition: all 0.5s;
    &:hover {
      transform: scale(1.1);

      .item-overlay {
        display: flex;
      }
    }

    .item-overlay {
      height: 100%;
      display: none;
      border-radius: 5px;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: rgba(84, 68, 218, 0.8);
      cursor: pointer;
      transition: all 0.5s;

      .details {
        display: flex;
        flex-direction: column;
        color: $white;
        padding: 20px;
        align-items: center;
        transition: all 0.5s;

        button {
          position: absolute;
          right: 0;
          top: 0;
          background-color: $white;
          color: $primary;
          border-top-left-radius: 0;
          border-bottom-right-radius: 0;
          border-right: 0.5px solid rgba(84, 68, 218, 0.8);
          border-top: 0.5px solid rgba(84, 68, 218, 0.8);
        }
      }
    }
  }
</style>