<template>
    <section class="bg-gradient-to-br from-gray-50 to-gray-100 py-20">
        <div
            class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-10 items-center"
        >
            <!-- LEFT CONTENT -->
            <div class="space-y-6">
                <h1
                    class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight"
                >
                    Manage Your Website Content
                    <span class="text-blue-600">Smarter & Faster</span>
                </h1>

                <p class="text-gray-600 text-lg leading-relaxed">
                    A powerful and modern CMS system crafted with Laravel +
                    Vue.js. Create, update & publish content with ease — all
                    from one dashboard.
                </p>

                <div class="flex space-x-4">
                    <router-link
                        to="/blogs"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow transition font-medium"
                    >
                        Explore Blogs
                    </router-link>

                    <router-link
                        to="/about"
                        class="border border-gray-300 hover:border-blue-500 hover:text-blue-500 px-6 py-3 rounded-lg transition font-medium"
                    >
                        Learn More
                    </router-link>
                </div>
            </div>

            <!-- RIGHT BANNER / ILLUSTRATION -->
            <div class="flex justify-center md:justify-end">
                <img
                    :src="profileImg"
                    alt="Hero Image"
                    class="w-80 md:w-96 drop-shadow-xl rounded-full"
                />
            </div>
        </div>
    </section>
</template>

<script>
import ShakilProfile from "@/assets/profile/shakil_profile.png";

export default {
    data() {
        return {
            profileImg: ShakilProfile,
        };
    },

    mounted() {
        const hero = document.querySelector(".hero-animate");
        hero.classList.add("opacity-100", "translate-y-0");
    },
};
</script>

<style scoped></style>
