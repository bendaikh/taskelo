<template>
  <div>
    <canvas ref="chartCanvas"></canvas>
  </div>
</template>

<script>
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
  name: 'PaymentStatusChart',
  props: {
    data: {
      type: Object,
      required: true
    },
    currency: {
      type: String,
      default: 'USD'
    }
  },
  mounted() {
    this.renderChart();
  },
  methods: {
    renderChart() {
      const ctx = this.$refs.chartCanvas.getContext('2d');

      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Paid', 'Pending'],
          datasets: [{
            data: [this.data.paid, this.data.pending],
            backgroundColor: [
              'rgb(34, 197, 94)',
              'rgb(239, 68, 68)'
            ],
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          plugins: {
            legend: {
              position: 'bottom'
            },
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
};
</script>

