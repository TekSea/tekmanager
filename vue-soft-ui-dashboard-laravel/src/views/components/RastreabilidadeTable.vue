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
            <option :value="filteredRastreabilidade.length">Todos</option>
          </select>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th @click="sortTable('id')" :class="getSortClass('id')">ID</th>
              <th @click="sortTable('numero_serie')" :class="getSortClass('numero_serie')">Número de Série</th>
              <th @click="sortTable('data_geracao')" :class="getSortClass('data_geracao')">Data de Geração</th>
              <th @click="sortTable('responsavel_criacao')" :class="getSortClass('responsavel_criacao')">Responsável</th>
              <th @click="sortTable('cliente_id')" :class="getSortClass('cliente_id')">Cliente ID</th>
              <th @click="sortTable('estoque_id')" :class="getSortClass('estoque_id')">Estoque ID</th>
              <th @click="sortTable('pv')" :class="getSortClass('pv')">PV</th>
              <th @click="sortTable('op')" :class="getSortClass('op')">OP</th>
              <th @click="sortTable('codigo_net')" :class="getSortClass('codigo_net')">Código NET</th>
              <th @click="sortTable('ref_sistema')" :class="getSortClass('ref_sistema')">Ref. Sistema</th>
              <th @click="sortTable('produto')" :class="getSortClass('produto')">Produto</th>
              <th @click="sortTable('obra_alocada')" :class="getSortClass('obra_alocada')">Obra Alocada</th>
              <th @click="sortTable('n_fatura')" :class="getSortClass('n_fatura')">Nº Fatura</th>
              <th @click="sortTable('data_enviado')" :class="getSortClass('data_enviado')">Data Enviado</th>
              <th @click="sortTable('garantia_dias')" :class="getSortClass('garantia_dias')">Garantia (dias)</th>
              <th @click="sortTable('expira_garantia')" :class="getSortClass('expira_garantia')">Expira Garantia</th>
              <th @click="sortTable('status_garantia')" :class="getSortClass('status_garantia')">Status da Garantia</th>
              <th @click="sortTable('condicao_garantia')" :class="getSortClass('condicao_garantia')">Condição da Garantia</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in paginatedRastreabilidade" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ item.numero_serie }}</td>
              <td>{{ item.data_geracao }}</td>
              <td>{{ item.responsavel_criacao }}</td>
              <td>{{ item.cliente_id }}</td>
              <td>{{ item.estoque_id }}</td>
              <td>{{ item.pv }}</td>
              <td>{{ item.op }}</td>
              <td>{{ item.codigo_net }}</td>
              <td>{{ item.ref_sistema }}</td>
              <td>{{ item.produto }}</td>
              <td>{{ item.obra_alocada }}</td>
              <td>{{ item.n_fatura }}</td>
              <td>{{ item.data_enviado }}</td>
              <td>{{ item.garantia_dias }}</td>
              <td>{{ item.expira_garantia }}</td>
              <td>{{ item.status_garantia }}</td>
              <td>{{ item.condicao_garantia }}</td>
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
    name: "RastreabilidadeTable",
    props: {
      rastreabilidade: {
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
      filteredRastreabilidade() {
        return this.rastreabilidade.filter(item => {
          const numeroSerie = item.numero_serie ? item.numero_serie.toString() : '';
          const dataGeracao = item.data_geracao ? item.data_geracao.toString() : '';
          const responsavelCriacao = item.responsavel_criacao ? item.responsavel_criacao.toLowerCase() : '';
          const clienteId = item.cliente_id ? item.cliente_id.toString() : '';
          const estoqueId = item.estoque_id ? item.estoque_id.toString() : '';
          const pv = item.pv ? item.pv.toLowerCase() : '';
          const op = item.op ? item.op.toLowerCase() : '';
          const codigoNet = item.codigo_net ? item.codigo_net.toString() : '';
          const refSistema = item.ref_sistema ? item.ref_sistema.toLowerCase() : '';
          const produto = item.produto ? item.produto.toLowerCase() : '';
          const obraAlocada = item.obra_alocada ? item.obra_alocada.toLowerCase() : '';
          const nfatura = item.n_fatura ? item.n_fatura.toLowerCase() : '';
          const dataEnviado = item.data_enviado ? item.data_enviado.toString() : '';
          const garantiaDias = item.garantia_dias ? item.garantia_dias.toString() : '';
          const expiraGarantia = item.expira_garantia ? item.expira_garantia.toString() : '';
          const statusGarantia = item.status_garantia ? item.status_garantia.toLowerCase() : '';
          const condicaoGarantia = item.condicao_garantia ? item.condicao_garantia.toLowerCase() : '';
  
          return (
            numeroSerie.includes(this.searchQuery.toLowerCase()) ||
            dataGeracao.includes(this.searchQuery.toLowerCase()) ||
            responsavelCriacao.includes(this.searchQuery.toLowerCase()) ||
            clienteId.includes(this.searchQuery.toLowerCase()) ||
            estoqueId.includes(this.searchQuery.toLowerCase()) ||
            pv.includes(this.searchQuery.toLowerCase()) ||
            op.includes(this.searchQuery.toLowerCase()) ||
            codigoNet.includes(this.searchQuery.toLowerCase()) ||
            refSistema.includes(this.searchQuery.toLowerCase()) ||
            produto.includes(this.searchQuery.toLowerCase()) ||
            obraAlocada.includes(this.searchQuery.toLowerCase()) ||
            nfatura.includes(this.searchQuery.toLowerCase()) ||
            dataEnviado.includes(this.searchQuery.toLowerCase()) ||
            garantiaDias.includes(this.searchQuery.toLowerCase()) ||
            expiraGarantia.includes(this.searchQuery.toLowerCase()) ||
            statusGarantia.includes(this.searchQuery.toLowerCase()) ||
            condicaoGarantia.includes(this.searchQuery.toLowerCase())
          );
        });
      },
      sortedRastreabilidade() {
        return [...this.filteredRastreabilidade].sort((a, b) => {
          let modifier = 1;
          if (this.currentSortDir === 'desc') modifier = -1;
          if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
          if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
          return 0;
        });
      },
      paginatedRastreabilidade() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.sortedRastreabilidade.slice(start, end);
      },
      totalPages() {
      return Math.ceil(this.sortedRastreabilidade.length / this.itemsPerPage);
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

  