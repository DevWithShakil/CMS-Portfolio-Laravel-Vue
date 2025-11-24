<template>
    <nav class="sticky top-0 z-50 bg-white shadow-sm border-b">
        <div
            class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between"
        >
            <!-- Logo -->
            <a
                href="#home"
                class="text-2xl font-extrabold text-blue-600 tracking-tight"
            >
                MyCMS
            </a>

            <!-- Desktop Menu -->
            <ul class="hidden md:flex items-center space-x-8">
                <li v-for="item in menus" :key="item.id">
                    <a
                        :href="item.slug"
                        class="relative font-medium text-gray-700 hover:text-blue-600 transition group"
                        :class="{
                            'text-blue-600 font-semibold':
                                activeSection === item.slug,
                        }"
                        @click="setActive(item.slug)"
                    >
                        {{ item.title }}

                        <!-- underline effect -->
                        <span
                            class="absolute left-0 -bottom-1 h-[2px] w-0 bg-blue-600 transition-all duration-300 group-hover:w-full"
                            :class="{ 'w-full': activeSection === item.slug }"
                        ></span>
                    </a>
                </li>
            </ul>

            <!-- Admin Login -->
            <router-link
                to="/admin/login"
                class="hidden md:block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition"
            >
                Admin Login
            </router-link>

            <!-- Mobile Menu Toggle -->
            <button @click="open = !open" class="md:hidden focus:outline-none">
                <svg
                    class="w-7 h-7 text-gray-700"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
            </button>
        </div>

        <!-- Mobile Dropdown -->
        <transition name="slide">
            <div
                v-if="open"
                class="md:hidden bg-white shadow-inner border-t px-6 py-4 space-y-3"
            >
                <a
                    v-for="item in menus"
                    :key="item.id"
                    :href="item.slug"
                    @click="open = false"
                    class="block font-medium text-gray-700 hover:text-blue-600 transition"
                >
                    {{ item.title }}
                </a>

                <router-link
                    to="/admin/login"
                    class="block bg-blue-600 text-center text-white py-2 rounded-lg shadow transition"
                    @click="open = false"
                >
                    Admin Login
                </router-link>
            </div>
        </transition>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            open: false,
            activeSection: "#home",

            menus: [
                { id: 1, title: "Home", slug: "#home" },
                { id: 2, title: "About", slug: "#about" },
                { id: 3, title: "Projects", slug: "#projects" },
                { id: 4, title: "Blogs", slug: "#blogs" },
                { id: 5, title: "Contact", slug: "#contact" },
            ],
        };
    },

    methods: {
        setActive(slug) {
            this.activeSection = slug;
        },
    },
};
</script>

<style>
html {
    scroll-behavior: smooth;
}

/* Mobile slide animation */
.slide-enter-active,
.slide-leave-active {
    transition: all 0.25s ease;
}
.slide-enter-from,
.slide-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
