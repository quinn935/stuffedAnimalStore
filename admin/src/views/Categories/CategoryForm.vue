<template>
    <div class="text-center mb-8">
         <h1 v-if="!loading" class="text-3xl font-semibold">
            {{ category.id? `Update Category: "${category.name}"` : 'Create New Category' }}
         </h1>
    </div>
<div class="bg-white px-8 pt-8 pb-4 rounded-lg shadow max-w-screen-sm mx-auto lg:max-w-screen-lg">
<Spinner v-if="loading"
        class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center z-50"
/>
<form v-if="!loading" @submit.prevent="onSubmit">
    <div class="">
        <CustomInput class="mb-2" v-model="category.name" label="Category Name" />
        <CustomInput type="select" class="mb-2" v-model="category.parent_id" :select-options="parentCategories" label="Parent Category"></CustomInput>
        <CustomInput type="checkbox" class="mb-2" v-model="category.active" label="Active"></CustomInput>
    </div>

    <footer class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="submit"
                class="mt-3 mx-4 py-2 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4
                    bg-indigo-600 hover:bg-indigo-500 text-white">
            Submit
        </button>
        <router-link :to="{name: 'app.categories'}" type="button"
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

const loading = ref(false)

const route = useRoute()
const router = useRouter()

const category = ref({})


onMounted(()=>{
   getCategories()

if(route.params.id){
    loading.value = true
    store.dispatch('getCategory', route.params.id)
        .then(({data})=>{
            loading.value = false
            category.value = data
   })
}
})

function getCategories(){
    loading.value = true;
    store.dispatch('getCategories').then(() => {
       loading.value = false;
    }).catch(error => {
        console.error('Failed to load categories:', error);
    });
}

const parentCategories = computed(()=>{
    if(route.params.id){
        return [
        {key: '', text: 'Select Parent Category'},
        ...store.state.categories.data.map(c=>({key: c.id, text: c.name}))
    ].filter(c=>{
        if(category.value.id){
            return c.key !== category.value.id
        }
    })
    }else{
        return [
        {key: '', text: 'Select Parent Category'},
        ...store.state.categories.data.map(c=>({key: c.id, text: c.name}))
        ]
    }
})



// watch(() => props.category, (newCategory, oldCategory) => {
//  console.log('Old category:', oldCategory);
//   console.log('New category:', newCategory);
//   if (newCategory) {
//     category.value = {
//       id: newCategory.id,
//       title: newCategory.title,
//       image: newCategory.image_url,
//       description: newCategory.description,
//       price: newCategory.price
//     };
//   }
// }, {
//   immediate: true,
//   deep: true  // Use this if you need to watch for nested changes within the category object
// });


function onSubmit() {
loading.value = true
//covert category.value.active to boolean(maybe string or number)
category.value.active = !!category.value.active
if (category.value.id) {
  store.dispatch('updateCategory', category.value)
    .then((response)=>{
        loading.value = false
        if(response.status === 200){
            category.value = response.data
            store.dispatch('getCategories')
            router.push({name: 'app.categories'})
        }
    })
} else {
   //category.value = {active:true, name:"Bears", parent_id:"1"}
  store.dispatch('createCategory', category.value)
    .then((response)=>{
        loading.value = false
        if(response.status === 201){
            category.value = response.data
            store.dispatch('getCategories')
            router.push({name: 'app.categories'})
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
