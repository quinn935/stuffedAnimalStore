
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
      init(){
        if (this.timeout) {
            clearTimeout(this.timeout);
            this.timeout = null;
          }
      },
      visible: false,
      delay: 3000,
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
                  this.$dispatch('cart-items-change', {cart_items: result.cart_items})
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
                  this.$dispatch('cart-items-change', {cart_items: result.cart_items})
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
                  this.$dispatch('cart-items-change', {cart_items: result.cart_items})
                  this.$dispatch('cart-change', {count: result.count})
                  this.$dispatch('notify', {
                      message: 'The item quantity was updated'
                  });
              })
          }

        };
      });



      Alpine.data('reviewFormHandler', (product) => ({
        product,
        visible:false,
        formData:{
            rating: '',
            review_subject: '',
            review_comment: '',
            product_id: product.product_id || '',
            created_by: product.created_by || '',
            updated_by: product.updated_by || ''
        },
        errors: {},
        submitReviewForm(){
            this.errors = {};
            post(this.product.postReviewUrl, this.formData)
            .then(result=>{
                this.$dispatch('notify', {
                    message: 'Your review has been posted successfully'
                });
                this.$dispatch('update-product-reviews', {reviews: result.product_reviews});
                this.$dispatch('open-review-content-after-post-new-review');
                this.$dispatch('update-product-review-count', {count: result.product_review_count});
                this.$dispatch('update-product-average-rating', {rating: result.product_average_rating});
                this.formData = {rating: '', review_subject: '', review_comment: '', product_id: this.product.product_id, created_by: this.product.created_by, updated_by: this.product.updated_by};
                this.visible = false;
                this.$dispatch('remove-overlay');
            })
            .catch(error=>{
                if(error.errors){
                    this.errors = error.errors;
                        // rating
                        // :
                        // ['The rating field is required.']
                        // review_comment
                        // :
                        // ['The review comment field is required.']
                        // review_subject
                        // :
                        // ['The review subject field is required.']
                }
            })
        }
      }));

      Alpine.data('dateFormatter', (rawDate)=>({
            rawDate,
            formattedDate(){
                return new Date(this.rawDate).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }
      }));


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
