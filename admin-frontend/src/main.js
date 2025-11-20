import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const app = createApp(App);

// First use router
app.use(router);

// Then use toast
app.use(Toast, {
    position: "top-right",
    timeout: 2500,
});

// Finally mount
app.mount('#app');
