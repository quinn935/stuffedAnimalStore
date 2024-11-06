import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import AppLayout from "../components/AppLayout/AppLayout.vue";
import NotFound from "../views/NotFound.vue";
import store from "../store";
import Products from "../views/Products/Products.vue";
import ProductForm from "../views/Products/ProductForm.vue";
import Categories from "../views/Categories/Categories.vue";
import CategoryForm from "../views/Categories/CategoryForm.vue";

const routes = [
    {
        path: '/app',
        name: 'app',
        component: AppLayout,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/dashboard',
                name: 'app.dashboard',
                component: Dashboard
            },
            {
                path: '/products',
                name: 'app.products',
                component: Products
            },
            {
                path: '/products/create',
                name: 'app.products.create',
                component: ProductForm
            },
            {
                path: '/products/:slug',
                name: 'app.products.edit',
                component: ProductForm,
                // props: {
                //     //every character of this value should be digit
                //     //id must be numeric for this route
                //     id: (value)=>/^\d+$/.test(value)
                // }
            },
            {
                path: '/categories',
                name: 'app.categories',
                component: Categories
            },
            {
                path: '/categories/create',
                name: 'app.categories.create',
                component: CategoryForm
            },
            {
                path: '/categories/:id',
                name: 'app.categories.edit',
                component: CategoryForm,
                props: {
                    //every character of this value should be digit
                    //id must be numeric for this route
                    id: (value)=>/^\d+$/.test(value)
                }
            },
        ]
    },

    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            requiresGuest: true
        }
    },
    {
        path: '/:pathMatch(.*)',
        name: 'notfound',
        component: NotFound,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next)=>{
    if(to.meta.requireAuth && !store.state.user.token){
        next({name: 'login'})
    }else if(to.meta.requiresGuest && store.state.user.token){
        next({name: 'app.dashboard'})
    }else{
        next();
    }
})

export default router
