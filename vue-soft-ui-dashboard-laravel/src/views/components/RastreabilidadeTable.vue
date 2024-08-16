<template>
  <div>
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
          <option :value="filteredRastreabilidades.length">Todos</option>
        </select>
      </div>
    </div>
    <div class="table-responsive">
      <table id="rastreabilidade-list" ref="rastreabilidadeList" class="table table-flush">
        <thead class="thead-light">
          <tr>
            <th @click="sortTable('numero_serie')" :class="getSortClass('numero_serie')">Número de Série</th>
            <th @click="sortTable('data_geracao')" :class="getSortClass('data_geracao')">Data de Geração</th>
            <th @click="sortTable('responsavel_criacao')" :class="getSortClass('responsavel_criacao')">Responsável</th>
            <th @click="sortTable('cliente')" :class="getSortClass('cliente')">Cliente</th>
            <th @click="sortTable('produto')" :class="getSortClass('produto')">Produto</th>
            <th @click="sortTable('status_garantia')" :class="getSortClass('status_garantia')">Status da Garantia</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody class="text-sm">
          <tr v-for="rastreabilidade in paginatedRastreabilidades" :key="rastreabilidade.id">
            <td>{{ rastreabilidade.numero_serie }}</td>
            <td>{{ rastreabilidade.data_geracao }}</td>
            <td>{{ rastreabilidade.responsavel_criacao }}</td>
            <td>{{ rastreabilidade.cliente }}</td>
            <td>{{ rastreabilidade.produto }}</td>
            <td>{{ rastreabilidade.status_garantia }}</td>
            <td>
              <a
                @click="editRastreabilidade(rastreabilidade.id)"
                class="actionButton cursor-pointer me-3"
                data-bs-toggle="tooltip"
                title="Editar Registro"
              >
                <i class="fas fa-edit text-secondary"></i>
              </a>
              <a
                @click="deleteRastreabilidade(rastreabilidade.id)"
                class="actionButton deleteButton cursor-pointer"
                data-bs-toggle="tooltip"
                title="Excluir Registro"
              >
                <i class="fas fa-trash text-secondary"></i>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div
      class="d-flex justify-content-center justify-content-sm-between flex-wrap"
      style="padding: 24px 24px 0px"
    >
      <div>
        <p>Mostrando {{ paginatedRastreabilidades.length }} de {{ filteredRastreabilidades.length }} registros</p>
      </div>
      <ul class="pagination pagination-success pagination-md">
        <li class="page-item prev-page" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" @click="prevPage" aria-label="Previous">
            <span aria-hidden="true">
              <i class="fa fa-angle-left" aria-hidden="true"></i>
            </span>
          </a>
        </li>
        <li
          v-for="page in visiblePages"
          :key="page"
          class="page-item"
          :class="{ active: currentPage === page }"
        >
          <a
            class="page-link"
            @click="setPage(page)"
            style="color: gray"
          >
            {{ page }}
          </a>
        </li>
        <li v-if="showEllipsis && currentPage < totalPages" class="page-item">
          <a class="page-link">...</a>
        </li>
        <li class="page-item next-page" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" @click="nextPage" aria-label="Next">
            <span aria-hidden="true">
              <i class="fa fa-angle-right" aria-hidden="true"></i>
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "RastreabilidadeTable",
  props: {
    rastreabilidades: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 10,
      currentSort: 'numero_serie',
      currentSortDir: 'asc',
    };
  },
  computed: {
    filteredRastreabilidades() {
      return this.rastreabilidades.filter(rastreabilidade => {
        const search = this.searchQuery.toLowerCase();
        return (
          (rastreabilidade.numero_serie && rastreabilidade.numero_serie.toString().includes(search)) ||
          (rastreabilidade.data_geracao && rastreabilidade.data_geracao.toLowerCase().includes(search)) ||
          (rastreabilidade.responsavel_criacao && rastreabilidade.responsavel_criacao.toLowerCase().includes(search)) ||
          (rastreabilidade.cliente && rastreabilidade.cliente.includes(search)) ||
          (rastreabilidade.produto && rastreabilidade.produto.includes(search)) ||
          (rastreabilidade.status_garantia && rastreabilidade.status_garantia.toLowerCase().includes(search))
        );
      });
    },
    sortedRastreabilidades() {
      return [...this.filteredRastreabilidades].sort((a, b) => {
        let modifier = 1;
        if (this.currentSortDir === 'desc') modifier = -1;
        if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
        if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
        return 0;
      });
    },
    paginatedRastreabilidades() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.sortedRastreabilidades.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredRastreabilidades.length / this.itemsPerPage);
    },
    visiblePages() {
      const maxVisiblePages = 5;
      const startPage = Math.max(1, this.currentPage - Math.floor(maxVisiblePages / 2));
      const endPage = Math.min(startPage + maxVisiblePages - 1, this.totalPages);
      return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);
    },
    showEllipsis() {
      return this.totalPages > this.visiblePages.length;
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
    setPage(page) {
      this.currentPage = page;
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
    editRastreabilidade(id) {
      // Lógica para editar o registro de rastreabilidade
      console.log("Editar rastreabilidade:", id);
    },
    deleteRastreabilidade(id) {
      // Lógica para excluir o registro de rastreabilidade
      console.log("Excluir rastreabilidade:", id);
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

.card-body {
  padding: 24px;
}

.table thead th {
  cursor: pointer;
}

.table thead th.sorting-asc::after,
.table thead th.sorting-desc::after {
  content: '';
  margin-left: 8px;
  border: solid transparent;
  border-width: 0 4px 4px 4px;
}

.table thead th.sorting-asc::after {
  border-bottom-color: #6c757d;
}

.table thead th.sorting-desc::after {
  border-width: 4px 4px 0 4px;
  border-top-color: #6c757d;
}

td {
  padding: 12px 24px !important;
}

.form-control {
  max-width: 300px;
  display: inline-block;
  width: auto;
}

.form-select {
  display: inline-block;
  width: auto;
  min-width: 150px;
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

.page-item .page-link {
  color: #6c757d;
}

.page-item.active .page-link {
  background-color: #007bff;
  border-color: #007bff;
}
</style>

