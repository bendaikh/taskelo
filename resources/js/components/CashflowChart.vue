<template>
  <div>
    <canvas ref="chartCanvas"></canvas>
  </div>
</template>

<script>
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
  name: 'CashflowChart',
  props: {
    data: { type: Array, required: true }, // [{ month, revenue, expenses, cashflow }]
    currency: { type: String, default: 'USD' }
  },
  mounted() {
    this.renderChart();
  },
  methods: {
    renderChart() {
      const ctx = this.$refs.chartCanvas.getContext('2d');

      const labels = this.data.map(item => {
        const [year, month] = item.month.split('-');
        const date = new Date(year, month - 1);
        return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
      });

      const revenue = this.data.map(item => parseFloat(item.revenue || 0));
      const expenses = this.data.map(item => parseFloat(item.expenses || 0));
      const cashflow = this.data.map(item => parseFloat(item.cashflow || 0));

      new Chart(ctx, {
        type: 'line',
        data: {
          labels,
          datasets: [
            {
              label: 'Revenue',
              data: revenue,
              borderColor: 'rgb(59, 130, 246)',
              backgroundColor: 'rgba(59, 130, 246, 0.1)',
              tension: 0.3,
              fill: false
            },
            {
              label: 'Expenses',
              data: expenses,
              borderColor: 'rgb(239, 68, 68)',
              backgroundColor: 'rgba(239, 68, 68, 0.1)',
              tension: 0.3,
              fill: false
            },
            {
              label: 'Cashflow',
              data: cashflow,
              borderColor: 'rgb(34, 197, 94)',
              backgroundColor: 'rgba(34, 197, 94, 0.1)',
              tension: 0.3,
              fill: false
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          plugins: {
            legend: { display: true },
            tooltip: {
              callbacks: {
                label: (context) => this.currency + ' ' + context.parsed.y.toFixed(2)
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: (value) => this.currency + ' ' + value.toLocaleString()
              }
            }
          }
        }
      });
    }
  }
}
</script>


