import { createRouter, createWebHistory } from 'vue-router'

// Import Layouts
import AdminLayout from '@/components/layouts/AdminLayout.vue'

// Import Pages
import Login from '../pages/Login.vue'
import Dashboard from '../pages/Dashboard.vue'
import Projects from '../pages/Projects.vue'
import Skills from '../pages/Skills.vue'
import Experience from '../pages/Experience.vue'
import Education from '../pages/Education.vue'
import Contacts from '../pages/Contacts.vue'
import Settings from '../pages/Settings.vue'
import Blogs from '../pages/Blogs.vue'
import Profile from '../pages/Profile.vue';

const routes = [
    /**
     * Public Routes
     */
    {
        path: '/',
        name: 'login',
        component: Login
    },

    /**
     * Admin Protected Routes
     * All children will use the AdminLayout (Sidebar + Topbar)
     */
    {
        path: '/admin',
        component: AdminLayout,
        meta: { requiresAuth: true },
        children: [
            { path: 'dashboard', name: 'dashboard', component: Dashboard },
            { path: 'projects', name: 'projects', component: Projects },
            { path: 'skills', name: 'skills', component: Skills },
            { path: 'experience', name: 'experience', component: Experience },
            { path: 'education', name: 'education', component: Education },
            { path: 'contacts', name: 'contacts', component: Contacts },
            { path: 'settings', name: 'settings', component: Settings },
            { path: 'blogs', name: 'blogs', component: Blogs },
            { path: 'profile', name: 'profile', component: Profile },
        ]
    },

    /**
     * Catch-all route for 404 (Optional)
     * Redirect unknown paths to login or dashboard
     */
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

// Navigation Guard
router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem("token")

    if (to.meta.requiresAuth && !loggedIn) {
        // If route requires auth and user is NOT logged in -> Redirect to Login
        next('/')
    } else if (to.path === '/' && loggedIn) {
        // If user is ALREADY logged in and tries to visit Login -> Redirect to Dashboard
        next('/admin/dashboard')
    } else {
        // Proceed as normal
        next()
    }
})

export default router
