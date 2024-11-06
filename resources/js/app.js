
import './bootstrap';
import '../css/app.css';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect'
import {Swiper} from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/swiper-bundle.css';
import {post} from './http';


Swiper.use([ Pagination, Navigation ])
Alpine.plugin(intersect)

window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {

    Alpine.data("toast", () => ({
      visible: false,
      delay: 3000,
      percent: 0,
      interval: null,
      timeout: null,
      message: null,
      close() {
        this.visible = false;
        clearTimeout(this.timeout);
      },
      show(message) {
        this.visible = true;
        this.message = message;

        if (this.timeout) {
            clearTimeout(this.timeout);
            this.timeout = null;
          }

        this.timeout = setTimeout(() => {
          this.visible = false;
          this.message = null;
          this.timeout = null;
        }, this.delay);


      },
    }));


    Alpine.data("productItem", (product) => {
        return {
          product,
          addToCart(quantity = 1) {
              post(this.product.addToCartUrl, {quantity})//fetch post request to {{ route('cart.add', $product) }}
              .then(result=>{
                  //dispatch a custom event to update the cart count that used in other components
                  this.$dispatch('cart-change', {count: result.count})
                  //@cart-change.window = "cartItemsCount = $event.detail.count"
                  this.$dispatch('notify', {
                      message: "The item was added into the cart"
                  });
              })
              .catch(response=>{
                  console.log(response);
              })
          },
          removeItemFromCart() {
              post(this.product.removeUrl)
              .then(result=>{
                  this.$dispatch('notify', {
                      message: 'The item was removed from cart'
                  });
                  this.$dispatch('cart-change', {count: result.count})
                  this.cartItems = this.cartItems.filter(p=>p.id != product.id)
              })
          },
          changeQuantity(){
              post(this.product.updateQuantityUrl, {quantity: product.quantity})
              .then(result=>{
                  this.$dispatch('cart-change', {count: result.count})
                  this.$dispatch('notify', {
                      message: 'The item quantity was updated'
                  });
              })
          }

        };
      });

      Alpine.data('swiper', () => ({
        init() {
            this.$nextTick(() => {
                 new Swiper(this.$refs.swiperContainer, {
                    loop: true,
                    navigation: {
                        nextEl: this.$refs.nextButton,
                        prevEl: this.$refs.prevButton,
                    },
                    slidesPerView: 2,
                    breakpoints: {
                        768: {
                            slidesPerView: 3,
                          },
                        1024: {
                            slidesPerView: 4,
                          },
                    },
                    pagination: {
                        el: this.$refs.pagination,
                        clickable: true,
                    },
                });
            });
        }
    }));
});


Alpine.start()
