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
                  <a @click="addRastreabilidade" class="mb-0 btn bg-gradient-success btn-sm">
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
                      @click="editRastreabilidade(props.row.id)" />
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

    <!-- Modal para Edição -->
    <el-dialog v-model="isModalVisible" title="Editar Rastreabilidade" width="600px">
      <el-form label-width="200px">
        <el-form-item label="Número de Série">
          <el-input v-model="selectedRastreabilidade.numero_serie"></el-input>
        </el-form-item>
        <el-form-item label="Data de Geração">
          <el-date-picker v-model="selectedRastreabilidade.data_geracao" type="date"></el-date-picker>
        </el-form-item>
        <el-form-item label="Responsável pela Criação">
          <el-input v-model="selectedRastreabilidade.responsavel_criacao"></el-input>
        </el-form-item>
        <el-form-item label="Cliente">
          <el-input v-model="selectedRastreabilidade.cliente_id"></el-input>
        </el-form-item>
        <el-form-item label="Estoque">
          <el-input v-model="selectedRastreabilidade.estoque_id"></el-input>
        </el-form-item>
        <el-form-item label="PV">
          <el-input v-model="selectedRastreabilidade.pv"></el-input>
        </el-form-item>
        <el-form-item label="Ordem de Produção">
          <el-input v-model="selectedRastreabilidade.op"></el-input>
        </el-form-item>
        <el-form-item label="Código NET">
          <el-input v-model="selectedRastreabilidade.codigo_net"></el-input>
        </el-form-item>
        <el-form-item label="Referência do Sistema">
          <el-input v-model="selectedRastreabilidade.ref_sistema"></el-input>
        </el-form-item>
        <el-form-item label="Produto">
          <el-input v-model="selectedRastreabilidade.produto"></el-input>
        </el-form-item>
        <el-form-item label="Obra Alocada">
          <el-input v-model="selectedRastreabilidade.obra_alocada"></el-input>
        </el-form-item>
        <el-form-item label="Número da Fatura">
          <el-input v-model="selectedRastreabilidade.n_fatura"></el-input>
        </el-form-item>
        <el-form-item label="Data de Envio">
          <el-date-picker v-model="selectedRastreabilidade.data_enviado" type="date"></el-date-picker>
        </el-form-item>
        <el-form-item label="Garantia (dias)">
          <el-input v-model="selectedRastreabilidade.garantia_dias"></el-input>
        </el-form-item>
        <el-form-item label="Expira Garantia">
          <el-date-picker v-model="selectedRastreabilidade.expira_garantia" type="date"></el-date-picker>
        </el-form-item>
        <el-form-item label="Status da Garantia">
          <el-input v-model="selectedRastreabilidade.status_garantia"></el-input>
        </el-form-item>
        <el-form-item label="Condição da Garantia">
          <el-input v-model="selectedRastreabilidade.condicao_garantia"></el-input>
        </el-form-item>
      </el-form>
      <template #footer>
        <el-button @click="closeModal">Cancelar</el-button>
        <el-button type="primary" @click="saveChanges">Salvar</el-button>
      </template>
    </el-dialog>
  </div>
</template>

<script>
import axios from "axios";
import { VueGoodTable } from 'vue-good-table-next';
import 'vue-good-table-next/dist/vue-good-table-next.css';

export default {
  name: 'Rastreabilidade',
  components: {
    VueGoodTable,
  },
  data() {
    return {
      rastreabilidades: [],
      selectedRastreabilidade: {}, // Item selecionado para edição
      isModalVisible: false, // Controle de visibilidade do modal
      columns: [
        { label: 'ID', field: 'id', sortable: true },
        { label: 'Número de Série', field: 'numero_serie', sortable: true },
        { label: 'Produto', field: 'produto', sortable: true },
        { label: 'OP', field: 'op', sortable: true },
        { label: 'Data de Envio', field: 'data_enviado', sortable: true },
        { label: 'Garantia (dias)', field: 'garantia_dias', sortable: true },
        { label: 'Status da Garantia', field: 'status_garantia', sortable: true },
        { label: 'Ações', field: 'actions' },
      ],
    };
  },
  mounted() {
    this.fetchRastreabilidades();
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
    addRastreabilidade() {
      this.selectedRastreabilidade = {}; // Limpa os dados para adicionar um novo registro
      this.isModalVisible = true;
    },
    editRastreabilidade(id) {
      const rastreabilidade = this.rastreabilidades.find((item) => item.id === id);
      if (rastreabilidade) {
        this.selectedRastreabilidade = { ...rastreabilidade }; // Clona os dados selecionados
        this.isModalVisible = true;
      }
    },
    deleteRastreabilidade(id) {
      axios
        .delete(`${process.env.VUE_APP_API_BASE_URL}/rastreabilidades/${id}`)
        .then(() => {
          this.fetchRastreabilidades(); // Atualiza a lista após exclusão
        })
        .catch((error) => {
          console.error("Erro ao excluir registro de rastreabilidade:", error);
        });
    },
    saveChanges() {
      if (this.selectedRastreabilidade.id) {
        axios
          .put(`${process.env.VUE_APP_API_BASE_URL}/rastreabilidades/${this.selectedRastreabilidade.id}`, this.selectedRastreabilidade)
          .then(() => {
            this.fetchRastreabilidades();
            this.closeModal();
          })
          .catch((error) => {
            console.error('Erro ao salvar alterações:', error);
          });
      } else {
        axios
          .post(`${process.env.VUE_APP_API_BASE_URL}/rastreabilidades`, this.selectedRastreabilidade)
          .then(() => {
            this.fetchRastreabilidades();
            this.closeModal();
          })
          .catch((error) => {
            console.error('Erro ao criar registro:', error);
          });
      }
    },
    closeModal() {
      this.isModalVisible = false;
    },
  },
};
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>
