<template>
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
        <tr v-for="cliente in sortedClientes" :key="cliente.id">
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
    };
  },
  computed: {
    sortedClientes() {
      return [...this.clientes].sort((a, b) => {
        let modifier = 1;
        if (this.currentSortDir === 'desc') modifier = -1;
        if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
        if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
        return 0;
      });
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
</style>
