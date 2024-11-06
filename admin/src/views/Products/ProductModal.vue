<template>
    <TransitionRoot appear :show="show" as="template">
      <Dialog as="div" @close="closeModal" class="relative z-10">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black/25 bg-oopacity-75" />
        </TransitionChild>

        <div class="fixed inset-0 overflow-y-auto">
          <div
            class="flex min-h-full items-center justify-center p-4 text-center"
          >
            <TransitionChild
              as="template"
              enter="duration-300 ease-out"
              enter-from="opacity-0 scale-95"
              enter-to="opacity-100 scale-100"
              leave="duration-200 ease-in"
              leave-from="opacity-100 scale-100"
              leave-to="opacity-0 scale-95"
            >
              <DialogPanel
                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left align-middle shadow-xl transition-all"
              >

              <Spinner v-if="loading"
                       class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center"
              />
              <header class="py-3 px-4 flex justify-between items-center">
                  <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                      {{ product.id? `Update product: "${props.product.title}"` : "Create new product" }}
                  </DialogTitle>
                  <button @click="closeModal()"
                      class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                  >
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>
                  </button>
              </header>
              <form @submit.prevent="onSubmit">
                  <div class="bg-white px-4 pt-5 pb-4">
                      <CustomInput class="mb-2" v-model="product.title" label="Product Title" />
                      <CustomInput type="textarea" class="mb-2" v-model="product.description" label="Description" />
                      <CustomInput type="file" class="mb-2" @change = "handleImageChange"/>
                      <template v-if="product.image">
                        <div class="my-4">
                            <img v-if="product.image" class="w-24" :src="product.image" :alt="product.title">
                        </div>
                      </template>
                      <CustomInput type="number" class="mb-2" v-model="product.price" label="Price" prepend="$" />
                  </div>
                  <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                      <button type="submit"
                              class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 px-2
                                    bg-indigo-600 hover:bg-indigo-500 text-white">
                          Submit
                      </button>
                      <button type="button"
                              class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 px-2 bg-white"
                              @click="closeModal" ref="cancelButtonRef"
                       >
                          Cancel
                      </button>
                  </footer>
              </form>

              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </template>

  <script setup>
  import { ref, computed, onUpdated, watch, toRefs } from 'vue'
  import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
  } from '@headlessui/vue'
  import Spinner from '../../components/core/Spinner.vue';
  import CustomInput from '../../components/core/CustomInput.vue'
  import store from '../../store/index.js'

  const loading = ref(false)

  const props = defineProps({
      modelValue: Boolean,
      product: {
          required: true,
          type: Object
      }

  })

//   const {product} = toRefs(props)

  const product = ref({
      id: props.product.id,
      title: props.product.title,
      image: props.product.image,
      description: props.product.description,
      price: props.product.price
  })

  const emit = defineEmits(['update:modelValue', 'close'])

  const show = computed({
      get: ()=>props.modelValue,
      set: (value)=>emit('update:modelValue', value)//update the showModal when the show is updated
  })

  function handleImageChange(file){
    product.value.image = URL.createObjectURL(file);
    console.log('file', product.value.image)
  }

//   onUpdated(() => {
//       product.value = {
//           id: props.product.id,
//           title: props.product.title,
//           image: props.product.image,
//           description: props.product.description,
//           price: props.product.price
//       }
//       console.log('onupdate', props.product)
//       console.log('product', product.value)
//   })

watch(() => props.product, (newProduct, oldProduct) => {
 console.log('Old product:', oldProduct);
  console.log('New product:', newProduct);
  if (newProduct) {
    product.value = {
      id: newProduct.id,
      title: newProduct.title,
      image: newProduct.image_url,
      description: newProduct.description,
      price: newProduct.price
    };
  }
}, {
  immediate: true,
  deep: true  // Use this if you need to watch for nested changes within the product object
});
  function updateProductImage(file){
    product.image.value = file
  }

  function closeModal() {
    show.value = false
    emit('close')
  }
  function onSubmit() {
    loading.value = true
    if (product.value.id) {
      store.dispatch('updateProduct', product.value)
        .then((response)=>{
            loading.value = false
            if(response.status === 200){
                store.dispatch('getProducts')
                closeModal()
            }
        })
    } else {
      store.dispatch('createProduct', product.value)
        .then((response)=>{
            loading.value = false
            if(response.status === 201){
                store.dispatch('getProducts')
                closeModal()
            }
        })
        .catch(error=>{
            loading.value = false
        })
    }
  }
  </script>


  <script setup>
  </script>
