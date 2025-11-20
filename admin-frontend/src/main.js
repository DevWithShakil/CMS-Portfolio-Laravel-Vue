import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";


createApp(App).use(router, Toast, {
    position: "top-right",
    timeout: 2500,
}).mount('#app');
