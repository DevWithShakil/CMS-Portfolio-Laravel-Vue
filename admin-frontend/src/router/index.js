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
import Profile from '../pages/Profile.vue'

const routes = [
    /**
     * Public Routes
     */
    {
        path: '/',
        name: 'login',
        component: Login,
        meta: { title: 'Login' }
    },

    /**
     * Admin Protected Routes
     */
    {
        path: '/admin',
        component: AdminLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: 'dashboard',
                name: 'dashboard',
                component: Dashboard,
                meta: { title: 'Dashboard' }
            },
            {
                path: 'projects',
                name: 'projects',
                component: Projects,
                meta: { title: 'Projects' }
            },
            {
                path: 'skills',
                name: 'skills',
                component: Skills,
                meta: { title: 'Skills' }
            },
            {
                path: 'experience',
                name: 'experience',
                component: Experience,
                meta: { title: 'Experience' }
            },
            {
                path: 'education',
                name: 'education',
                component: Education,
                meta: { title: 'Education' }
            },
            {
                path: 'contacts',
                name: 'contacts',
                component: Contacts,
                meta: { title: 'Inbox' }
            },
            {
                path: 'settings',
                name: 'settings',
                component: Settings,
                meta: { title: 'Settings' }
            },
            {
                path: 'blogs',
                name: 'blogs',
                component: Blogs,
                meta: { title: 'Blogs' }
            },
            {
                path: 'profile',
                name: 'profile',
                component: Profile,
                meta: { title: 'My Profile' }
            },
        ]
    },

    // 404 Route
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

// --- Navigation Guard & Title Update ---
router.beforeEach((to, from, next) => {
    const defaultTitle = 'Admin Panel';
    document.title = to.meta.title ? `${to.meta.title} | ${defaultTitle}` : defaultTitle;

    // 2. Auth Logic
    const loggedIn = localStorage.getItem("token")

    if (to.meta.requiresAuth && !loggedIn) {
        next('/')
    } else if (to.path === '/' && loggedIn) {
        next('/admin/dashboard')
    } else {
        next()
    }
})

export default router
