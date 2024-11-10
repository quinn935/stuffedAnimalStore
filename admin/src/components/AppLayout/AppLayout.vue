<template>
    <div v-if="currentUser.id" class="min-h-screen bg-gray-200 flex">
        <!-- sidebar -->
        <Sidebar :class="{'-ml-[200px]' : !sidebarOpened}"/>
        <!-- end of sidebar -->
        <div class="flex-1">
            <TopHeader @toggle-sidebar="toggleSidebar"/>
            <!-- content -->
            <main class="p-6">
                <router-view></router-view>
            </main>
            <!-- end of content -->
        </div>
    </div>
    <div v-else  class="h-screen bg-gray-200 flex items-center justify-center">
       <Spinner />
    </div>
    <Toast />
</template>

<script setup>
import {ref, onMounted, onUnmounted, computed} from "vue";
import Sidebar from "./Sidebar.vue";
import Spinner from '../core/Spinner.vue';
// import Toast from './core/Toast.vue';
import TopHeader from "./TopHeader.vue";
import store from '../../store'

const sidebarOpened = ref(true);
const currentUser = computed(()=>store.state.user.data);

function toggleSidebar() {
    sidebarOpened.value = !sidebarOpened.value;
}

onMounted(()=>{
    store.dispatch('getCurrentUser')
    handleSidebarOpened();
    window.addEventListener('resize', handleSidebarOpened);
});

onUnmounted(()=>{
    window.removeEventListener('resize', handleSidebarOpened);
})

function handleSidebarOpened(){
    if(window.outerWidth <=768){
        sidebarOpened.value = false;
    }else{
        sidebarOpened.value = true;
    }
}
</script>

<style lang="">

</style>
