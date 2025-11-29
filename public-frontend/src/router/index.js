import { createRouter, createWebHistory } from 'vue-router'

// Layouts
import FrontendLayout from '../components/layouts/FrontendLayout.vue'

// Pages
import Home from '../pages/Home.vue'
import Portfolio from '../pages/Portfolio.vue'
import Blog from '../pages/Blog.vue'
import BlogDetails from '../pages/BlogDetails.vue'
import About from '../pages/About.vue'

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

            {
                path: 'portfolio',
                name: 'portfolio',
                component: Portfolio,
                meta: { title: 'Portfolio' }
            },

            {
                path: 'blog',
                name: 'blog',
                component: Blog,
                meta: { title: 'Blog' }
            },

            {
                path: 'blog/:slug',
                name: 'blog-details',
                component: BlogDetails,
                meta: { title: 'Article' }
            },

            {
                path: 'about',
                name: 'about',
                component: About,
                meta: { title: 'About Me' }
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
