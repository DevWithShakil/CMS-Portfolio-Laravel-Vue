<template>
    <div
        class="min-h-screen pt-32 pb-20 bg-slate-950 relative selection:bg-emerald-500/30 overflow-hidden font-sans"
    >
        <div
            class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"
        ></div>
        <div
            class="absolute top-0 left-0 w-full h-full bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"
        ></div>

        <div
            class="absolute top-20 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-emerald-500/10 rounded-full blur-[120px] -z-10"
        ></div>

        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16" data-aos="fade-down">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-slate-800 bg-slate-900/50 backdrop-blur-md text-slate-300 text-xs font-bold uppercase tracking-widest mb-6"
                >
                    <span
                        class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"
                    ></span>
                    Open for Opportunities
                </div>
                <h1
                    class="text-5xl md:text-7xl font-black text-white tracking-tight leading-tight"
                >
                    Have an
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400"
                        >Idea?</span
                    ><br />
                    Let's build it.
                </h1>
                <p class="text-lg text-slate-400 mt-6 max-w-2xl mx-auto">
                    Whether you have a question, a project proposal, or just
                    want to say hello, my inbox is always open.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-7" data-aos="fade-right">
                    <div
                        class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 md:p-10 shadow-2xl h-full"
                    >
                        <h3
                            class="text-2xl font-bold text-white mb-8 flex items-center gap-3"
                        >
                            <Send class="w-6 h-6 text-emerald-500" /> Send a
                            Message
                        </h3>

                        <form @submit.prevent="sendMessage" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1"
                                        >Name</label
                                    >
                                    <input
                                        v-model="contactForm.name"
                                        type="text"
                                        placeholder="John Doe"
                                        class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-5 py-4 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all placeholder:text-slate-600"
                                        required
                                    />
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1"
                                        >Email</label
                                    >
                                    <input
                                        v-model="contactForm.email"
                                        type="email"
                                        placeholder="john@example.com"
                                        class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-5 py-4 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all placeholder:text-slate-600"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1"
                                    >Subject</label
                                >
                                <input
                                    v-model="contactForm.subject"
                                    type="text"
                                    placeholder="Project Proposal"
                                    class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-5 py-4 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all placeholder:text-slate-600"
                                    required
                                />
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1"
                                    >Message</label
                                >
                                <textarea
                                    v-model="contactForm.message"
                                    rows="5"
                                    placeholder="Tell me about your project details..."
                                    class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-5 py-4 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all placeholder:text-slate-600 resize-none custom-scrollbar"
                                    required
                                ></textarea>
                            </div>

                            <button
                                type="submit"
                                class="w-full py-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-lg shadow-lg shadow-emerald-900/20 transition-all active:scale-95 flex justify-center items-center gap-2 group"
                                :disabled="isSending"
                            >
                                <span v-if="isSending" class="animate-spin"
                                    >⌛</span
                                >
                                <span v-else>Send Message</span>
                                <ArrowRight
                                    v-if="!isSending"
                                    class="w-5 h-5 group-hover:translate-x-1 transition-transform"
                                />
                            </button>
                        </form>
                    </div>
                </div>

                <div
                    class="lg:col-span-5 space-y-6"
                    data-aos="fade-left"
                    data-aos-delay="100"
                >
                    <a
                        :href="`mailto:${adminEmail}`"
                        class="group relative block bg-slate-900 border border-slate-800 hover:border-blue-500/50 p-6 rounded-3xl shadow-lg hover:shadow-blue-500/10 transition-all duration-300 overflow-hidden"
                    >
                        <Mail
                            class="absolute -right-6 -bottom-6 w-32 h-32 text-slate-800/50 group-hover:text-blue-500/10 transition-colors transform rotate-12"
                        />

                        <div class="relative z-10 flex items-center gap-5">
                            <div
                                class="w-16 h-16 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform shrink-0"
                            >
                                <Mail class="w-7 h-7" />
                            </div>
                            <div class="min-w-0">
                                <p
                                    class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1"
                                >
                                    Email Me Directly
                                </p>
                                <h3
                                    class="text-lg font-bold text-white truncate group-hover:text-blue-400 transition-colors"
                                >
                                    {{ adminEmail }}
                                </h3>
                                <span
                                    class="text-xs text-blue-500/80 mt-1 inline-block font-medium"
                                    >Click to send mail &rarr;</span
                                >
                            </div>
                        </div>
                    </a>

                    <div
                        class="group relative bg-slate-900 border border-slate-800 hover:border-emerald-500/50 p-6 rounded-3xl shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 overflow-hidden"
                    >
                        <MapPin
                            class="absolute -right-6 -bottom-6 w-32 h-32 text-slate-800/50 group-hover:text-emerald-500/10 transition-colors transform -rotate-12"
                        />

                        <div class="relative z-10 flex items-center gap-5">
                            <div
                                class="w-16 h-16 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform shrink-0"
                            >
                                <MapPin class="w-7 h-7" />
                            </div>
                            <div>
                                <p
                                    class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1"
                                >
                                    My Location
                                </p>
                                <h3
                                    class="text-lg font-bold text-white group-hover:text-emerald-400 transition-colors"
                                >
                                    Dhaka, Bangladesh
                                </h3>
                                <span
                                    class="text-xs text-slate-500 mt-1 inline-block"
                                    >Open for remote work</span
                                >
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <a
                            v-if="settings.github"
                            :href="settings.github"
                            target="_blank"
                            class="bg-slate-900 border border-slate-800 p-5 rounded-2xl flex flex-col items-center justify-center gap-3 text-slate-400 hover:text-white hover:bg-slate-800 hover:border-slate-600 transition-all group h-32"
                        >
                            <Github
                                class="w-8 h-8 group-hover:scale-110 transition-transform"
                            />
                            <span class="font-medium text-sm">GitHub</span>
                        </a>
                        <a
                            v-if="settings.linkedin"
                            :href="settings.linkedin"
                            target="_blank"
                            class="bg-slate-900 border border-slate-800 p-5 rounded-2xl flex flex-col items-center justify-center gap-3 text-slate-400 hover:text-blue-400 hover:bg-slate-800 hover:border-blue-900 transition-all group h-32"
                        >
                            <Linkedin
                                class="w-8 h-8 group-hover:scale-110 transition-transform"
                            />
                            <span class="font-medium text-sm">LinkedIn</span>
                        </a>
                        <a
                            v-if="settings.facebook"
                            :href="settings.facebook"
                            target="_blank"
                            class="bg-slate-900 border border-slate-800 p-5 rounded-2xl flex flex-col items-center justify-center gap-3 text-slate-400 hover:text-blue-500 hover:bg-slate-800 hover:border-blue-900 transition-all group h-32"
                        >
                            <Facebook
                                class="w-8 h-8 group-hover:scale-110 transition-transform"
                            />
                            <span class="font-medium text-sm">Facebook</span>
                        </a>
                        <a
                            v-if="settings.youtube"
                            :href="settings.youtube"
                            target="_blank"
                            class="bg-slate-900 border border-slate-800 p-5 rounded-2xl flex flex-col items-center justify-center gap-3 text-slate-400 hover:text-red-500 hover:bg-slate-800 hover:border-red-900 transition-all group h-32"
                        >
                            <Youtube
                                class="w-8 h-8 group-hover:scale-110 transition-transform"
                            />
                            <span class="font-medium text-sm">YouTube</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";
import { useToast } from "vue-toastification";
import {
    Mail,
    MapPin,
    Github,
    Linkedin,
    Facebook,
    Youtube,
    Send,
    ArrowRight,
} from "lucide-vue-next";

const toast = useToast();
const isSending = ref(false);
const settings = ref({});
const contactForm = ref({ name: "", email: "", subject: "", message: "" });

// আপনার স্ক্রিনশট অনুযায়ী ইমেইলটি এখানে দিলাম
const adminEmail = ref("mdshakil.khan8032@gmail.com");

const loadSettings = async () => {
    try {
        const res = await api.get("/api/settings");
        const data = Array.isArray(res.data)
            ? res.data[0]
            : res.data.data || res.data;
        if (data) settings.value = data;
    } catch (e) {}
};

const sendMessage = async () => {
    isSending.value = true;
    try {
        await api.post("/api/contacts", contactForm.value);
        toast.success("Message sent successfully!");
        contactForm.value = { name: "", email: "", subject: "", message: "" };
    } catch (e) {
        toast.error("Failed to send message. Try again.");
    } finally {
        isSending.value = false;
    }
};

onMounted(() => {
    loadSettings();
    window.scrollTo(0, 0);
});
</script>
