<template>
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission & Values</h2>
                <p class="text-gray-700">
                    We're guided by a set of core principles that shape everything we do.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <ValueCard title="Quality Content" icon="pen-tool" color="purple"
                    description="We're committed to creating well-researched, thoughtfully written articles that provide genuine value to our readers." />
                <ValueCard title="Community Focus" icon="users" color="blue"
                    description="We believe in fostering a supportive community where diverse voices are heard and meaningful conversations happen." />
                <ValueCard title="Integrity" icon="check-circle" color="green"
                    description="We're transparent about our processes and committed to ethical practices in all aspects of our work." />
            </div>
        </div>
    </section>
</template>

<script setup>
import ValueCard from './ValueCard.vue';
</script>