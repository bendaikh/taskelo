<template>
  <div>
    <div v-if="tasks.length === 0" class="text-center py-4 text-gray-500 dark:text-gray-400">
      No tasks yet. Add your first task above.
    </div>

    <div v-else class="space-y-3">
      <div 
        v-for="task in sortedTasks" 
        :key="task.id"
        class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
        :class="{
          'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800': task.status === 'done'
        }">
        
        <div class="flex items-start space-x-3">
          <!-- Status Select -->
          <select 
            v-model="task.status"
            @change="updateTaskStatus(task)"
            class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500"
            :class="{
              'border-yellow-400 dark:border-yellow-600': task.status === 'todo',
              'border-blue-400 dark:border-blue-600': task.status === 'in_progress',
              'border-green-400 dark:border-green-600': task.status === 'done'
            }">
            <option value="todo">To Do</option>
            <option value="in_progress">In Progress</option>
            <option value="done">Done</option>
          </select>

          <!-- Task Content -->
          <div class="flex-1">
            <h4 class="font-medium text-gray-800 dark:text-gray-200" :class="{ 'line-through text-gray-500': task.status === 'done' }">
              {{ task.title }}
            </h4>
            
            <p v-if="task.description" class="text-sm text-gray-600 dark:text-gray-400 mt-1">
              {{ task.description }}
            </p>

            <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500 dark:text-gray-400">
              <span v-if="task.deadline">
                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ formatDate(task.deadline) }}
                <span v-if="isOverdue(task)" class="text-red-600 dark:text-red-400 font-medium ml-1">(Overdue)</span>
              </span>
              
              <span>
                Created {{ formatDate(task.created_at) }}
              </span>
            </div>
          </div>

          <!-- Delete Button -->
          <button 
            @click="deleteTask(task)"
            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TaskList',
  props: {
    projectId: {
      type: Number,
      required: true
    },
    initialTasks: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      tasks: [...this.initialTasks]
    };
  },
  computed: {
    sortedTasks() {
      return [...this.tasks].sort((a, b) => {
        // Sort by status priority
        const statusOrder = { 'in_progress': 0, 'todo': 1, 'done': 2 };
        const statusDiff = statusOrder[a.status] - statusOrder[b.status];
        
        if (statusDiff !== 0) return statusDiff;
        
        // Then by deadline (overdue first)
        if (a.deadline && b.deadline) {
          return new Date(a.deadline) - new Date(b.deadline);
        }
        if (a.deadline) return -1;
        if (b.deadline) return 1;
        
        // Finally by creation date
        return new Date(b.created_at) - new Date(a.created_at);
      });
    }
  },
  methods: {
    async updateTaskStatus(task) {
      try {
        const response = await axios.patch(`/tasks/${task.id}/status`, {
          status: task.status
        });

        if (response.data.success) {
          // Update the task in the list
          const index = this.tasks.findIndex(t => t.id === task.id);
          if (index !== -1) {
            this.tasks[index] = response.data.task;
          }

          // Optionally update progress bar if present on the page
          if (response.data.progress !== undefined) {
            this.updateProgressBars(response.data.progress);
          }
        }
      } catch (error) {
        console.error('Error updating task status:', error);
        alert('Failed to update task status. Please try again.');
      }
    },

    async deleteTask(task) {
      if (!confirm('Are you sure you want to delete this task?')) {
        return;
      }

      try {
        await axios.delete(`/tasks/${task.id}`);
        
        // Remove task from list
        this.tasks = this.tasks.filter(t => t.id !== task.id);
      } catch (error) {
        console.error('Error deleting task:', error);
        alert('Failed to delete task. Please try again.');
      }
    },

    formatDate(date) {
      if (!date) return '';
      
      const d = new Date(date);
      return d.toLocaleDateString('en-US', { 
        month: 'short', 
        day: 'numeric', 
        year: 'numeric' 
      });
    },

    isOverdue(task) {
      if (!task.deadline || task.status === 'done') return false;
      return new Date(task.deadline) < new Date();
    },

    updateProgressBars(progress) {
      // Update progress bars on the page
      const progressBars = document.querySelectorAll('[style*="width"]');
      progressBars.forEach(bar => {
        if (bar.classList.contains('bg-primary-600')) {
          bar.style.width = progress + '%';
        }
      });

      // Update progress text
      const progressTexts = document.querySelectorAll('p');
      progressTexts.forEach(text => {
        if (text.textContent.includes('% complete')) {
          const match = text.textContent.match(/(\d+)\/(\d+) tasks/);
          if (match) {
            const total = parseInt(match[2]);
            const completed = Math.round((progress / 100) * total);
            text.textContent = text.textContent.replace(/\d+% complete/, progress + '% complete');
            text.textContent = text.textContent.replace(/\d+\/\d+ tasks/, `${completed}/${total} tasks`);
          }
        }
      });
    }
  }
};
</script>

