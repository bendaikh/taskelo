<template>
  <div>
    <!-- Add Task Form -->
    <div v-if="showAddForm" class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Add New Task</h3>
      <form @submit.prevent="addTask" class="space-y-3">
        <input 
          v-model="newTask.title"
          type="text"
          placeholder="Task title *"
          required
          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
        
        <textarea 
          v-model="newTask.description"
          placeholder="Task description (optional)"
          rows="2"
          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500"></textarea>
        
        <div class="grid grid-cols-2 gap-3">
          <input 
            v-model="newTask.deadline"
            type="date"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
          
          <select 
            v-model="newTask.status"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            <option value="todo">To Do</option>
            <option value="in_progress">In Progress</option>
            <option value="done">Done</option>
          </select>
        </div>
        
        <div class="flex justify-end space-x-2">
          <button 
            type="button" 
            @click="cancelAdd"
            class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500">
            Cancel
          </button>
          <button 
            type="submit" 
            class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
            Add Task
          </button>
        </div>
      </form>
    </div>

    <!-- Add Task Button -->
    <div v-else class="mb-6">
      <button 
        @click="showAddForm = true"
        class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Add New Task</span>
      </button>
    </div>

    <!-- Tasks List -->
    <div v-if="tasks.length === 0" class="text-center py-8 text-gray-500 dark:text-gray-400">
      <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
      </svg>
      <p class="text-lg font-medium">No tasks yet</p>
      <p class="text-sm">Click "Add New Task" to get started</p>
    </div>

    <div v-else class="space-y-3">
      <div 
        v-for="task in sortedTasks" 
        :key="task.id"
        class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
        :class="{
          'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800': task.status === 'done'
        }">
        
        <!-- View Mode -->
        <div v-if="editingTaskId !== task.id" class="flex items-start space-x-3">
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

          <!-- Action Buttons -->
          <div class="flex items-center space-x-2">
            <button 
              @click="startEditTask(task)"
              class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
              title="Edit task">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
              </svg>
            </button>
            <button 
              @click="deleteTask(task)"
              class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
              title="Delete task">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
              </svg>
            </button>
          </div>
        </div>

        <!-- Edit Mode -->
        <div v-else class="space-y-3">
          <input 
            v-model="editForm.title"
            type="text"
            placeholder="Task title"
            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
          
          <textarea 
            v-model="editForm.description"
            placeholder="Task description (optional)"
            rows="2"
            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500"></textarea>
          
          <div class="grid grid-cols-2 gap-3">
            <input 
              v-model="editForm.deadline"
              type="date"
              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            
            <select 
              v-model="editForm.status"
              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
              <option value="todo">To Do</option>
              <option value="in_progress">In Progress</option>
              <option value="done">Done</option>
            </select>
          </div>
          
          <div class="flex justify-end space-x-2">
            <button 
              @click="cancelEdit"
              class="px-3 py-1 text-sm bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-400 dark:hover:bg-gray-500">
              Cancel
            </button>
            <button 
              @click="saveEdit(task)"
              class="px-3 py-1 text-sm bg-primary-600 text-white rounded hover:bg-primary-700">
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DailyTasksList',
  props: {
    initialTasks: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      tasks: [...this.initialTasks],
      showAddForm: false,
      editingTaskId: null,
      newTask: {
        title: '',
        description: '',
        deadline: '',
        status: 'todo'
      },
      editForm: {
        title: '',
        description: '',
        deadline: '',
        status: 'todo'
      }
    };
  },
  computed: {
    sortedTasks() {
      return [...this.tasks].sort((a, b) => {
        // Sort by status priority: todo > in_progress > done
        const statusOrder = { todo: 0, in_progress: 1, done: 2 };
        if (statusOrder[a.status] !== statusOrder[b.status]) {
          return statusOrder[a.status] - statusOrder[b.status];
        }
        // Then by created date (newest first)
        return new Date(b.created_at) - new Date(a.created_at);
      });
    }
  },
  methods: {
    async addTask() {
      if (!this.newTask.title.trim()) {
        alert('Task title is required');
        return;
      }

      try {
        const response = await axios.post('/daily-tasks', {
          title: this.newTask.title.trim(),
          description: this.newTask.description || null,
          deadline: this.newTask.deadline || null,
          status: this.newTask.status
        });

        if (response.data.success) {
          this.tasks.push(response.data.task);
          this.cancelAdd();
        }
      } catch (error) {
        console.error('Error adding task:', error);
        alert('Failed to add task. Please try again.');
      }
    },

    cancelAdd() {
      this.showAddForm = false;
      this.newTask = {
        title: '',
        description: '',
        deadline: '',
        status: 'todo'
      };
    },

    async updateTaskStatus(task) {
      try {
        const response = await axios.patch(`/daily-tasks/${task.id}/status`, {
          status: task.status
        });

        if (response.data.success) {
          const index = this.tasks.findIndex(t => t.id === task.id);
          if (index !== -1) {
            this.tasks[index] = response.data.task;
          }
        }
      } catch (error) {
        console.error('Error updating task status:', error);
        alert('Failed to update task status. Please try again.');
        // Revert the status
        const index = this.tasks.findIndex(t => t.id === task.id);
        if (index !== -1) {
          this.tasks = [...this.tasks];
        }
      }
    },

    startEditTask(task) {
      this.editingTaskId = task.id;
      this.editForm = {
        title: task.title,
        description: task.description || '',
        deadline: task.deadline ? this.formatDateForInput(task.deadline) : '',
        status: task.status
      };
    },

    cancelEdit() {
      this.editingTaskId = null;
      this.editForm = {
        title: '',
        description: '',
        deadline: '',
        status: 'todo'
      };
    },

    async saveEdit(task) {
      if (!this.editForm.title.trim()) {
        alert('Task title is required');
        return;
      }

      try {
        const response = await axios.put(`/daily-tasks/${task.id}`, {
          title: this.editForm.title.trim(),
          description: this.editForm.description || null,
          deadline: this.editForm.deadline || null,
          status: this.editForm.status
        });

        if (response.data.success) {
          const index = this.tasks.findIndex(t => t.id === task.id);
          if (index !== -1) {
            this.tasks[index] = response.data.task;
          }
          this.cancelEdit();
        }
      } catch (error) {
        console.error('Error updating task:', error);
        alert('Failed to update task. Please try again.');
      }
    },

    async deleteTask(task) {
      if (!confirm('Are you sure you want to delete this task?')) {
        return;
      }

      try {
        const response = await axios.delete(`/daily-tasks/${task.id}`);

        if (response.data.success) {
          this.tasks = this.tasks.filter(t => t.id !== task.id);
        }
      } catch (error) {
        console.error('Error deleting task:', error);
        alert('Failed to delete task. Please try again.');
      }
    },

    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
      });
    },

    formatDateForInput(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toISOString().split('T')[0];
    },

    isOverdue(task) {
      if (!task.deadline || task.status === 'done') {
        return false;
      }
      const deadline = new Date(task.deadline);
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      return deadline < today;
    }
  }
};
</script>
