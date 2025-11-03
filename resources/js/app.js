import './bootstrap';
import { createApp } from 'vue';

// Import components
import RevenueChart from './components/RevenueChart.vue';
import PaymentStatusChart from './components/PaymentStatusChart.vue';
import TaskList from './components/TaskList.vue';
import ExpensesChart from './components/ExpensesChart.vue';
import CashflowChart from './components/CashflowChart.vue';

// Helper to parse JSON from attribute safely
function parseJsonAttr(el, attrName, fallback = null) {
    const raw = el.getAttribute(attrName);
    if (!raw) return fallback;
    try { return JSON.parse(raw); } catch { return fallback; }
}

// Mount each component individually to avoid replacing the entire page
document.querySelectorAll('revenue-chart').forEach((el) => {
    const props = {
        data: parseJsonAttr(el, ':data', []),
        currency: el.getAttribute(':currency')?.replaceAll("'", '') || '',
    };
    createApp(RevenueChart, props).mount(el);
});

document.querySelectorAll('payment-status-chart').forEach((el) => {
    const props = {
        data: parseJsonAttr(el, ':data', {}),
        currency: el.getAttribute(':currency')?.replaceAll("'", '') || '',
    };
    createApp(PaymentStatusChart, props).mount(el);
});

document.querySelectorAll('task-list').forEach((el) => {
    const projectIdAttr = el.getAttribute(':project-id');
    const initialTasks = parseJsonAttr(el, ':initial-tasks', []);
    const projectId = projectIdAttr ? parseInt(projectIdAttr, 10) : undefined;
    createApp(TaskList, { projectId, initialTasks }).mount(el);
});

document.querySelectorAll('expenses-chart').forEach((el) => {
    const props = {
        data: parseJsonAttr(el, ':data', []),
        currency: el.getAttribute(':currency')?.replaceAll("'", '') || '',
    };
    createApp(ExpensesChart, props).mount(el);
});

document.querySelectorAll('cashflow-chart').forEach((el) => {
    const props = {
        data: parseJsonAttr(el, ':data', []),
        currency: el.getAttribute(':currency')?.replaceAll("'", '') || '',
    };
    createApp(CashflowChart, props).mount(el);
});

