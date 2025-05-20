<template>
    <section class="py-20 md:py-28 bg-gray-50 relative overflow-hidden">
        <!-- Background decorations -->
        <div class="absolute inset-0 pointer-events-none">
            <div
                class="absolute top-0 right-1/4 w-64 h-64 bg-gradient-to-bl from-purple-100 to-transparent rounded-full opacity-70 -translate-y-1/2 blur-3xl">
            </div>
            <div
                class="absolute bottom-0 left-1/4 w-64 h-64 bg-gradient-to-tr from-blue-100 to-transparent rounded-full opacity-70 translate-y-1/2 blur-3xl">
            </div>
        </div>

        <div class="container mx-auto px-4 relative">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <div class="inline-block mb-4">
                    <div
                        class="flex items-center justify-center space-x-2 px-4 py-1.5 bg-white rounded-full shadow-sm border border-gray-100">
                        <span class="h-2 w-2 rounded-full bg-gradient-to-r from-teal-500 to-emerald-500"></span>
                        <span class="text-sm font-medium text-gray-600">Our Evolution</span>
                    </div>
                </div>

                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Our Journey</h2>
                <p class="text-xl text-gray-700 max-w-2xl mx-auto">
                    From humble beginnings to where we are today, our path has been defined by growth and learning.
                </p>
            </div>

            <div class="max-w-4xl mx-auto relative">
                <!-- Timeline line -->
                <div
                    class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-purple-300 via-blue-300 to-teal-300 rounded-full hidden md:block">
                </div>

                <TimelineItem year="2023" title="The Beginning" color="purple"
                    description="Our blog was founded with a simple mission: to create a space where ideas could flourish and knowledge could be shared freely. Starting with just three writers and a passion for storytelling."
                    position="left" />

                <TimelineItem year="2024" title="Growing Community" color="blue"
                    description="Our readership grew exponentially as we expanded our content categories and brought on specialized writers. We launched our community forum, creating a space for readers to connect and discuss."
                    position="right" />

                <TimelineItem year="2025" title="Today & Beyond" color="teal"
                    description="Today, we're proud to have a diverse team of writers and a global community of readers. We're constantly evolving, exploring new formats, and finding innovative ways to share stories that matter."
                    position="left" isLast="true" />
            </div>
        </div>
    </section>
</template>

<script setup>
import TimelineItem from './TimelineItem.vue';
</script>