<template>
    <div
        class="min-h-screen flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-950 text-center px-6 relative overflow-hidden transition-colors"
    >
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-purple-500/10 rounded-full blur-[120px] -z-10"
        ></div>

        <h1
            class="text-9xl font-black text-slate-200 dark:text-slate-800 select-none transition-colors"
        >
            404
        </h1>

        <div class="relative -mt-12 z-10">
            <h2
                class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4"
            >
                Page Not Found
            </h2>
            <p class="text-slate-600 dark:text-slate-400 max-w-md mx-auto mb-8">
                Oops! The page you are looking for doesn't exist or has been
                moved.
            </p>

            <router-link
                to="/"
                class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold hover:bg-emerald-600 dark:hover:bg-emerald-400 dark:hover:text-white transition-all shadow-lg hover:shadow-xl active:scale-95"
            >
                <Home class="w-5 h-5" /> Go Back Home
            </router-link>
        </div>
    </div>
</template>

<script setup>
import { Home } from "lucide-vue-next";
</script>
