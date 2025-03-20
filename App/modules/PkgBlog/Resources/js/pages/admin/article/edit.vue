<template>
    <Layout>
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-xl">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Edit Article</h2>

            <!-- Display EditArticleForm -->
            <EditArticleForm />
        </div>
    </Layout>
</template>

<script setup>
import Layout from '../../../components/Layout.vue';
import EditArticleForm from '../../../components/EditArticleForm.vue';
</script>
