<template>
    <div class="flex flex-col md:flex-row items-center mb-16"
        :class="[getPositionClasses().container, { 'mb-0': isLast }]">
        <!-- Year marker -->
        <div class="md:w-1/2 relative">
            <div class="relative z-10 md:absolute md:top-0" :class="getPositionClasses().dot">
                <div
                    :class="['w-12 h-12 rounded-full shadow-lg flex items-center justify-center text-white font-bold', getYearColorClass()]">
                    {{ year }}
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="md:w-1/2 mt-4 md:mt-0 flex flex-col" :class="getPositionClasses().content">
            <div
                class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 max-w-md transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ title }}</h3>
                <p class="text-gray-700">
                    {{ description }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    year: String,
    title: String,
    color: String,
    description: String,
    position: {
        type: String,
        default: 'left'
    },
    isLast: {
        type: Boolean,
        default: false
    }
});

const getYearColorClass = () => {
    switch (props.color) {
        case 'purple': return 'bg-gradient-to-r from-purple-500 to-indigo-600';
        case 'blue': return 'bg-gradient-to-r from-blue-500 to-cyan-600';
        case 'teal': return 'bg-gradient-to-r from-teal-500 to-emerald-600';
        default: return 'bg-gradient-to-r from-gray-500 to-gray-600';
    }
};

const getPositionClasses = () => {
    if (props.position === 'right') {
        return {
            container: 'md:flex-row-reverse',
            dot: 'md:left-0 md:-translate-x-1/2',
            content: 'md:items-start'
        };
    }
    return {
        container: 'md:flex-row',
        dot: 'md:right-0 md:translate-x-1/2',
        content: 'md:items-end'
    };
};
</script>