<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- Cabeçalho do Card -->
          <div class="pb-0 card-header">
            <div class="d-lg-flex">
              <div>
                <h5 class="mb-0">Rastreabilidade de Produtos</h5>
              </div>
              <div class="my-auto mt-4 ms-auto mt-lg-0">
                <div class="my-auto ms-auto">
                  <a @click="openAddModal" class="mb-0 btn bg-gradient-success btn-sm">
                    +&nbsp; Novo Registro
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Corpo do Card -->
          <div class="px-4 pb-4 card-body">
            <vue-good-table :columns="columns" :rows="rastreabilidades" :search-options="{ enabled: true }"
              :pagination-options="{ enabled: true, perPageDropdown: [10, 25, 50, 100] }">
              <template v-slot:table-row="props">
                <span v-if="props.column.field === 'actions'">
                  <tippy content="Editar">
                    <font-awesome-icon icon="edit" class="text-primary cursor-pointer"
                      @click="openEditModal(props.row.id)" />
                  </tippy>

                  <tippy content="Excluir">
                    <font-awesome-icon icon="trash" class="text-danger cursor-pointer ms-3"
                      @click="deleteRastreabilidade(props.row.id)" />
                  </tippy>
                </span>
                <span v-else>{{ props.formattedRow[props.column.field] }}</span>
              </template>
            </vue-good-table>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal para Edição ou Adição -->
    <EditarRastreabilidadeModal
      v-model="isModalVisible"
      :id="editingId"
      @saved="fetchRastreabilidades"
    />
  </div>
</template>

<script>
import axios from "axios";
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import EditarRastreabilidadeModal from "./components/EditarRastreabilidadeModal.vue";

export default {
  name: "Rastreabilidade",
  components: {
    VueGoodTable,
    EditarRastreabilidadeModal,
  },
  data() {
    return {
      rastreabilidades: [],
      isModalVisible: false,
      editingId: null,
      columns: [
        { label: "ID", field: "id", sortable: true },
        { label: "Número de Série", field: "numero_serie", sortable: true },
        { label: "Produto", field: "produto", sortable: true },
        { label: "OP", field: "op", sortable: true },
        { label: "Data de Envio", field: "data_enviado", sortable: true },
        { label: "Garantia (dias)", field: "garantia_dias", sortable: true },
        { label: "Status da Garantia", field: "status_garantia", sortable: true },
        { label: "Ações", field: "actions" },
      ],
    };
  },
  methods: {
    fetchRastreabilidades() {
      axios
        .get(`${process.env.VUE_APP_API_BASE_URL}/rastreabilidade_friendly`)
        .then((response) => {
          this.rastreabilidades = response.data;
        })
        .catch((error) => {
          console.error("Erro ao buscar rastreabilidades:", error);
        });
    },
    openAddModal() {
      this.editingId = null;
      this.isModalVisible = true;
    },
    openEditModal(id) {
      this.editingId = id;
      this.isModalVisible = true;
    },
    deleteRastreabilidade(id) {
      axios
        .delete(`${process.env.VUE_APP_API_BASE_URL}/rastreabilidades/${id}`)
        .then(() => {
          this.fetchRastreabilidades();
        })
        .catch((error) => {
          console.error("Erro ao excluir registro de rastreabilidade:", error);
        });
    },
  },
  mounted() {
    this.fetchRastreabilidades();
  },
};
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>
