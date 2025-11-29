import { createRouter, createWebHistory } from 'vue-router'

// Layouts
import FrontendLayout from '../components/layouts/FrontendLayout.vue'

// Pages
import Home from '../pages/Home.vue'

const routes = [
    {
        path: '/',
        component: FrontendLayout,
        children: [
            {
                path: '',
                name: 'Home',
                component: Home,
                meta: { title: 'Home' }
            },

        ]
    },

    // 404 Route
    { path: '/:pathMatch(.*)*', redirect: '/' }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title ? `${to.meta.title} | Shakil Portfolio` : 'Shakil Portfolio';
    next();
});

export default router;
