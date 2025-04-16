<template>
    <div class="min-h-screen">
        <PublicNavbar />
        <HeroSection />
        <StorySection />
        <MissionValuesSection />
        <TeamSection />
        <TimelineSection />
        <ContactCTASection />
        <PublicFooter />
    </div>
</template>

<script setup>
import PublicNavbar from '../../components/PublicNavbar.vue';
import HeroSection from '../../components/About/HeroSection.vue';
import StorySection from '../../components/About/StorySection.vue';
import MissionValuesSection from '../../components/About/MissionValuesSection.vue';
import TeamSection from '../../components/About/TeamSection.vue';
import TimelineSection from '../../components/About/TimelineSection.vue';
import ContactCTASection from '../../components/About/ContactSection.vue';
import PublicFooter from '../../components/PublicFooter.vue';
</script>