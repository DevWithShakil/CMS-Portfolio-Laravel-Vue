<template>
    <div>
        <HeroSection />
        <SkillsSection />
        <ExperienceSection />
        <EducationSection />
        <ProjectsSection />
        <BlogsSection />
        <ContactSection />
    </div>
</template>

<script>
import HeroSection from "@/components/HeroSection.vue";
import SkillsSection from "@/components/SkillsSection.vue";
import ExperienceSection from "@/components/ExperienceSection.vue";
import EducationSection from "@/components/EducationSection.vue";
import ProjectsSection from "@/components/ProjectsSection.vue";
import BlogsSection from "@/components/BlogsSection.vue";
import ContactSection from "@/components/ContactSection.vue";

export default {
    components: {
        HeroSection,
        SkillsSection,
        ExperienceSection,
        EducationSection,
        ProjectsSection,
        BlogsSection,
        ContactSection,
    },
};
</script>
