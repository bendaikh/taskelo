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
              
              <span v-if="task.price" class="font-medium text-gray-700 dark:text-gray-300">
                ${{ parseFloat(task.price).toFixed(2) }}
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
              class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            
            <input 
              v-model="editForm.price"
              type="number"
              step="0.01"
              min="0"
              placeholder="Price (optional)"
              class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
          </div>

          <select 
            v-model="editForm.status"
            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            <option value="todo">To Do</option>
            <option value="in_progress">In Progress</option>
            <option value="done">Done</option>
          </select>

          <div class="flex justify-end space-x-2">
            <button 
              @click="cancelEdit"
              class="px-3 py-1.5 text-sm bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
              Cancel
            </button>
            <button 
              @click="saveEdit(task)"
              class="px-3 py-1.5 text-sm bg-primary-600 text-white rounded hover:bg-primary-700 transition-colors">
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
      tasks: [...this.initialTasks],
      editingTaskId: null,
      editForm: {
        title: '',
        description: '',
        deadline: '',
        price: '',
        status: 'todo'
      }
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
      // Construct the URL properly
      const statusUrl = window.location.origin + '/tasks/' + task.id + '/status';
      
      try {
        const response = await axios.patch(statusUrl, {
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
        // Revert the status
        const index = this.tasks.findIndex(t => t.id === task.id);
        if (index !== -1) {
          this.tasks = [...this.tasks]; // Force reactivity
        }
      }
    },

    startEditTask(task) {
      this.editingTaskId = task.id;
      this.editForm = {
        title: task.title,
        description: task.description || '',
        deadline: task.deadline ? this.formatDateForInput(task.deadline) : '',
        price: task.price || '',
        status: task.status
      };
    },

    cancelEdit() {
      this.editingTaskId = null;
      this.editForm = {
        title: '',
        description: '',
        deadline: '',
        price: '',
        status: 'todo'
      };
    },

    async saveEdit(task) {
      if (!this.editForm.title.trim()) {
        alert('Task title is required');
        return;
      }

      // Construct the URL properly
      const updateUrl = window.location.origin + '/tasks/' + task.id;
      
      // Prepare the data - ensure proper formatting
      const updateData = {
        title: this.editForm.title.trim(),
        description: this.editForm.description || null,
        deadline: this.editForm.deadline || null,
        price: this.editForm.price ? parseFloat(this.editForm.price) : null,
        status: this.editForm.status
      };
      
      console.log('=== UPDATE TASK DEBUG ===');
      console.log('Task ID:', task.id);
      console.log('PUT URL:', updateUrl);
      console.log('Update Data:', updateData);
      console.log('========================');

      try {
        const response = await axios.put(updateUrl, updateData);
        
        console.log('Update response:', response);
        
        // Update task in list
        const index = this.tasks.findIndex(t => t.id === task.id);
        if (index !== -1) {
          this.tasks[index] = {
            ...this.tasks[index],
            ...updateData,
            updated_at: new Date().toISOString()
          };
          // Force reactivity
          this.tasks = [...this.tasks];
        }

        this.cancelEdit();
        
        // Show success message
        console.log('Task updated successfully');

        // Reload page to refresh progress bars and all data
        window.location.reload();
      } catch (error) {
        console.error('=== UPDATE ERROR ===');
        console.error('Error updating task:', error);
        
        if (error.response) {
          console.error('Response status:', error.response.status);
          console.error('Response data:', error.response.data);
          
          // Show validation errors if present
          if (error.response.data && error.response.data.errors) {
            console.error('Validation errors:', error.response.data.errors);
            
            // Build a readable error message
            const errors = error.response.data.errors;
            let errorMessage = 'Validation failed:\n';
            for (const field in errors) {
              errorMessage += `\n- ${field}: ${errors[field].join(', ')}`;
            }
            alert(errorMessage);
          } else if (error.response.data && error.response.data.message) {
            alert('Failed to update task: ' + error.response.data.message);
          } else {
            alert('Failed to update task: ' + error.response.statusText);
          }
        } else {
          alert('Failed to update task. Please try again.');
        }
        console.error('===================');
      }
    },

    async deleteTask(task) {
      // Debug: Log full task object to see what we're working with
      console.log('=== DELETE TASK DEBUG ===');
      console.log('Full task object:', task);
      console.log('Task ID:', task.id);
      console.log('Project ID:', this.projectId);
      console.log('========================');
      
      if (!confirm('Are you sure you want to delete this task?')) {
        return;
      }

      // Make absolutely sure we're using the task ID, not project ID
      const taskId = parseInt(task.id, 10);
      
      if (!taskId || isNaN(taskId)) {
        alert('Error: Invalid task ID');
        console.error('Invalid task ID:', task.id);
        return;
      }
      
      // Construct the URL with extra validation
      const deleteUrl = window.location.origin + '/tasks/' + taskId;
      console.log('DELETE URL:', deleteUrl);
      console.log('Sending DELETE request...');

      try {
        const response = await axios.delete(deleteUrl);
        
        console.log('Delete response:', response);
        console.log('Task deleted successfully');
        
        // Remove task from list
        this.tasks = this.tasks.filter(t => t.id !== task.id);
        
        // Reload page to refresh progress bars
        setTimeout(() => {
          window.location.reload();
        }, 500);
      } catch (error) {
        console.error('Error deleting task:', error);
        if (error.response) {
          console.error('Response status:', error.response.status);
          console.error('Response data:', error.response.data);
          console.error('Request URL was:', deleteUrl);
          alert('Failed to delete task: ' + (error.response.data.message || error.response.statusText));
        } else if (error.request) {
          console.error('No response received:', error.request);
          alert('Failed to delete task. No response from server.');
        } else {
          console.error('Error:', error.message);
          alert('Failed to delete task. Please try again.');
        }
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

    formatDateForInput(date) {
      if (!date) return '';
      const d = new Date(date);
      const year = d.getFullYear();
      const month = String(d.getMonth() + 1).padStart(2, '0');
      const day = String(d.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
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

