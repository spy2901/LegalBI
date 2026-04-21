// Dashboard Layout Manager
class DashboardLayoutManager {
  constructor() {
    this.isEditMode = false;
    this.containerSelector = '.dashboard-container';
    this.itemSelector = '[data-layout-item]';
    this.draggedElement = null;
    this.init();
  }

  init() {
    this.loadUserLayout();
    this.setupEditModeToggle();
  }

  setupEditModeToggle() {
    const editBtn = document.getElementById('layoutEditBtn');
    const saveBtn = document.getElementById('layoutSaveBtn');
    const resetBtn = document.getElementById('layoutResetBtn');

    if (editBtn) {
      editBtn.addEventListener('click', () => this.toggleEditMode());
    }
    if (saveBtn) {
      saveBtn.addEventListener('click', () => this.saveLayout());
    }
    if (resetBtn) {
      resetBtn.addEventListener('click', () => this.resetLayout());
    }
  }

  toggleEditMode() {
    this.isEditMode = !this.isEditMode;
    const editBtn = document.getElementById('layoutEditBtn');

    if (this.isEditMode) {
      editBtn.classList.add('active');
      editBtn.innerHTML = '<i class="fa-solid fa-lock-open"></i> Exit Edit Mode';
      this.enableDragAndDrop();
      this.showLayoutControls();
    } else {
      editBtn.classList.remove('active');
      editBtn.innerHTML = '<i class="fa-solid fa-lock"></i> Edit Layout';
      this.disableDragAndDrop();
      this.hideLayoutControls();
    }
  }

  enableDragAndDrop() {
    const items = document.querySelectorAll(this.itemSelector);
    items.forEach(item => {
      item.setAttribute('draggable', 'true');
      item.classList.add('draggable-item');
      item.style.cursor = 'move';

      item.removeEventListener('dragstart', this.handleDragStart.bind(this));
      item.removeEventListener('dragover', this.handleDragOver.bind(this));
      item.removeEventListener('drop', this.handleDrop.bind(this));
      item.removeEventListener('dragend', this.handleDragEnd.bind(this));

      item.addEventListener('dragstart', (e) => this.handleDragStart(e));
      item.addEventListener('dragover', (e) => this.handleDragOver(e));
      item.addEventListener('drop', (e) => this.handleDrop(e));
      item.addEventListener('dragend', (e) => this.handleDragEnd(e));
    });
  }

  disableDragAndDrop() {
    const items = document.querySelectorAll(this.itemSelector);
    items.forEach(item => {
      item.removeAttribute('draggable');
      item.classList.remove('draggable-item', 'dragging', 'drag-over');
      item.style.cursor = 'default';
    });
  }

  handleDragStart(e) {
    this.draggedElement = e.currentTarget;
    e.dataTransfer.effectAllowed = 'move';
    e.currentTarget.classList.add('dragging');
  }


  handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
  }

  handleDrop(e) {
    e.preventDefault();
    
    if (!this.draggedElement || this.draggedElement === e.currentTarget) {
      return;
    }

    const parent = e.currentTarget.parentNode;
    
    if (e.currentTarget.compareDocumentPosition(this.draggedElement) === Node.DOCUMENT_POSITION_FOLLOWING) {
      e.currentTarget.parentNode.insertBefore(this.draggedElement, e.currentTarget);
    } else {
      e.currentTarget.parentNode.insertBefore(this.draggedElement, e.currentTarget.nextSibling);
    }
  }

  handleDragEnd(e) {
    e.currentTarget.classList.remove('dragging');
    document.querySelectorAll('.drag-over').forEach(el => {
      el.classList.remove('drag-over');
    });
    this.draggedElement = null;
  }

  showLayoutControls() {
    const saveBtn = document.getElementById('layoutSaveBtn');
    const resetBtn = document.getElementById('layoutResetBtn');
    if (saveBtn) saveBtn.style.display = 'inline-block';
    if (resetBtn) resetBtn.style.display = 'inline-block';
  }

  hideLayoutControls() {
    const saveBtn = document.getElementById('layoutSaveBtn');
    const resetBtn = document.getElementById('layoutResetBtn');
    if (saveBtn) saveBtn.style.display = 'none';
    if (resetBtn) resetBtn.style.display = 'none';
  }

  getLayoutOrder() {
    const layout = {
      kpi_items: [],
      chart_items: []
    };

    // Get KPI items order
    const kpiRow = document.querySelector('.kpi-row');
    if (kpiRow) {
      const kpiItems = kpiRow.querySelectorAll('[data-layout-item]');
      kpiItems.forEach(item => {
        layout.kpi_items.push(item.getAttribute('data-layout-item'));
      });
    }

    // Get chart items order
    const chartsRow = document.querySelector('.charts-row');
    if (chartsRow) {
      const chartItems = chartsRow.querySelectorAll('[data-layout-item]');
      chartItems.forEach(item => {
        layout.chart_items.push(item.getAttribute('data-layout-item'));
      });
    }

    return layout;
  }

  saveLayout() {
    const layout = this.getLayoutOrder();
    console.log('Saving layout:', layout);

    fetch(`${BASE_URL}includes/layout_api.php?action=save`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ layout: layout })
    })
    .then(response => response.json())
    .then(data => {
      console.log('Save response:', data);
      if (data.success) {
        alert('Layout saved successfully!');
        this.toggleEditMode();
      } else {
        alert('Error: ' + (data.error || 'Unknown error'));
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Failed to save layout');
    });
  }

  loadUserLayout() {
    // Wait for DOM to be fully loaded
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.fetchAndApplyLayout());
    } else {
      this.fetchAndApplyLayout();
    }
  }

  fetchAndApplyLayout() {
    fetch(`${BASE_URL}includes/layout_api.php?action=get`)
      .then(response => response.json())
      .then(data => {
        if (data.layout) {
          // Add small delay to ensure all elements are rendered
          setTimeout(() => this.applyLayout(data.layout), 100);
        }
      })
      .catch(error => console.error('Error loading layout:', error));
  }

  applyLayout(layout) {
    const kpiRow = document.querySelector('.kpi-row');
    const chartsRow = document.querySelector('.charts-row');

    // Reorder KPI items
    if (layout.kpi_items && kpiRow) {
      const kpiMap = new Map();
      const allKpiItems = kpiRow.querySelectorAll('[data-layout-item]');
      
      allKpiItems.forEach(item => {
        kpiMap.set(item.getAttribute('data-layout-item'), item);
      });

      layout.kpi_items.forEach(itemId => {
        const item = kpiMap.get(itemId);
        if (item) {
          kpiRow.appendChild(item);
        }
      });
    }

    // Reorder chart items
    if (layout.chart_items && chartsRow) {
      const chartMap = new Map();
      const allChartItems = chartsRow.querySelectorAll('[data-layout-item]');
      
      allChartItems.forEach(item => {
        chartMap.set(item.getAttribute('data-layout-item'), item);
      });

      layout.chart_items.forEach(itemId => {
        const item = chartMap.get(itemId);
        if (item) {
          chartsRow.appendChild(item);
        }
      });
    }
  }

  resetLayout() {
    if (!confirm('Are you sure you want to reset to default layout?')) return;

    fetch(`${BASE_URL}includes/layout_api.php?action=reset`, {
      method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Layout reset successfully!');
        location.reload();
      } else {
        alert('Error: ' + (data.error || 'Unknown error'));
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Failed to reset layout');
    });
  }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  window.layoutManager = new DashboardLayoutManager();
});
