<template>
  <div>
    <canvas ref="chartCanvas"></canvas>
  </div>
</template>

<script>
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
  name: 'RevenueChart',
  props: {
    data: {
      type: Array,
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
      
      // Prepare data
      // Support monthly items ({ month: 'YYYY-MM' }) and daily items ({ day: 'YYYY-MM-DD' })
      const labels = this.data.map(item => {
        if (item.month) {
          const [year, month] = item.month.split('-');
          const date = new Date(year, month - 1);
          return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
        }
        if (item.day) {
          const [year, month, day] = item.day.split('-');
          const date = new Date(year, month - 1, day);
          return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        }
        return '';
      });

      const values = this.data.map(item => parseFloat(item.total));

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Revenue',
            data: values,
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.3,
            fill: true
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              callbacks: {
                label: (context) => {
                  return this.currency + ' ' + context.parsed.y.toFixed(2);
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: (value) => {
                  return this.currency + ' ' + value.toLocaleString();
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

