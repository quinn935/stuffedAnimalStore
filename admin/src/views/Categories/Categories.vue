<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Categories</h1>
        <router-link :to="{name: 'app.categories.create'}"
            class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600">
            Add New Categories
         </router-link>
    </div>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
            <div class="flex items-center">
                <span class="mb-3">Found {{ categories.data.length }} categories</span>
            </div>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <TableHeadingCell @click="sortCategories" class="border-b-2 p-2 text-left" field="id" :sortField="sortField" :sortDirection="sortDirection" >ID</TableHeadingCell>
                        <TableHeadingCell @click="sortCategories" class="border-b-2 p-2 text-left" field="name" :sortField="sortField" :sortDirection="sortDirection">Name</TableHeadingCell>
                        <TableHeadingCell @click="sortCategories" class="border-b-2 p-2 text-left" field="slug" :sortField="sortField" :sortDirection="sortDirection">Slug</TableHeadingCell>
                        <TableHeadingCell @click="sortCategories" class="border-b-2 p-2 text-left" field="active" :sortField="sortField" :sortDirection="sortDirection">Active</TableHeadingCell>
                        <TableHeadingCell @click="sortCategories" class="border-b-2 p-2 text-left" field="parent_id" :sortField="sortField" :sortDirection="sortDirection">Parent</TableHeadingCell>
                        <TableHeadingCell @click="sortCategories" class="border-b-2 p-2 text-left" field="created_at" :sortField="sortField" :sortDirection="sortDirection">Created At</TableHeadingCell>
                        <TableHeadingCell field="actions">Actions</TableHeadingCell>
                    </tr>
                </thead>
                <tbody v-if="categories.loading">
                     <Spinner class="my-4" v-if="categories.loading" text="loading categories..."/>
                </tbody>
                <tbody v-else-if="categories.data.length == 0">
                    <tr>
                        <td colspan="7" class="h-20 text-center">
                            <h2>There are no categories</h2>
                        </td>
                    </tr>
                </tbody>

                <tbody v-else >
                    <tr v-for="category of categories.data">
                        <td class="border-b p-2">{{ category.id }}</td>
                        <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipse">
                            {{ category.name}}
                        </td>
                        <td class="border-b p-2">
                            {{ category.slug }}
                        </td>
                        <td class="border-b p-2">
                            {{ category.active? 'Yes' : 'No'}}
                        </td>
                        <td class="border-b p-2">
                            {{ category.parent?.name}}
                        </td>
                        <td class="border-b p-2">
                            {{ category.created_at}}
                        </td>
                        <td class="border-b p-2">
                            <Menu as="div" class="relative inline-block text-left">
                                <div>
                                    <MenuButton
                                        class="inline-flex items-center justify-center w-full justify-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                    >
                                    <EllipsisVerticalIcon
                                        class="h-5 w-5 text-indigo-500"
                                        aria-hidden="true"/>

                                    </MenuButton>
                                 </div>
                                 <transition
                                    enter-active-class="transition duration-100 ease-out"
                                    enter-from-class="transform scale-95 opacity-0"
                                    enter-to-class="transform scale-100 opacity-100"
                                    leave-active-class="transition duration-75 ease-in"
                                    leave-from-class="transform scale-100 opacity-100"
                                    leave-to-class="transform scale-95 opacity-0"
                                    >
                                    <MenuItems
                                     class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    >
                                        <div class="px-1 py-1">
                                            <MenuItem v-slot="{active}">
                                                 <router-link
                                                    :to="{name: 'app.categories.edit', params: {id:category.id}}"
                                                    :class="[
                                                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                    ]"
                                                    >
                                                    <PencilIcon
                                                        :active="active"
                                                        class="mr-2 h-5 w-5 text-indigo-400"
                                                        aria-hidden="true"
                                                    />
                                                     Edit
                                                 </router-link>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }">
                                                <button
                                                :class="[
                                                    active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                ]"
                                                @click="deleteCategory(category)"
                                                >
                                                <TrashIcon
                                                    :active="active"
                                                    class="mr-2 h-5 w-5 text-indigo-400"
                                                    aria-hidden="true"
                                                />
                                                Delete
                                                </button>
                                            </MenuItem>
                                        </div>
                                    </MenuItems>
                                </transition>
                             </Menu>
                        </td>
                    </tr>
                </tbody>
            </table>

    </div>
 </template>

 <script setup>
 import {ref, computed, onMounted} from 'vue'
 import Spinner from "../../components/core/Spinner.vue"
 import store from "../../store/index.js"
 import TableHeadingCell from '../../components/core/TableHeadingCell.vue'
 import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
 import { EllipsisVerticalIcon, PencilIcon, TrashIcon } from '@heroicons/vue/20/solid'

 const categories = computed(()=>store.state.categories)
 const sortField = ref('updated_at')
 const sortDirection = ref('desc')


 onMounted(()=>{
    getCategories()
 })

 function getCategories(){
    store.dispatch('getCategories', {
        sort_field: sortField.value,
        sort_direction: sortDirection.value,
    })
 }

 function sortCategories(field){
    if(sortField.value == field){
        if(sortDirection.value == 'asc'){
            sortDirection.value = 'desc'
        }else{
            sortDirection.value = 'asc'
        }
    }else{
        sortField.value = field;
        sortDirection.value = 'asc'
    }

    getCategories()
 }


 function deleteCategory(category){
    if(!confirm(`Are you sure you want to delete category '${category.name}'`)){
        return
    }
    store.dispatch('deleteCategory', category)
        .then(res=>{
            store.dispatch('getCategories')
        })
 }



</script>
