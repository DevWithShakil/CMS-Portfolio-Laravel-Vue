import { createApp } from 'vue'
import './style.css' // Tailwind & Global Styles
import App from './App.vue'
import router from './router'

// 1. Toast Notification Import
import Toast, { POSITION } from "vue-toastification";
import "vue-toastification/dist/index.css";

// 2. AOS (Animate On Scroll) Import
import AOS from 'aos';
import 'aos/dist/aos.css';

const app = createApp(App)

// --- Configuration ---

const toastOptions = {
    position: POSITION.BOTTOM_RIGHT,
    timeout: 3000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false
};

AOS.init({
    offset: 100, // offset (in px) from the original trigger point
    delay: 0, // values from 0 to 3000, with step 50ms
    duration: 800, // values from 0 to 3000, with step 50ms
    easing: 'ease-in-out', // default easing for AOS animations
    once: true, // whether animation should happen only once - while scrolling down
    mirror: false, // whether elements should animate out while scrolling past them
});

// --- Use Plugins ---
app.use(router)
app.use(Toast, toastOptions)

// --- Mount App ---
app.mount('#app')
