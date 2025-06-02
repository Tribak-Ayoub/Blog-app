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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mx-auto px-4 relative">
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
          imageUrl="/images/team/sarah-johnson.jpg?height=160&width=160" />

        <TeamMember name="David Chen" role="Senior Writer" roleColor="blue"
          bio="David specializes in technology and innovation, bringing complex topics to life with clarity."
          imageUrl="/images/team/david-chen.jpg?height=160&width=160" />

        <TeamMember name="Maya Patel" role="Content Strategist" roleColor="pink"
          bio="Maya ensures our content strategy aligns with our mission and resonates with our audience."
          imageUrl="/images/team/maya-patel.jpg?height=160&width=160" />

        <TeamMember name="James Wilson" role="Community Manager" roleColor="teal"
          bio="James fosters our community engagement and ensures our readers' voices are heard."
          imageUrl="/images/team/james-wilson.jpg?height=160&width=160" />
      </div>
    </div>
  </section>
</template>

<script setup>
import TeamMember from './TeamMember.vue';

</script>