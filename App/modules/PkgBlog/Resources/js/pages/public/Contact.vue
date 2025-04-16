<template>
    <div>

        <PublicNavbar @search="handleSearch" :categories="categories" />
        <div class="min-h-screen bg-gradient-to-b from-slate-50 to-slate-100 py-12 px-4 sm:px-6 lg:px-8">

            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-full h-64 overflow-hidden -z-10">
                <div
                    class="absolute -top-10 -left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20">
                </div>
                <div
                    class="absolute top-0 right-0 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20">
                </div>
            </div>

            <div class="max-w-4xl mx-auto relative">
                <!-- Header Section -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-extrabold text-slate-800 tracking-tight sm:text-5xl">
                        Get in Touch
                    </h1>
                    <p class="mt-4 text-xl text-slate-600">
                        Have a question or feedback? We'd love to hear from you.
                    </p>
                </div>

                <!-- Contact Form Card -->
                <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-slate-100 backdrop-blur-sm">
                    <div class="md:flex">
                        <!-- Left Side - Contact Info -->
                        <div
                            class="bg-gradient-to-br from-blue-600 to-purple-700 p-10 text-white md:w-2/5 relative overflow-hidden">
                            <!-- Decorative shapes -->
                            <div
                                class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/2">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-5 rounded-full translate-y-1/2 -translate-x-1/2">
                            </div>

                            <h2 class="text-2xl font-bold mb-8 relative">Contact Information</h2>
                            <div class="space-y-7 relative z-10">
                                <div class="flex items-start group">
                                    <div
                                        class="p-2 bg-white/10 rounded-lg mr-4 flex-shrink-0 group-hover:bg-white/20 transition-all duration-300">
                                        <i class="fa-solid fa-location-dot h-5 w-5 text-center"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Our Location</p>
                                        <p class="text-blue-100 mt-1">123 Blog Street, Content City, 10001</p>
                                    </div>
                                </div>
                                <div class="flex items-start group">
                                    <div
                                        class="p-2 bg-white/10 rounded-lg mr-4 flex-shrink-0 group-hover:bg-white/20 transition-all duration-300">
                                        <i class="fa-solid fa-phone h-5 w-5 text-center"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Phone Number</p>
                                        <p class="text-blue-100 mt-1">+1 (555) 123-4567</p>
                                    </div>
                                </div>
                                <div class="flex items-start group">
                                    <div
                                        class="p-2 bg-white/10 rounded-lg mr-4 flex-shrink-0 group-hover:bg-white/20 transition-all duration-300">
                                        <i class="fa-solid fa-envelope h-5 w-5 text-center"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Email Address</p>
                                        <p class="text-blue-100 mt-1">contact@yourblog.com</p>
                                    </div>
                                </div>
                                <div class="flex items-start group">
                                    <div
                                        class="p-2 bg-white/10 rounded-lg mr-4 flex-shrink-0 group-hover:bg-white/20 transition-all duration-300">
                                        <i class="fa-solid fa-clock h-5 w-5 text-center"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Working Hours</p>
                                        <p class="text-blue-100 mt-1">Mon-Fri: 9AM - 5PM</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-14 relative z-10">
                                <h3 class="text-xl font-semibold mb-5">Connect with us</h3>
                                <div class="flex space-x-4">
                                    <a href="#"
                                        class="p-3 bg-white/10 rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110">
                                        <i class="fa-brands fa-x-twitter h-5 w-5 text-center"></i>
                                    </a>
                                    <a href="#"
                                        class="p-3 bg-white/10 rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110">
                                        <i class="fa-brands fa-instagram h-5 w-5 text-center"></i>
                                    </a>
                                    <a href="#"
                                        class="p-3 bg-white/10 rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110">
                                        <i class="fa-brands fa-facebook h-5 w-5 text-center"></i>

                                    </a>
                                    <a href="#"
                                        class="p-3 bg-white/10 rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110">
                                        <i class="fa-brands fa-linkedin h-5 w-5 text-center"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side - Form -->
                        <div class="p-10 md:w-3/5">
                            <form @submit.prevent="submitForm" class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
                                    <div class="mt-1 relative rounded-md">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-user h-5 w-5 text-slate-400"></i>
                                        </div>
                                        <input type="text" id="name" v-model="form.name"
                                            :class="{ 'border-red-300 ring-red-100': errors.name, 'focus:border-purple-500 focus:ring-purple-200': !errors.name }"
                                            class="pl-10 block w-full rounded-lg border-slate-200 shadow-sm focus:ring-4 transition-all duration-200 sm:text-sm"
                                            placeholder="Your name" />
                                    </div>
                                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                                    <div class="mt-1 relative rounded-md">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-envelope h-5 w-5 text-slate-400"></i>
                                        </div>
                                        <input type="email" id="email" v-model="form.email"
                                            :class="{ 'border-red-300 ring-red-100': errors.email, 'focus:border-purple-500 focus:ring-purple-200': !errors.email }"
                                            class="pl-10 block w-full rounded-lg border-slate-200 shadow-sm focus:ring-4 transition-all duration-200 sm:text-sm"
                                            placeholder="your.email@example.com" />
                                    </div>
                                    <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                                </div>

                                <div>
                                    <label for="subject"
                                        class="block text-sm font-medium text-slate-700">Subject</label>
                                    <div class="mt-1 relative rounded-md">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-tag h-5 w-5 text-slate-400"></i>
                                        </div>
                                        <input type="text" id="subject" v-model="form.subject"
                                            :class="{ 'border-red-300 ring-red-100': errors.subject, 'focus:border-purple-500 focus:ring-purple-200': !errors.subject }"
                                            class="pl-10 block w-full rounded-lg border-slate-200 shadow-sm focus:ring-4 transition-all duration-200 sm:text-sm"
                                            placeholder="What is this regarding?" />
                                    </div>
                                    <p v-if="errors.subject" class="mt-1 text-sm text-red-600">{{ errors.subject }}</p>
                                </div>

                                <div>
                                    <label for="message"
                                        class="block text-sm font-medium text-slate-700">Message</label>
                                    <div class="mt-1">
                                        <textarea id="message" v-model="form.message"
                                            :class="{ 'border-red-300 ring-red-100': errors.message, 'focus:border-purple-500 focus:ring-purple-200': !errors.message }"
                                            rows="5"
                                            class="block w-full rounded-lg border-slate-200 shadow-sm focus:ring-4 transition-all duration-200 sm:text-sm"
                                            placeholder="Your message here..."></textarea>
                                    </div>
                                    <p v-if="errors.message" class="mt-1 text-sm text-red-600">{{ errors.message }}</p>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="newsletter" type="checkbox" v-model="form.newsletter"
                                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-slate-300 rounded" />
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="newsletter" class="font-medium text-slate-700">Subscribe to
                                            newsletter</label>
                                        <p class="text-slate-500">Get the latest updates from our blog.</p>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" :disabled="isSubmitting"
                                        class="inline-flex justify-center py-3 px-8 border border-transparent shadow-md text-base font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                        <span v-if="isSubmitting" class="flex items-center">
                                            <Loader class="animate-spin -ml-1 mr-2 h-4 w-4" />
                                            Sending...
                                        </span>
                                        <span v-else class="flex items-center">
                                            <i class="fa-solid fa-paper-plane -ml-1 mr-2 h-4 w-4"></i>
                                            Send Message
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                <div v-if="showSuccess"
                    class="mt-8 bg-gradient-to-r from-blue-50 to-purple-50 border-l-4 border-purple-400 p-4 rounded-lg shadow-md transform transition-all duration-500 animate-fade-in">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircle class="h-5 w-5 text-purple-500" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-slate-700">
                                Thank you for your message! We'll get back to you soon.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <PublicFooter :categories="categories" />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import PublicNavbar from '../../components/PublicNavbar.vue';
import PublicFooter from '../../components/PublicFooter.vue';

const form = ref({
    name: '',
    email: '',
    subject: '',
    message: '',
    newsletter: false
});

const errors = ref({
    name: '',
    email: '',
    subject: '',
    message: ''
});

const isSubmitting = ref(false);
const showSuccess = ref(false);

const validateForm = () => {
    let isValid = true;

    errors.name = '';
    errors.email = '';
    errors.subject = '';
    errors.message = '';

    if (!form.name.trim()) {
        errors.name = 'Name is required';
        isValid = false;
    }

    if (!form.email.trim()) {
        errors.email = 'Email is required';
        isValid = false;
    } else if (!/^\S+@\S+\.\S+$/.test(form.email)) {
        errors.email = 'Please enter a valid email address';
        isValid = false;
    }

    if (!form.subject.trim()) {
        errors.subject = 'Subject is required';
        isValid = false;
    }

    if (!form.message.trim()) {
        errors.message = 'Message is required';
        isValid = false;
    } else if (form.message.trim().length < 10) {
        errors.message = 'Message must be at least 10 characters';
        isValid = false;
    }

    return isValid;
};

const submitForm = () => {
    if (!validateForm()) return;

    isSubmitting.value = true;

    setTimeout(() => {
        isSubmitting.value = false;
        showSuccess.value = true;

        // Reset form
        form.name = '';
        form.email = '';
        form.subject = '';
        form.message = '';
        form.newsletter = false;

        setTimeout(() => {
            showSuccess.value = false;
        }, 5000);
    }, 2000);
};
</script>

<style>
/* Custom animations */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.5s ease-out forwards;
}

/* Input focus styles */
input:focus,
textarea:focus {
    outline: none;
}

/* Smooth transitions */
input,
textarea,
button {
    transition: all 0.3s ease;
}
</style>