<template>
    <div class="w-full max-w-lg mx-auto">
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

export default {
    props: {
        chartType: { type: String, required: true },
        chartData: { type: Object, required: true },
        chartOptions: { type: Object, default: () => ({}) },
    },
    setup(props) {
        const chartCanvas = ref(null);
        let chartInstance = null;

        onMounted(() => {
            if (chartCanvas.value) {
                chartInstance = new Chart(chartCanvas.value, {
                    type: props.chartType,
                    data: props.chartData,
                    options: props.chartOptions,
                });
            }
        });

        watch(() => props.chartData, (newData) => {
            if (chartInstance) {
                chartInstance.data = newData;
                chartInstance.update();
            }
        }, { deep: true });

        return { chartCanvas };
    },
};
</script>

<style scoped>
canvas {
    max-width: 100%;
}
</style>