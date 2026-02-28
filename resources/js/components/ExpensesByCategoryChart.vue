<template>
  <div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
      <div class="flex items-center gap-2 flex-wrap">
        <span class="text-sm text-gray-600 dark:text-gray-300">{{ uiLabels.filter }}:</span>
        <label class="text-sm text-gray-600 dark:text-gray-300">{{ uiLabels.year }}</label>
        <select
          v-model="selectedYear"
          @change="onFiltersChange"
          class="text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-primary-500 focus:ring-primary-500"
        >
          <option value="">{{ uiLabels.all }}</option>
          <option v-for="year in localAvailableYears" :key="year" :value="String(year)">
            {{ year }}
          </option>
        </select>

        <label class="text-sm text-gray-600 dark:text-gray-300">{{ uiLabels.month }}</label>
        <select
          v-model="selectedMonth"
          @change="onFiltersChange"
          :disabled="!selectedYear"
          class="text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-primary-500 focus:ring-primary-500 disabled:opacity-60"
        >
          <option value="">{{ uiLabels.all }}</option>
          <option v-for="month in monthOptions" :key="month.value" :value="String(month.value)">
            {{ month.label }}
          </option>
        </select>
      </div>
    </div>

    <div v-if="isLoading" class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ uiLabels.loading }}</div>
    <div v-if="!isLoading && !hasData" class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ uiLabels.noData }}</div>
    <canvas v-show="hasData" ref="chartCanvas"></canvas>
  </div>
</template>

<script>
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
  name: 'ExpensesByCategoryChart',
  props: {
    data: { type: Array, required: true }, // [{ label, total }]
    currency: { type: String, default: 'USD' },
    availableYears: { type: Array, default: () => [] },
    initialYear: { type: [Number, String, null], default: null },
    initialMonth: { type: [Number, String, null], default: null },
    labels: { type: Object, default: () => ({}) },
    endpoint: { type: String, default: '' }
  },
  data() {
    return {
      chart: null,
      chartData: this.data || [],
      localAvailableYears: this.availableYears || [],
      selectedYear: this.initialYear ? String(this.initialYear) : '',
      selectedMonth: this.initialMonth ? String(this.initialMonth) : '',
      isLoading: false
    };
  },
  computed: {
    hasData() {
      return Array.isArray(this.chartData) && this.chartData.length > 0;
    },
    uiLabels() {
      return {
        filter: this.labels.filter || 'Filter',
        year: this.labels.year || 'Year',
        month: this.labels.month || 'Month',
        all: this.labels.all || 'All',
        loading: this.labels.loading || 'Loading...',
        noData: this.labels.noData || 'No data available'
      };
    },
    monthOptions() {
      const formatter = new Intl.DateTimeFormat(document.documentElement.lang || undefined, { month: 'long' });
      return Array.from({ length: 12 }, (_, index) => ({
        value: index + 1,
        label: formatter.format(new Date(2000, index, 1))
      }));
    }
  },
  mounted() {
    this.renderChart();
  },
  methods: {
    async onFiltersChange() {
      if (!this.selectedYear) {
        this.selectedMonth = '';
      }
      await this.fetchChartData();
    },
    async fetchChartData() {
      if (!this.endpoint) return;

      this.isLoading = true;
      try {
        const params = {};
        if (this.selectedYear) {
          params.year = Number(this.selectedYear);
        }
        if (this.selectedYear && this.selectedMonth) {
          params.month = Number(this.selectedMonth);
        }

        const response = await axios.get(this.endpoint, { params });
        this.chartData = response.data?.data || [];

        if (Array.isArray(response.data?.availableYears)) {
          this.localAvailableYears = response.data.availableYears;
        }
      } catch (error) {
        console.error('Failed to fetch expenses by category data:', error);
      } finally {
        this.isLoading = false;
        this.$nextTick(() => this.renderChart());
      }
    },
    renderChart() {
      if (this.chart) {
        this.chart.destroy();
        this.chart = null;
      }

      if (!this.hasData) {
        return;
      }

      const ctx = this.$refs.chartCanvas.getContext('2d');
      const labels = this.chartData.map(d => d.label);
      const values = this.chartData.map(d => parseFloat(d.total || 0));

      this.chart = new Chart(ctx, {
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
  },
  beforeUnmount() {
    if (this.chart) {
      this.chart.destroy();
      this.chart = null;
    }
  }
}
</script>


