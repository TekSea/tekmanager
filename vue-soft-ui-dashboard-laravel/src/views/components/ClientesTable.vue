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
          <option :value="filteredClientes.length">Todos</option>
        </select>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table align-items-center mb-0">
        <thead>
          <tr>
            <th @click="sortTable('id')" :class="getSortClass('id')">ID</th>
            <th @click="sortTable('nome')" :class="getSortClass('nome')">Nome</th>
            <th @click="sortTable('nome_fantasia')" :class="getSortClass('nome_fantasia')">Nome Fantasia</th>
            <th @click="sortTable('uf')" :class="getSortClass('uf')">UF</th>
            <th @click="sortTable('cidade')" :class="getSortClass('cidade')">Cidade</th>
            <th @click="sortTable('representante')" :class="getSortClass('representante')">Representante</th>
            <th @click="sortTable('situacao')" :class="getSortClass('situacao')">Situação</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cliente in paginatedClientes" :key="cliente.id">
            <td>{{ cliente.id }}</td>
            <td>{{ cliente.nome }}</td>
            <td>{{ cliente.nome_fantasia }}</td>
            <td>{{ cliente.uf }}</td>
            <td>{{ cliente.cidade }}</td>
            <td>{{ cliente.representante }}</td>
            <td>
              <span :class="getStatusClass(cliente.situacao)">
                <i :class="getStatusIcon(cliente.situacao)"></i>
                {{ cliente.situacao }}
              </span>
            </td>
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
  name: "ClientesTable",
  props: {
    clientes: {
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
    filteredClientes() {
      return this.clientes.filter(cliente => {
        return (
          cliente.nome.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          cliente.nome_fantasia.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          cliente.uf.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          cliente.cidade.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          cliente.representante.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          cliente.situacao.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      });
    },
    sortedClientes() {
      return [...this.filteredClientes].sort((a, b) => {
        let modifier = 1;
        if (this.currentSortDir === 'desc') modifier = -1;
        if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
        if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
        return 0;
      });
    },
    paginatedClientes() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.sortedClientes.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.sortedClientes.length / this.itemsPerPage);
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
    getStatusClass(situacao) {
      switch (situacao.toLowerCase()) {
        case 'ativo':
          return 'text-success';
        case 'inativo':
          return 'text-danger';
        case 'pendente':
          return 'text-warning';
        default:
          return 'text-muted';
      }
    },
    getStatusIcon(situacao) {
      switch (situacao.toLowerCase()) {
        case 'ativo':
          return 'fas fa-circle';
        case 'inativo':
          return 'fas fa-times-circle';
        case 'pendente':
          return 'fas fa-exclamation-circle';
        default:
          return 'fas fa-question-circle';
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

.text-success {
  color: #28a745 !important;
}

.text-danger {
  color: #dc3545 !important;
}

.text-warning {
  color: #ffc107 !important;
}

.text-muted {
  color: #6c757d !important;
}

.fas.fa-circle,
.fas.fa-times-circle,
.fas.fa-exclamation-circle,
.fas.fa-question-circle {
  margin-right: 8px;
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
