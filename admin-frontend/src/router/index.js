import { createRouter, createWebHistory } from 'vue-router'
import Login from '../pages/Login.vue'
import Dashboard from '../pages/Dashboard.vue'
import Projects from '../pages/Projects.vue'
import Skills from '../pages/Skills.vue'
import Experience from '../pages/Experience.vue'
import Education from '../pages/Education.vue'
import Contacts from '../pages/Contacts.vue'

const routes = [
    { path: '/', name: 'login', component: Login },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true }
    },
    {
        path: '/projects',
        name: 'projects',
        component: Projects,
        meta: { requiresAuth: true }
    },

    {
        path: "/skills",
        name: "skills",
        component: Skills,
        meta: { requiresAuth: true }
    },

    {
        path: "/experience",
        name: "experience",
        component: Experience,
        meta: { requiresAuth: true }
    },
    {
        path: "/education",
        name: "education",
        component: Education,
        meta: { requiresAuth: true }
    },
    {
        path: "/contacts",
        name: "contacts",
        component: Contacts,
        meta: { requiresAuth: true }
    },

]



const router = createRouter({
    history: createWebHistory(),
    routes
})

// Navigation Guard
router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem("token")

    if (to.meta.requiresAuth && !loggedIn) {
        next('/')
    } else {
        next()
    }
})

export default router
