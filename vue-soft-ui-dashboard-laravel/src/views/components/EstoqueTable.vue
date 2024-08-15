<template>
    <div class="container">
      <div class="row mb-3">
        <div class="col-md-6">
          <input
            type="text"
            v-model="searchQuery"
            class="form-control"
            placeholder="Buscar..."
          />
        </div>
        <div class="col-md-6 text-end">
          <label for="itemsPerPageSelect" class="me-2">Registros por página:</label>
          <select
            id="itemsPerPageSelect"
            v-model.number="itemsPerPage"
            class="form-select d-inline-block w-auto"
          >
            <option value="10">10</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="1000">1000</option>
            <option :value="filteredEstoque.length">Todos</option>
          </select>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th @click="sortTable('id')" :class="getSortClass('id')">ID</th>
              <th @click="sortTable('ref_sistema')" :class="getSortClass('ref_sistema')">Ref. Sistema</th>
              <th @click="sortTable('ncm')" :class="getSortClass('ncm')">NCM</th>
              <th @click="sortTable('produto')" :class="getSortClass('produto')">Produto</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in paginatedEstoque" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ item.ref_sistema }}</td>
              <td>{{ item.ncm }}</td>
              <td>{{ item.produto }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="pagination-container">
        <button
          class="btn btn-primary"
          :disabled="currentPage === 1"
          @click="prevPage"
        >
          Anterior
        </button>
        <span>Página {{ currentPage }} de {{ totalPages }}</span>
        <button
          class="btn btn-primary"
          :disabled="currentPage === totalPages"
          @click="nextPage"
        >
          Próxima
        </button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "EstoqueTable",
    props: {
      estoque: {
        type: Array,
        required: true,
      },
    },
    data() {
      return {
        currentSort: 'id',
        currentSortDir: 'asc',
        searchQuery: '',
        currentPage: 1,
        itemsPerPage: 10, // Número de itens por página padrão
      };
    },
    computed: {
      filteredEstoque() {
        return this.estoque.filter(item => {
          const refSistema = item.ref_sistema ? item.ref_sistema.toLowerCase() : '';
          const ncm = item.ncm ? item.ncm.toLowerCase() : '';
          const produto = item.produto ? item.produto.toLowerCase() : '';
  
          return (
            refSistema.includes(this.searchQuery.toLowerCase()) ||
            ncm.includes(this.searchQuery.toLowerCase()) ||
            produto.includes(this.searchQuery.toLowerCase())
          );
        });
      },
      sortedEstoque() {
        return [...this.filteredEstoque].sort((a, b) => {
          let modifier = 1;
          if (this.currentSortDir === 'desc') modifier = -1;
          if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
          if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
          return 0;
        });
      },
      paginatedEstoque() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.sortedEstoque.slice(start, end);
      },
      totalPages() {
        return Math.ceil(this.sortedEstoque.length / this.itemsPerPage);
      },
    },
    methods: {
      sortTable(column) {
        if (this.currentSort === column) {
          this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
        } else {
          this.currentSort = column;
          this.currentSortDir = 'asc';
        }
      },
      getSortClass(column) {
        if (this.currentSort === column) {
          return this.currentSortDir === 'asc' ? 'sorting-asc' : 'sorting-desc';
        }
        return 'sorting';
      },
      handleItemsPerPageChange() {
        this.currentPage = 1; // Resetar para a primeira página quando o número de itens por página mudar
      },
      prevPage() {
        if (this.currentPage > 1) {
          this.currentPage--;
        }
      },
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.currentPage++;
        }
      },
    },
    watch: {
      currentPage(newPage) {
        if (newPage > this.totalPages) {
          this.currentPage = this.totalPages;
        } else if (newPage < 1) {
          this.currentPage = 1;
        }
      },
      itemsPerPage() {
        this.handleItemsPerPageChange();
      },
      searchQuery() {
        this.currentPage = 1; // Resetar para a primeira página ao realizar uma busca
      }
    },
  };
  </script>
  
  <style scoped>
  .table-responsive {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    border-radius: 8px;
    overflow-x: auto;
  }
  
  .table {
    margin-bottom: 0;
  }
  
  th {
    background-color: #f8f9fa;
    text-transform: uppercase;
    font-weight: bold;
    color: #6c757d;
    border-bottom: 2px solid #dee2e6;
    cursor: pointer;
  }
  
  th.sorting-asc::after,
  th.sorting-desc::after {
    content: '';
    margin-left: 8px;
    border: solid transparent;
    border-width: 0 4px 4px 4px;
  }
  
  th.sorting-asc::after {
    border-bottom-color: #6c757d;
  }
  
  th.sorting-desc::after {
    border-width: 4px 4px 0 4px;
    border-top-color: #6c757d;
  }
  
  td {
    padding: 16px;
    border-bottom: 1px solid #dee2e6;
  }
  
  .form-control {
    max-width: 300px;
    display: inline-block;
    width: auto;
  }
  
  .form-select {
    display: inline-block;
    width: auto;
    min-width: 150px; /* Aumenta a largura do seletor em 50% */
  }
  
  .pagination-container {
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .pagination-container button {
    min-width: 100px;
  }
  </style>
  