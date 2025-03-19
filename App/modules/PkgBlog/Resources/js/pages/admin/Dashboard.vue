<template>
    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Bar Chart -->
            <Chart :chartType="'bar'" :chartData="barChartData" :chartOptions="barChartOptions" />

            <!-- Line Chart -->
            <Chart :chartType="'line'" :chartData="lineChartData" :chartOptions="lineChartOptions" />
        </div>
    </Layout>
</template>

<script setup>
import { ref } from 'vue';
import Layout from "../../components/Layout.vue";
import Chart from '../../components/Chart.vue';

// Bar Chart Data
const barChartData = ref({
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
    datasets: [
        {
            label: 'Articles Created',
            data: [10, 20, 15, 30, 25],
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
        },
    ],
});

const barChartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
});

// Line Chart Data
const lineChartData = ref({
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
    datasets: [
        {
            label: 'Views',
            data: [100, 200, 150, 300, 250],
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            fill: false,
        },
    ],
});

const lineChartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
});
</script>
