<template>
    <section class="max-w-7xl mx-auto px-6 py-16">
        <!-- PAGE HEADER -->
        <div class="text-center space-y-3 mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900">Projects</h1>
            <p class="text-gray-600 text-lg">
                A collection of my best work — built with modern web
                technologies.
            </p>
        </div>

        <!-- SEARCH + FILTERS -->
        <div
            class="mb-10 flex flex-col md:flex-row items-center md:items-end justify-between gap-4"
        >
            <!-- Search Box -->
            <div class="w-full md:w-1/3">
                <input
                    type="text"
                    v-model="search"
                    placeholder="Search projects..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                />
            </div>

            <!-- Filter Buttons -->
            <div class="flex flex-wrap gap-3">
                <button
                    v-for="tech in techFilters"
                    :key="tech"
                    @click="activeFilter = tech"
                    class="px-4 py-2 rounded-full border transition cursor-pointer"
                    :class="
                        activeFilter === tech
                            ? 'bg-blue-600 text-white border-blue-600'
                            : 'border-gray-300 text-gray-700 hover:bg-gray-100'
                    "
                >
                    {{ tech }}
                </button>

                <!-- Clear filter -->
                <button
                    v-if="activeFilter"
                    @click="activeFilter = null"
                    class="px-4 py-2 rounded-full border border-red-500 text-red-500 hover:bg-red-50 transition"
                >
                    Clear
                </button>
            </div>
        </div>

        <!-- PROJECT GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <div
                v-for="project in filteredProjects"
                :key="project.id"
                class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden border"
            >
                <!-- Thumbnail -->
                <img
                    :src="project.cover"
                    alt=""
                    class="w-full h-52 object-cover"
                />

                <!-- Body -->
                <div class="p-6 space-y-3">
                    <h3 class="text-xl font-bold text-gray-900">
                        {{ project.title }}
                    </h3>

                    <p class="text-gray-600 text-sm line-clamp-3">
                        {{ project.short }}
                    </p>

                    <!-- Tech Tags -->
                    <div class="flex flex-wrap gap-2">
                        <span
                            v-for="tech in project.tech"
                            :key="tech"
                            class="text-xs bg-gray-100 px-2 py-1 rounded-full text-gray-700"
                        >
                            {{ tech }}
                        </span>
                    </div>

                    <!-- CTA -->
                    <router-link
                        :to="`/projects/${project.slug}`"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow transition"
                    >
                        View Details
                    </router-link>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            search: "",
            activeFilter: null,

            techFilters: [
                "Vue.js",
                "Laravel",
                "React",
                "Firebase",
                "PHP",
                "JS",
            ],

            // Temporary mock data (later API আসবে)
            projects: [
                {
                    id: 1,
                    title: "Task Manager Application",
                    slug: "task-manager",
                    short: "A productivity app to manage tasks with Firebase authentication.",
                    cover: "https://i.imgur.com/1Q9Z1Zm.jpeg",
                    tech: ["Vue.js", "Firebase"],
                },
                {
                    id: 2,
                    title: "Restaurant Booking System",
                    slug: "restaurant-booking",
                    short: "Online restaurant reservation system with admin dashboard.",
                    cover: "https://i.imgur.com/8mN8XiP.jpeg",
                    tech: ["Laravel", "PostgreSQL"],
                },
                {
                    id: 3,
                    title: "News Portal CMS",
                    slug: "news-portal",
                    short: "Dynamic news publishing website built with Vue + Laravel.",
                    cover: "https://i.imgur.com/7K2FH5Z.jpeg",
                    tech: ["Laravel", "Vue.js"],
                },
            ],
        };
    },

    computed: {
        filteredProjects() {
            let p = this.projects;

            if (this.search.trim()) {
                p = p.filter((x) =>
                    x.title.toLowerCase().includes(this.search.toLowerCase())
                );
            }

            if (this.activeFilter) {
                p = p.filter((x) => x.tech.includes(this.activeFilter));
            }

            return p;
        },
    },
};
</script>

<style>
/* for 3-line description clamp */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
