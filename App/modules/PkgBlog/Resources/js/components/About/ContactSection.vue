<template>
    <section class="py-16 md:py-24 bg-gradient-to-br from-purple-600 to-blue-700 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-6">Join Our Community</h2>
                <p class="text-xl opacity-90 mb-8">
                    Be part of our growing community of readers and contributors. Subscribe to our newsletter to stay
                    updated with our latest articles and announcements.
                </p>

                <div class="max-w-md mx-auto">
                    <form class="flex flex-col sm:flex-row gap-3" @submit.prevent="handleSubscribe">
                        <input v-model="email" type="email" placeholder="Enter your email"
                            class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white"
                            required />
                        <button type="submit"
                            class="px-6 py-3 bg-white text-purple-700 font-medium rounded-lg hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-purple-600">
                            Subscribe
                        </button>
                    </form>
                    <p class="text-sm opacity-80 mt-3">
                        We respect your privacy. Unsubscribe at any time.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, defineComponent } from 'vue';

const email = ref('');

const handleSubscribe = () => {
    // Here you would implement your newsletter subscription logic
    alert(`Thank you for subscribing with: ${email.value}`);
    email.value = '';
};

</script>