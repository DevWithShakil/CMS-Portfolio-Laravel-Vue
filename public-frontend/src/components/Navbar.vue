<template>
    <nav class="sticky top-0 z-50 bg-white shadow-sm border-b">
        <div
            class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between"
        >
            <!-- Logo -->
            <router-link
                to="/"
                class="text-2xl font-extrabold text-blue-600 tracking-tight"
            >
                MyCMS
            </router-link>

            <!-- Desktop Menu -->
            <ul class="hidden md:flex items-center space-x-8">
                <li v-for="item in menus" :key="item.id">
                    <router-link
                        :to="item.slug"
                        class="relative font-medium text-gray-700 hover:text-blue-600 transition"
                        :class="{
                            'text-blue-600 font-semibold': isActive(item.slug),
                        }"
                    >
                        {{ item.title }}

                        <!-- animated underline -->
                        <span
                            class="absolute left-0 -bottom-1 h-[2px] w-0 bg-blue-600 transition-all duration-300 group-hover:w-full"
                            :class="{ 'w-full': isActive(item.slug) }"
                        ></span>
                    </router-link>
                </li>
            </ul>

            <!-- CTA Button -->
            <button
                class="hidden md:block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition"
            >
                Admin Login
            </button>

            <!-- Mobile Menu Button -->
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
                <router-link
                    v-for="item in menus"
                    :key="item.id"
                    :to="item.slug"
                    @click="open = false"
                    class="block font-medium text-gray-700 hover:text-blue-600 transition"
                    :class="{
                        'text-blue-600 font-semibold': isActive(item.slug),
                    }"
                >
                    {{ item.title }}
                </router-link>

                <router-link
                    to="/admin/login"
                    class="hidden md:block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition"
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
            menus: [
                { id: 1, title: "Home", slug: "/" },
                { id: 2, title: "Projects", slug: "/projects" },
                { id: 3, title: "Blogs", slug: "/blogs" },
                { id: 4, title: "About", slug: "/about" },
                { id: 5, title: "Contact", slug: "/contact" },
            ],
        };
    },
    methods: {
        isActive(slug) {
            return this.$route.path === slug;
        },
    },
};
</script>

<style>
/* Mobile slide-down animation */
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
