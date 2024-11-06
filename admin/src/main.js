import { createApp } from 'vue'
import store from './store'
import './style.css'
import App from './App.vue'
import router from './router'

const app = createApp(App)
app.use(store)
    .use(router)
   .mount('#app')
