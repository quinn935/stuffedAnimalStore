<template>
    <GuestLayout title="Admin Sign In">
     <form class="space-y-6" method="POST" @submit.prevent="login">
            <!-- error message -->
         <div v-if="errorMsg" class="flex items-center justify-between py-3 px-5 bg-red-500 text-white rounded">
            {{ errorMsg }}
            <span @click="errorMsg = ''"
            class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer
            hover:bg-black/20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                     <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </span>
        </div>
           <div>
             <label for="email" class="block font-medium leading-6 text-gray-800 md:text-base">Email address</label>
             <div class="mt-2">
               <input id="email" name="email" v-model="user.email" type="email" autocomplete="email" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
             </div>
           </div>
           <div>
             <div class="flex items-center justify-between">
               <label for="password" class="block font-medium leading-6 text-gray-800 md:text-base">Password</label>
               <div class="text-sm">
                 <!-- <router-link :to="{name: 'requestPassword'}" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</router-link> -->
               </div>
             </div>
             <div class="mt-2">
               <input id="password" v-model="user.password" name="password" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
             </div>
           </div>

           <div class="flex space-x-2">
            <input type="checkbox" v-model="user.remember">
            <p class="text-sm">Keep me Signed In</p>
           </div>

           <div>
             <button
             :disabled="loading"
             class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
             :class="{
                 'cursor-not-allowed': loading,
                 'hover: bg-indigo-500': loading
             }"
             type="submit"
              >
              <svg v-if="loading"
                 class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                 <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
             </svg>
              Sign In
             </button>
           </div>
           </form>
         </GuestLayout>
   </template>

 <script setup>
 import {ref} from 'vue';
 import GuestLayout from '../components/GuestLayout.vue';
 import store from '../store';
 import {useRouter} from 'vue-router';

 const router = useRouter();

 let loading = ref(false);
 let errorMsg = ref("");

 const user = {
     email: '',
     password: '',
     remember: false
 }

 function login(){
    loading.value = true
    store.dispatch('login', user)
        .then(()=>{
            loading.value = false
            //console.log(user)
            // email: "admin@example.com"
            // password: "password"
            // remember: true
            router.push({name: 'app.dashboard'})
        })
        .catch(({response})=>{
            loading.value = false
            // console.log(response)
        //     errorMsg.value = response.data.message
        })
 }

 </script>
