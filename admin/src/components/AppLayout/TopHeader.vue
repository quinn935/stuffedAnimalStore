<template>
    <header class="h-14 p-3 shadow bg-white flex justify-between md:justify-end items-center">
        <!-- toggler button -->
        <button @click="emit('toggle-sidebar')"
        class="flex md:hidden items-center justify-center rounded hover:bg-black/10 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <!-- end of toggler button -->
            <Menu as="div" class="relative inline-block text-left">
                    <MenuButton class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/73.jpg" alt="" class="rounded-full w-8 mr-2">
                        <small>{{ currentUser.name }}</small>
                        <ChevronDownIcon class="h-5 w-5 text-indigo-200 hover:text-indigo-100" aria-hidden="true" />
                    </MenuButton>

                <transition enter-active-class="transition duration-100 ease-out"
                    enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
                    <MenuItems
                        class="absolute right-0 mt-2 w-36 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                        <div class="px-1 py-1">
                            <MenuItem v-slot="{ active }">
                            <button :class="[
                                active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                            ]">
                                <UserIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400" aria-hidden="true" />
                                Profile
                            </button>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                            <button @click="logout"
                                :class="[
                                active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                            ]">
                                <ArrowLeftStartOnRectangleIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400"
                                    aria-hidden="true" />
                                Logout
                            </button>
                            </MenuItem>
                        </div>
                    </MenuItems>
                </transition>
            </Menu>
    </header>
</template>

<script setup>
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { ChevronDownIcon, UserIcon, ArrowLeftStartOnRectangleIcon} from '@heroicons/vue/20/solid'
import {useRouter} from 'vue-router';
import store from '../../store';
import {computed} from 'vue';

const router = useRouter();

const emit = defineEmits(['toggle-sidebar'])
const currentUser = computed(()=>store.state.user.data);

function logout(){
    store.dispatch('logout')
    .then(()=>{
        router.push({name: 'login'});
    })
}
</script>

<style scoped>
a.router-link-active {
    color: white;
}
</style>
