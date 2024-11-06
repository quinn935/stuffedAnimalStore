<template>
        <div class="text-center mb-8">
             <h1 v-if="!loading" class="text-3xl font-semibold">
                {{ product.id? `Update Product: "${product.title}"` : 'Create New Product' }}
             </h1>
        </div>
  <div class="bg-white px-8 pt-8 pb-4 rounded-lg shadow max-w-screen-sm mx-auto lg:max-w-screen-xl">
    <Spinner v-if="loading"
            class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center z-50"
    />
    <form v-if="!loading" @submit.prevent="onSubmit">
        <div class="lg:grid lg:grid-cols-2">
            <div class="lg:col-span-1">
                <CustomInput class="mb-2" v-model="product.title" label="Product Title" />
                <CustomInput type="select" v-model="product.category_id" :select-options="selectCategories" label="Category"></CustomInput>
                <CustomInput type="textarea" class="mb-2" v-model="product.description" label="Description" />
                <CustomInput type="number" class="mb-2" v-model="product.price" label="Price" prepend="$" />
            </div>
            <div class="lg:col-span-1 px-4 pt-5 pb-4">
                <ImagePreview v-model="product.images"
                             v-model:deleted-images="product.deleted_images"
                             :images="product.images"/>
            </div>
        </div>

        <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="submit"
                    class="mt-3 mx-4 py-2 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4
                        bg-indigo-600 hover:bg-indigo-500 text-white">
                Submit
            </button>
            <router-link :to="{name: 'app.products'}" type="button"
                    class="mt-3 py-2 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4  bg-white"
                     ref="cancelButtonRef"
            >
                Cancel
            </router-link>
        </footer>
    </form>
  </div>
  </template>

  <script setup>
  import { ref, computed, onUpdated, watch, onMounted } from 'vue'
  import Spinner from '../../components/core/Spinner.vue';
  import CustomInput from '../../components/core/CustomInput.vue'
  import store from '../../store/index.js'
  import { useRoute, useRouter } from 'vue-router';
  import ImagePreview from '../../components/ImagePreview.vue';

  const loading = ref(false)

  const route = useRoute()
  const router = useRouter()

  const product = ref({
      id : null,
      title: null,
      category_id: null,
      images: [],
      deleted_images: [],
      description: null,
      price: null
  })

const categories = computed(()=>
        store.state.categories.data.filter(c=>c.parent_id !=null)
                                        .map(c=>({key: c.id, text: c.name})))

const selectCategories = computed(()=>[{key: '', text: 'Select Category'}, ...categories.value])
onMounted(()=>{
    getCategories()

    if(route.params.slug){
        loading.value = true
        store.dispatch('getProduct', route.params.slug)
            .then(({data})=>{
                loading.value = false
                product.value = data
       })
    }
})

function getCategories(){
    loading.value = true
    store.dispatch('getCategories').then(() => {
       loading.value = false
    }).catch(error => {
        console.error('Failed to load categories:', error)
    });
}



  function onSubmit() {
    loading.value = true
    if (product.value.id) {
        console.log(product.value)
      store.dispatch('updateProduct', product.value)
        .then((response)=>{
            loading.value = false
            if(response.status === 200){
                product.value = response.data
                store.dispatch('getProducts')
                router.push({name: 'app.products'})
            }
        })
    } else {
        console.log(product.value)
      store.dispatch('createProduct', product.value)
        .then((response)=>{
            loading.value = false
            if(response.status === 201){
                product.value = response.data
                store.dispatch('getProducts')
                router.push({name: 'app.products'})
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
