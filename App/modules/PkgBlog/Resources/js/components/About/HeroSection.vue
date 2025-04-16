<template>
    <section class="relative py-24 md:py-32 overflow-hidden bg-gradient-to-b from-white to-gray-50">
        <!-- Decorative elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-24 -right-24 w-96 h-96 bg-gradient-to-br from-purple-200/30 to-pink-200/30 rounded-full blur-3xl">
            </div>
            <div
                class="absolute -bottom-24 -left-24 w-96 h-96 bg-gradient-to-tr from-blue-200/30 to-teal-200/30 rounded-full blur-3xl">
            </div>

            <!-- Geometric shapes -->
            <div class="absolute top-1/4 left-10 w-12 h-12 border-4 border-purple-200 rounded-lg rotate-12 opacity-50">
            </div>
            <div class="absolute bottom-1/4 right-10 w-16 h-16 border-4 border-blue-200 rounded-full opacity-50"></div>
            <div class="absolute top-1/3 right-1/4 w-8 h-8 bg-pink-200 rounded-full opacity-30"></div>
            <div class="absolute bottom-1/3 left-1/4 w-10 h-10 bg-teal-200 rounded-lg rotate-45 opacity-30"></div>
        </div>

        <div class="container mx-auto px-4 relative">
            <div class="max-w-3xl mx-auto text-center">
                <div class="inline-block mb-6">
                    <div
                        class="flex items-center justify-center space-x-2 px-4 py-1.5 bg-white rounded-full shadow-sm border border-gray-100">
                        <span class="h-2 w-2 rounded-full bg-gradient-to-r from-blue-400 to-purple-60"></span>
                        <span class="text-sm font-medium text-gray-600">Our Story</span>
                    </div>
                </div>

                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    About <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-600">Our
                        Blog</span>
                </h1>

                <p class="text-xl text-gray-700 leading-relaxed mb-10 max-w-2xl mx-auto">
                    We're passionate about sharing knowledge, insights, and stories that inspire and inform our
                    community.
                </p>

                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#team"
                        class="px-6 py-3 bg-gradient-to-r from-blue-400 to-purple-600 text-white font-medium rounded-lg hover:opacity-90 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Meet Our Team
                    </a>
                    <a href="#story"
                        class="px-6 py-3 bg-white text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all border border-gray-200 shadow-sm hover:shadow">
                        Learn Our Story
                    </a>
                </div>
            </div>
        </div>

        <!-- Wave divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="white" preserveAspectRatio="none"
                class="w-full h-12 md:h-20">
                <path
                    d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </section>
</template>