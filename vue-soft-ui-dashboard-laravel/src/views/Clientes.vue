<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="pb-0 card-header">
            <div class="d-lg-flex">
              <div>
                <h5 class="mb-0">Clientes</h5>
              </div>
              <div class="my-auto mt-4 ms-auto mt-lg-0">
                <div class="my-auto ms-auto">
                  <a @click="addCliente()" class="mb-0 btn bg-gradient-success btn-sm">
                    +&nbsp; Novo Cliente
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="px-4 pb-4 card-body">
            <div>
              <vue-good-table :columns="columns" :rows="clientes" :search-options="{ enabled: true }"
                :pagination-options="{ enabled: true, perPageDropdown: [10, 25, 50, 100] }">
                <template v-slot:table-row="props">
                  <span v-if="props.column.field === 'actions'">
                    <tippy content="Editar">
                      <font-awesome-icon icon="edit" class="text-primary cursor-pointer"
                        @click="editCliente(props.row.id)" />
                    </tippy>

                    <tippy content="Excluir">
                      <font-awesome-icon icon="trash" class="text-danger cursor-pointer ms-3"
                        @click="deleteCliente(props.row.id)" />
                    </tippy>
                  </span>
                  <span v-else>{{ props.formattedRow[props.column.field] }}</span>
                </template>
              </vue-good-table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal para Edição -->
  <el-dialog v-model="isModalVisible" title="Editar Cliente" width="600px">
  <el-form label-width="120px">
    <el-form-item label="Nome">
      <el-input v-model="selectedCliente.nome"></el-input>
    </el-form-item>
    <el-form-item label="CNPJ/CPF">
      <el-input v-model="selectedCliente.cnpj_cpf"></el-input>
    </el-form-item>
    <el-form-item label="Nome Fantasia">
      <el-input v-model="selectedCliente.nome_fantasia"></el-input>
    </el-form-item>
    <el-form-item label="UF">
      <el-input v-model="selectedCliente.uf"></el-input>
    </el-form-item>
    <el-form-item label="Cidade">
      <el-input v-model="selectedCliente.cidade"></el-input>
    </el-form-item>
    <el-form-item label="Representante">
      <el-input v-model="selectedCliente.representante"></el-input>
    </el-form-item>
    <el-form-item label="Situação">
      <el-select v-model="selectedCliente.situacao" placeholder="Selecione">
        <el-option label="Ativo" value="ativo"></el-option>
        <el-option label="Inativo" value="inativo"></el-option>
      </el-select>
    </el-form-item>
  </el-form>
  <template #footer>
    <el-button @click="closeModal">Cancelar</el-button>
    <el-button type="primary" @click="saveChanges">Salvar</el-button>
  </template>
</el-dialog>

</template>

<script>
import axios from 'axios';
import { VueGoodTable } from 'vue-good-table-next';
import 'vue-good-table-next/dist/vue-good-table-next.css';

export default {
  name: 'Clientes',
  components: {
    VueGoodTable,
  },
  data() {
    return {
      clientes: [], // Dados dos clientes
      selectedCliente: {}, // Cliente selecionado para edição
      isModalVisible: false, // Controle de visibilidade do modal
      columns: [
        { label: 'ID', field: 'id', sortable: true },
        { label: 'Nome', field: 'nome', sortable: true },
        { label: 'CNPJ/CPF', field: 'cnpj_cpf', sortable: true },
        { label: 'Nome Fantasia', field: 'nome_fantasia', sortable: true },
        { label: 'UF', field: 'uf', sortable: true },
        { label: 'Cidade', field: 'cidade', sortable: true },
        { label: 'Representante', field: 'representante', sortable: true },
        { label: 'Situação', field: 'situacao', sortable: true },
        { label: 'Ações', field: 'actions' },
      ],
    };
  },
  mounted() {
    this.fetchClientes();
  },
  methods: {
    fetchClientes() {
      axios
        .get(process.env.VUE_APP_API_BASE_URL + '/clientes')
        .then((response) => {
          this.clientes = response.data;
        })
        .catch((error) => {
          console.error('Erro ao buscar clientes:', error);
        });
    },
    addCliente() {
      this.selectedCliente = { situacao: 'ativo' }; // Limpa os dados do cliente selecionado e define padrão
      this.isModalVisible = true;
    },
    editCliente(id) {
      const cliente = this.clientes.find((item) => item.id === id);
      if (cliente) {
        this.selectedCliente = { ...cliente };
        this.isModalVisible = true;
      }
    },
    deleteCliente(id) {
      axios
        .delete(`${process.env.VUE_APP_API_BASE_URL}/clientes/${id}`)
        .then(() => {
          this.fetchClientes(); // Atualiza a lista após exclusão
        })
        .catch((error) => {
          console.error('Erro ao excluir cliente:', error);
        });
    },
    saveChanges() {
      if (this.selectedCliente.id) {
        axios
          .put(`${process.env.VUE_APP_API_BASE_URL}/clientes/${this.selectedCliente.id}`, this.selectedCliente)
          .then(() => {
            this.fetchClientes(); // Atualiza a lista após edição
            this.closeModal();
          })
          .catch((error) => {
            console.error('Erro ao salvar alterações:', error);
          });
      } else {
        axios
          .post(`${process.env.VUE_APP_API_BASE_URL}/clientes`, this.selectedCliente)
          .then(() => {
            this.fetchClientes(); // Atualiza a lista após criação
            this.closeModal();
          })
          .catch((error) => {
            console.error('Erro ao criar cliente:', error);
          });
      }
    },
    closeModal() {
      this.isModalVisible = false;
      this.selectedCliente = {}; // Limpa os dados do modal
    },
  },
};
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>
