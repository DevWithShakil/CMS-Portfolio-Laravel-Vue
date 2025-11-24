import { createRouter, createWebHistory } from "vue-router";

import Home from "@/pages/Home.vue";
import AdminLogin from "@/pages/AdminLogin.vue";

const routes = [
    { path: "/", component: Home },
    // { path: "/admin/login", component: AdminLogin },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
