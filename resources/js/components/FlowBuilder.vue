<template>
  <div class="flow-builder-container">
    <!-- Toolbar -->
    <div class="mb-4 flex items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
      <div class="flex items-center space-x-4">
        <button
          @click="showAddNodeModal = true"
          :disabled="connectionMode"
          :class="[
            'px-4 py-2 rounded-lg transition-colors flex items-center space-x-2',
            connectionMode 
              ? 'bg-gray-300 dark:bg-gray-600 text-gray-500 cursor-not-allowed' 
              : 'bg-primary-600 text-white hover:bg-primary-700'
          ]">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <span>Add Node</span>
        </button>
        <button
          @click="toggleConnectionMode"
          :class="[
            'px-4 py-2 rounded-lg transition-colors flex items-center space-x-2',
            connectionMode 
              ? 'bg-green-600 text-white hover:bg-green-700' 
              : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600'
          ]">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
          <span>{{ connectionMode ? 'Cancel Connection' : 'Connect Nodes' }}</span>
        </button>
        
        <!-- Connection status indicator -->
        <div v-if="connectionMode" class="flex items-center space-x-2 text-sm">
          <div v-if="!connectingFrom" class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-lg">
            Step 1: Click on a node to start connection
          </div>
          <div v-else class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
            Step 2: Click on another node to complete connection
          </div>
        </div>
      </div>
      <div class="flex items-center space-x-2">
        <button
          @click="zoomOut"
          class="p-2 bg-gray-200 dark:bg-gray-700 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path>
          </svg>
        </button>
        <span class="text-sm text-gray-600 dark:text-gray-400">{{ Math.round(zoom * 100) }}%</span>
        <button
          @click="zoomIn"
          class="p-2 bg-gray-200 dark:bg-gray-700 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Flow Canvas -->
    <div 
      class="flow-canvas-container relative bg-gray-50 dark:bg-gray-900 rounded-lg border-2 border-gray-200 dark:border-gray-700 overflow-hidden"
      :style="{ height: '600px', cursor: connectionMode ? 'crosshair' : 'default' }"
      @click="handleCanvasClick"
      @mousemove="handleMouseMove"
      @mousedown="handleMouseDown"
      @mouseup="handleMouseUp"
      @contextmenu.prevent="handleContextMenu">
      
      <!-- SVG for connections -->
      <svg class="absolute inset-0 pointer-events-auto" style="z-index: 1;">
        <defs>
          <!-- Arrow markers for different states -->
          <marker id="arrowhead" markerWidth="12" markerHeight="12" refX="10" refY="4" orient="auto" markerUnits="strokeWidth">
            <polygon points="0 0, 12 4, 0 8" fill="#4B5563" stroke="#4B5563" stroke-width="1" />
          </marker>
          <marker id="arrowhead-hover" markerWidth="14" markerHeight="14" refX="11" refY="5" orient="auto" markerUnits="strokeWidth">
            <polygon points="0 0, 14 5, 0 10" fill="#EF4444" stroke="#EF4444" stroke-width="1" />
          </marker>
          <marker id="arrowhead-preview" markerWidth="12" markerHeight="12" refX="10" refY="4" orient="auto" markerUnits="strokeWidth">
            <polygon points="0 0, 12 4, 0 8" fill="#10B981" stroke="#10B981" stroke-width="1" />
          </marker>
        </defs>
        <g :transform="`scale(${zoom}) translate(${panX}, ${panY})`">
          <!-- Existing connections -->
          <g
            v-for="edge in edges"
            :key="edge.id"
            class="connection-group"
            @mouseenter="hoveredEdge = edge.id"
            @mouseleave="hoveredEdge = null"
            @click.stop="deleteConnection(edge)">
            <line
              :x1="getConnectionStartX(edge.from_node_id)"
              :y1="getConnectionStartY(edge.from_node_id)"
              :x2="getConnectionEndX(edge.to_node_id)"
              :y2="getConnectionEndY(edge.to_node_id)"
              :stroke="hoveredEdge === edge.id ? '#EF4444' : '#4B5563'"
              :stroke-width="hoveredEdge === edge.id ? '3' : '2.5'"
              :marker-end="hoveredEdge === edge.id ? 'url(#arrowhead-hover)' : 'url(#arrowhead)'"
              class="connection-line transition-all"
              style="cursor: pointer;"
              fill="none"
            />
          </g>
          
          <!-- Preview connection line when connecting -->
          <line
            v-if="connectingFrom && previewConnection"
            :x1="getConnectionStartX(connectingFrom.id)"
            :y1="getConnectionStartY(connectingFrom.id)"
            :x2="previewConnection.x"
            :y2="previewConnection.y"
            stroke="#10B981"
            stroke-width="2.5"
            stroke-dasharray="5,5"
            marker-end="url(#arrowhead-preview)"
            class="connection-preview"
            style="pointer-events: none;"
          />
        </g>
      </svg>

      <!-- Nodes -->
      <div 
        class="absolute inset-0"
        :style="{ transform: `scale(${zoom}) translate(${panX}px, ${panY}px)` }">
        <div
          v-for="node in nodes"
          :key="node.id"
          :id="`node-${node.id}`"
          class="flow-node absolute cursor-move transition-all"
          :style="{
            left: node.position_x + 'px',
            top: node.position_y + 'px',
            borderColor: node.color,
            backgroundColor: node.color + '20'
          }"
          @mousedown.stop="startDrag(node, $event)"
          @click.stop="handleNodeClick(node, $event)"
          @dblclick.stop="editNode(node)">
          
          <div class="node-content bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 min-w-[200px] max-w-[250px] border-2 relative"
               :style="{ borderColor: node.color }"
               :class="{ 'ring-2 ring-green-500 ring-offset-2': connectionMode && connectingFrom && connectingFrom.id === node.id }">
            <!-- Connection handles -->
            <div class="connection-handles absolute inset-0 pointer-events-none">
              <!-- Output handle (right side) -->
              <div 
                class="connection-handle output-handle absolute top-1/2 w-4 h-4 rounded-full border-2 border-white dark:border-gray-700 shadow-md"
                :style="{ 
                  backgroundColor: connectionMode && connectingFrom && connectingFrom.id === node.id ? '#10B981' : node.color,
                  right: '-8px',
                  transform: 'translateY(-50%)'
                }"
                :class="{ 
                  'pointer-events-auto cursor-crosshair': connectionMode, 
                  'ring-2 ring-green-400': connectionMode && connectingFrom && connectingFrom.id === node.id,
                  'ring-2 ring-blue-400': connectionMode && !connectingFrom
                }"
                @click.stop="handleNodeClick(node, $event)"
                @mouseenter="handleHandleHover(node, 'output')"
                @mouseleave="handleHandleLeave">
              </div>
              <!-- Input handle (left side) -->
              <div 
                class="connection-handle input-handle absolute top-1/2 w-4 h-4 rounded-full border-2 border-white dark:border-gray-700 shadow-md"
                :style="{ 
                  backgroundColor: connectionMode && connectingFrom && connectingFrom.id !== node.id ? '#3B82F6' : node.color,
                  left: '-8px',
                  transform: 'translateY(-50%)'
                }"
                :class="{ 
                  'pointer-events-auto cursor-crosshair': connectionMode && connectingFrom && connectingFrom.id !== node.id, 
                  'ring-2 ring-blue-400': connectionMode && connectingFrom && connectingFrom.id !== node.id
                }"
                @click.stop="handleNodeClick(node, $event)"
                @mouseenter="handleHandleHover(node, 'input')"
                @mouseleave="handleHandleLeave">
              </div>
            </div>
            
            <div class="flex items-start justify-between mb-2">
              <h3 class="font-semibold text-gray-800 dark:text-gray-200 text-sm truncate flex-1">
                {{ node.title }}
              </h3>
              <button
                @click.stop="deleteNode(node)"
                class="ml-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
            
            <p v-if="node.description" class="text-xs text-gray-600 dark:text-gray-400 mb-2 line-clamp-2">
              {{ node.description }}
            </p>
            
            <div class="flex items-center space-x-2">
              <span 
                class="px-2 py-1 text-xs rounded-full"
                :class="getStatusClass(node.status)">
                {{ formatStatus(node.status) }}
              </span>
              <div 
                class="w-4 h-4 rounded-full border-2 border-white dark:border-gray-700"
                :style="{ backgroundColor: node.color }">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Node Modal -->
    <div v-if="showAddNodeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click="showAddNodeModal = false">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4" @click.stop>
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200">Add New Node</h2>
        <form @submit.prevent="createNode">
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
              <input
                v-model="newNode.title"
                type="text"
                required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
              <textarea
                v-model="newNode.description"
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500"></textarea>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
              <select
                v-model="newNode.status"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                <option value="planning">Planning</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Color</label>
              <input
                v-model="newNode.color"
                type="color"
                class="w-full h-10 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer">
            </div>
          </div>
          <div class="flex justify-end space-x-2 mt-6">
            <button
              type="button"
              @click="showAddNodeModal = false"
              class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
              Create Node
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Edit Node Modal -->
    <div v-if="editingNode" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click="cancelEdit">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4" @click.stop>
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200">Edit Node</h2>
        <form @submit.prevent="saveNode">
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
              <input
                v-model="editForm.title"
                type="text"
                required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
              <textarea
                v-model="editForm.description"
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500"></textarea>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
              <select
                v-model="editForm.status"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                <option value="planning">Planning</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Color</label>
              <input
                v-model="editForm.color"
                type="color"
                class="w-full h-10 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer">
            </div>
          </div>
          <div class="flex justify-end space-x-2 mt-6">
            <button
              type="button"
              @click="cancelEdit"
              class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
              Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FlowBuilder',
  props: {
    businessId: {
      type: Number,
      required: true
    },
    initialNodes: {
      type: Array,
      default: () => []
    },
    initialEdges: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      nodes: [...this.initialNodes],
      edges: [...this.initialEdges],
      connectionMode: false,
      connectingFrom: null,
      previewConnection: null,
      hoveredEdge: null,
      showAddNodeModal: false,
      editingNode: null,
      editForm: {
        title: '',
        description: '',
        status: 'planning',
        color: '#3B82F6'
      },
      newNode: {
        title: '',
        description: '',
        status: 'planning',
        color: '#3B82F6',
        position_x: 100,
        position_y: 100
      },
      zoom: 1,
      panX: 0,
      panY: 0,
      isDragging: false,
      dragNode: null,
      dragOffset: { x: 0, y: 0 },
      isPanning: false,
      panStart: { x: 0, y: 0 }
    };
  },
  methods: {
    toggleConnectionMode() {
      this.connectionMode = !this.connectionMode;
      if (!this.connectionMode) {
        this.connectingFrom = null;
        this.previewConnection = null;
      }
    },
    
    async createNode() {
      const canvasRect = document.querySelector('.flow-canvas-container').getBoundingClientRect();
      this.newNode.position_x = (canvasRect.width / 2) / this.zoom - this.panX;
      this.newNode.position_y = (canvasRect.height / 2) / this.zoom - this.panY;

      try {
        const response = await axios.post(`/businesses/${this.businessId}/nodes`, this.newNode);
        if (response.data.success) {
          this.nodes.push(response.data.node);
          this.showAddNodeModal = false;
          this.newNode = {
            title: '',
            description: '',
            status: 'planning',
            color: '#3B82F6',
            position_x: 100,
            position_y: 100
          };
        }
      } catch (error) {
        console.error('Error creating node:', error);
        alert('Failed to create node. Please try again.');
      }
    },

    editNode(node) {
      this.editingNode = node;
      this.editForm = {
        title: node.title,
        description: node.description || '',
        status: node.status,
        color: node.color
      };
    },

    async saveNode() {
      if (!this.editingNode) return;

      try {
        const response = await axios.put(
          `/businesses/${this.businessId}/nodes/${this.editingNode.id}`,
          this.editForm
        );
        if (response.data.success) {
          const index = this.nodes.findIndex(n => n.id === this.editingNode.id);
          if (index !== -1) {
            this.nodes[index] = response.data.node;
          }
          this.cancelEdit();
        }
      } catch (error) {
        console.error('Error updating node:', error);
        alert('Failed to update node. Please try again.');
      }
    },

    cancelEdit() {
      this.editingNode = null;
      this.editForm = {
        title: '',
        description: '',
        status: 'planning',
        color: '#3B82F6'
      };
    },

    async deleteNode(node) {
      if (!confirm('Are you sure you want to delete this node? All connections will be removed.')) {
        return;
      }

      try {
        const response = await axios.delete(`/businesses/${this.businessId}/nodes/${node.id}`);
        if (response.data.success) {
          this.nodes = this.nodes.filter(n => n.id !== node.id);
          this.edges = this.edges.filter(e => 
            e.from_node_id !== node.id && e.to_node_id !== node.id
          );
        }
      } catch (error) {
        console.error('Error deleting node:', error);
        alert('Failed to delete node. Please try again.');
      }
    },

    handleNodeClick(node, event) {
      console.log('Node clicked:', node.id, 'Connection mode:', this.connectionMode);
      
      if (this.connectionMode) {
        event.preventDefault();
        event.stopPropagation();
        
        if (!this.connectingFrom) {
          // First click - select source node
          this.connectingFrom = node;
          console.log('Source node selected:', node.id);
          // Start preview connection
          const canvas = document.querySelector('.flow-canvas-container');
          const rect = canvas.getBoundingClientRect();
          const canvasX = (rect.width / 2) / this.zoom - this.panX;
          const canvasY = (rect.height / 2) / this.zoom - this.panY;
          this.previewConnection = {
            x: canvasX,
            y: canvasY
          };
        } else if (this.connectingFrom.id !== node.id) {
          // Second click - create connection
          console.log('Creating connection from', this.connectingFrom.id, 'to', node.id);
          this.createConnection(this.connectingFrom, node);
        } else {
          // Clicked same node, cancel connection
          console.log('Same node clicked, canceling connection');
          this.connectingFrom = null;
          this.previewConnection = null;
        }
      } else {
        // Normal click - do nothing or could add selection highlight
      }
    },
    
    selectNode(node) {
      // Alias for backwards compatibility
      this.handleNodeClick(node, { preventDefault: () => {}, stopPropagation: () => {} });
    },
    
    handleHandleHover(node, type) {
      // Visual feedback when hovering over connection handles
    },
    
    handleHandleLeave() {
      // Remove hover feedback
    },
    
    handleContextMenu(event) {
      // Right-click to cancel connection mode
      if (this.connectionMode) {
        this.connectionMode = false;
        this.connectingFrom = null;
        this.previewConnection = null;
      }
    },

    async createConnection(fromNode, toNode) {
      console.log('createConnection called', { from: fromNode.id, to: toNode.id });
      
      // Check if connection already exists
      const exists = this.edges.some(e => 
        e.from_node_id === fromNode.id && e.to_node_id === toNode.id
      );

      if (exists) {
        alert('Connection already exists');
        this.connectingFrom = null;
        this.previewConnection = null;
        this.connectionMode = false;
        return;
      }

      try {
        console.log('Sending connection request to:', `/businesses/${this.businessId}/edges`);
        const response = await axios.post(`/businesses/${this.businessId}/edges`, {
          from_node_id: fromNode.id,
          to_node_id: toNode.id
        });
        console.log('Connection response:', response.data);
        
        if (response.data.success) {
          this.edges.push(response.data.edge);
          console.log('Connection created successfully, edges now:', this.edges);
        } else {
          console.error('Connection creation failed:', response.data);
          alert('Failed to create connection');
        }
      } catch (error) {
        console.error('Error creating connection:', error);
        console.error('Error details:', error.response?.data);
        if (error.response?.data?.error) {
          alert(error.response.data.error);
        } else {
          alert('Failed to create connection. Please try again. Check console for details.');
        }
      }

      this.connectingFrom = null;
      this.previewConnection = null;
      this.connectionMode = false;
    },

    async deleteConnection(edge) {
      if (!confirm('Delete this connection?')) return;

      try {
        const response = await axios.delete(`/businesses/${this.businessId}/edges/${edge.id}`);
        if (response.data.success) {
          this.edges = this.edges.filter(e => e.id !== edge.id);
        }
      } catch (error) {
        console.error('Error deleting connection:', error);
        alert('Failed to delete connection. Please try again.');
      }
    },

    startDrag(node, event) {
      if (this.connectionMode) {
        // Don't start dragging in connection mode
        event.preventDefault();
        event.stopPropagation();
        return;
      }
      
      this.isDragging = true;
      this.dragNode = node;
      const rect = document.querySelector('.flow-canvas-container').getBoundingClientRect();
      this.dragOffset = {
        x: event.clientX - rect.left - (node.position_x * this.zoom) - this.panX,
        y: event.clientY - rect.top - (node.position_y * this.zoom) - this.panY
      };
    },

    handleMouseMove(event) {
      if (this.isDragging && this.dragNode) {
        const canvas = document.querySelector('.flow-canvas-container');
        const rect = canvas.getBoundingClientRect();
        const x = (event.clientX - rect.left - this.dragOffset.x) / this.zoom - this.panX;
        const y = (event.clientY - rect.top - this.dragOffset.y) / this.zoom - this.panY;
        
        this.dragNode.position_x = Math.max(0, x);
        this.dragNode.position_y = Math.max(0, y);
      } else if (this.isPanning) {
        this.panX += (event.clientX - this.panStart.x) / this.zoom;
        this.panY += (event.clientY - this.panStart.y) / this.zoom;
        this.panStart = { x: event.clientX, y: event.clientY };
      } else if (this.connectionMode && this.connectingFrom) {
        // Update preview connection line
        const canvas = document.querySelector('.flow-canvas-container');
        const rect = canvas.getBoundingClientRect();
        const canvasX = (event.clientX - rect.left) / this.zoom - this.panX;
        const canvasY = (event.clientY - rect.top) / this.zoom - this.panY;
        this.previewConnection = { x: canvasX, y: canvasY };
      }
    },

    handleMouseDown(event) {
      if (event.target.classList.contains('flow-canvas-container') || 
          event.target.closest('.flow-canvas-container') === event.currentTarget) {
        this.isPanning = true;
        this.panStart = { x: event.clientX, y: event.clientY };
      }
    },

    handleMouseUp() {
      if (this.isDragging && this.dragNode) {
        // Save position
        this.updateNodePosition(this.dragNode);
      }
      this.isDragging = false;
      this.dragNode = null;
      this.isPanning = false;
    },

    async updateNodePosition(node) {
      try {
        await axios.put(`/businesses/${this.businessId}/nodes/${node.id}`, {
          position_x: node.position_x,
          position_y: node.position_y
        });
      } catch (error) {
        console.error('Error updating node position:', error);
      }
    },

    handleCanvasClick(event) {
      if (this.connectionMode && this.connectingFrom) {
        // Cancel connection if clicking on empty canvas
        if (!event.target.closest('.flow-node')) {
          this.connectingFrom = null;
          this.previewConnection = null;
          this.connectionMode = false;
        }
      }
    },

    // Get connection start point (right edge of source node)
    getConnectionStartX(nodeId) {
      const node = this.nodes.find(n => n.id === nodeId);
      if (!node) return 0;
      // Node width is approximately 200-250px, so right edge is at position_x + 200
      return node.position_x + 200;
    },

    getConnectionStartY(nodeId) {
      const node = this.nodes.find(n => n.id === nodeId);
      if (!node) return 0;
      // Connection point is at middle of node (approximately 50px from top)
      return node.position_y + 50;
    },

    // Get connection end point (left edge of target node)
    getConnectionEndX(nodeId) {
      const node = this.nodes.find(n => n.id === nodeId);
      if (!node) return 0;
      // Left edge is at position_x
      return node.position_x;
    },

    getConnectionEndY(nodeId) {
      const node = this.nodes.find(n => n.id === nodeId);
      if (!node) return 0;
      // Connection point is at middle of node
      return node.position_y + 50;
    },

    zoomIn() {
      this.zoom = Math.min(this.zoom + 0.1, 2);
    },

    zoomOut() {
      this.zoom = Math.max(this.zoom - 0.1, 0.5);
    },

    formatStatus(status) {
      const statusMap = {
        planning: 'Planning',
        in_progress: 'In Progress',
        completed: 'Completed'
      };
      return statusMap[status] || status;
    },

    getStatusClass(status) {
      const classes = {
        planning: 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
        in_progress: 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
        completed: 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200'
      };
      return classes[status] || classes.planning;
    }
  }
};
</script>

<style scoped>
.flow-node {
  user-select: none;
}

.connection-line {
  transition: stroke 0.2s, stroke-width 0.2s;
}

.connection-handle {
  transition: all 0.2s;
  z-index: 10;
}

.connection-handle:hover {
  transform: translateY(-50%) scale(1.3);
  box-shadow: 0 0 8px rgba(59, 130, 246, 0.6);
  z-index: 20;
}

.output-handle:hover {
  transform: translateY(-50%) scale(1.3);
}

.input-handle:hover {
  transform: translateY(-50%) scale(1.3);
}

.connection-preview {
  animation: dash 1s linear infinite;
}

@keyframes dash {
  to {
    stroke-dashoffset: -10;
  }
}

.flow-canvas-container {
  background-image: 
    linear-gradient(rgba(0, 0, 0, 0.05) 1px, transparent 1px),
    linear-gradient(90deg, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
  background-size: 20px 20px;
}

.dark .flow-canvas-container {
  background-image: 
    linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
}
</style>

