<template>
    <section id="team" class="py-20 md:py-28 bg-white relative overflow-hidden">
        <!-- Background decorations -->
        <div class="absolute inset-0 pointer-events-none">
            <div
                class="absolute top-40 right-0 w-72 h-72 bg-gradient-to-bl from-purple-100 to-transparent rounded-full opacity-70 translate-x-1/2 blur-3xl">
            </div>
            <div
                class="absolute bottom-40 left-0 w-72 h-72 bg-gradient-to-tr from-blue-100 to-transparent rounded-full opacity-70 -translate-x-1/2 blur-3xl">
            </div>
        </div>

        <div class="container mx-auto px-4 relative">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <div class="inline-block mb-4">
                    <div
                        class="flex items-center justify-center space-x-2 px-4 py-1.5 bg-gray-50 rounded-full shadow-sm border border-gray-100">
                        <span class="h-2 w-2 rounded-full bg-gradient-to-r from-pink-500 to-purple-500"></span>
                        <span class="text-sm font-medium text-gray-600">The People Behind the Words</span>
                    </div>
                </div>

                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Meet Our Team</h2>
                <p class="text-xl text-gray-700 max-w-2xl mx-auto">
                    The passionate individuals behind the content you love, working together to create meaningful
                    experiences.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
                <TeamMember name="Sarah Johnson" role="Founder & Editor-in-Chief" roleColor="purple"
                    bio="With over 10 years of experience in digital publishing, Sarah leads our editorial vision."
                    imageUrl="/placeholder.svg?height=160&width=160" />

                <TeamMember name="David Chen" role="Senior Writer" roleColor="blue"
                    bio="David specializes in technology and innovation, bringing complex topics to life with clarity."
                    imageUrl="/placeholder.svg?height=160&width=160" />

                <TeamMember name="Maya Patel" role="Content Strategist" roleColor="pink"
                    bio="Maya ensures our content strategy aligns with our mission and resonates with our audience."
                    imageUrl="/placeholder.svg?height=160&width=160" />

                <TeamMember name="James Wilson" role="Community Manager" roleColor="teal"
                    bio="James fosters our community engagement and ensures our readers' voices are heard."
                    imageUrl="/placeholder.svg?height=160&width=160" />
            </div>
        </div>
    </section>
</template>

<script setup>
import { defineComponent } from 'vue';

const TeamMember = defineComponent({
    props: {
        name: String,
        role: String,
        roleColor: String,
        bio: String,
        imageUrl: String
    },
    setup(props) {
        const getRoleColorClass = () => {
            switch (props.roleColor) {
                case 'purple': return 'from-purple-500 to-indigo-600';
                case 'blue': return 'from-blue-500 to-cyan-600';
                case 'pink': return 'from-pink-500 to-rose-600';
                case 'teal': return 'from-teal-500 to-emerald-600';
                default: return 'from-gray-500 to-gray-600';
            }
        };

        return {
            getRoleColorClass
        };
    },
    template: `
      <div class="group">
        <div class="relative mb-6">
          <!-- Image container with gradient border -->
          <div class="relative mx-auto w-48 h-48 rounded-2xl overflow-hidden p-1 bg-gradient-to-br" :class="['bg-gradient-to-br', getRoleColorClass()]">
            <div class="absolute inset-0 bg-white rounded-2xl m-0.5"></div>
            <div class="relative w-full h-full rounded-xl overflow-hidden">
              <img :src="imageUrl" :alt="name" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
            </div>
          </div>
          
          <!-- Social media icons -->
          <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-1">
            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-white shadow-md hover:shadow-lg transition-all text-gray-600 hover:text-blue-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
              </svg>
            </a>
            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-white shadow-md hover:shadow-lg transition-all text-gray-600 hover:text-blue-700">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"></path>
              </svg>
            </a>
          </div>
        </div>
        
        <div class="text-center">
          <h3 class="text-xl font-bold text-gray-900 mb-1">{{ name }}</h3>
          <p class="font-medium mb-3 bg-gradient-to-r bg-clip-text text-transparent" :class="['bg-gradient-to-r', getRoleColorClass()]">{{ role }}</p>
          <p class="text-gray-600 text-sm">
            {{ bio }}
          </p>
        </div>
      </div>
    `
});
</script>