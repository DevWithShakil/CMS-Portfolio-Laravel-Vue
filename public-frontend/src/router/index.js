import { createRouter, createWebHistory } from 'vue-router'

// Layouts
import FrontendLayout from '../components/layouts/FrontendLayout.vue'

// Pages
import Home from '../pages/Home.vue'
import Blog from '../pages/Blog.vue'
import BlogDetails from '../pages/BlogDetails.vue'
import About from '../pages/About.vue'
import Contact from '../pages/Contact.vue'
import Projects from '../pages/Projects.vue'
import NotFound from '../pages/NotFound.vue'

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
                path: 'projects',
                name: 'projects',
                component: Projects,
                meta: { title: 'Projects' }
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

            {
                path: 'contact',
                name: 'contact',
                component: Contact,
                meta: { title: 'Contact' }
            },

            {
                path: '/:pathMatch(.*)*',
                name: 'NotFound',
                component: NotFound,
                meta: { title: '404 Not Found' }
            }

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
