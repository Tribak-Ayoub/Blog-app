<template>
    <div class="group">
        <div class="relative mb-6">
            <div class="relative mx-auto w-48 h-48 rounded-2xl overflow-hidden p-1 bg-gradient-to-br"
                :class="getRoleColorClass()">
                <div class="absolute inset-0 bg-white rounded-2xl m-0.5"></div>
                <div class="relative w-full h-full rounded-xl overflow-hidden">
                    <img :src="imageUrl" :alt="name"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                </div>
            </div>

            <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-1">
                <div
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-white shadow-md hover:shadow-lg transition-all text-gray-600 hover:text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775..."></path>
                    </svg>
                </div>
                <div 
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-white shadow-md hover:shadow-lg transition-all text-gray-600 hover:text-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48..."></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ name }}</h3>
            <p class="font-medium mb-3 bg-gradient-to-r bg-clip-text text-transparent" :class="getRoleColorClass()">{{
                role }}</p>
            <p class="text-gray-600 text-sm">{{ bio }}</p>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    name: String,
    role: String,
    roleColor: String,
    bio: String,
    imageUrl: String
});

const getRoleColorClass = () => {
    switch (props.roleColor) {
        case 'purple': return 'from-purple-500 to-indigo-600';
        case 'blue': return 'from-blue-500 to-cyan-600';
        case 'pink': return 'from-pink-500 to-rose-600';
        case 'teal': return 'from-teal-500 to-emerald-600';
        default: return 'from-gray-500 to-gray-600';
    }
};
</script>