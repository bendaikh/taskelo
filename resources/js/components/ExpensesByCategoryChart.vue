<template>
  <div>
    <canvas ref="chartCanvas"></canvas>
  </div>
</template>

<script>
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
  name: 'ExpensesByCategoryChart',
  props: {
    data: { type: Array, required: true }, // [{ label, total }]
    currency: { type: String, default: 'USD' }
  },
  mounted() {
    this.renderChart();
  },
  methods: {
    renderChart() {
      const ctx = this.$refs.chartCanvas.getContext('2d');
      const labels = this.data.map(d => d.label);
      const values = this.data.map(d => parseFloat(d.total || 0));

      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels,
          datasets: [{
            data: values,
            backgroundColor: [
              '#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#22c55e', '#06b6d4'
            ],
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          plugins: {
            legend: { position: 'bottom' },
            tooltip: {
              callbacks: {
                label: (context) => {
                  const label = context.label || '';
                  const value = context.parsed || 0;
                  return label + ': ' + this.currency + ' ' + value.toFixed(2);
                }
              }
            }
          }
        }
      });
    }
  }
}
</script>


