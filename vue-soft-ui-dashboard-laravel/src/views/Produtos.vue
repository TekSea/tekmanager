<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- Cabeçalho do Card -->
          <div class="pb-0 card-header">
            <div class="d-lg-flex">
              <div>
                <h5 class="mb-0">Produto</h5>
              </div>
              <div class="my-auto mt-4 ms-auto mt-lg-0">
                <div class="my-auto ms-auto">
                  <a @click="openModal()" class="mb-0 btn bg-gradient-success btn-sm">
                    +&nbsp; Novo Item
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Corpo da Tabela -->
          <div class="px-4 pb-4 card-body">
            <vue-good-table :columns="columns" :rows="produtos" :search-options="{ enabled: true }"
              :pagination-options="{ enabled: true, perPageDropdown: [10, 25, 50, 100] }">
              <template v-slot:table-row="props">
                <span v-if="props.column.field === 'actions'">
                  <tippy content="Editar">
                    <font-awesome-icon icon="edit" class="text-primary cursor-pointer" @click="openModal(props.row)" />
                  </tippy>
                  <tippy content="Excluir">
                    <font-awesome-icon icon="trash" class="text-danger cursor-pointer ms-3"
                      @click="deleteItem(props.row.id)" />
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
    <el-dialog v-model="isModalVisible" title="Editar Item de Produto">
      <el-form label-width="120px">
        <el-form-item label="Produto">
          <el-input v-model="selectedItem.produto"></el-input>
        </el-form-item>
        <el-form-item label="NCM">
          <el-input v-model="selectedItem.ncm"></el-input>
        </el-form-item>
        <el-form-item label="Ref. Sistema">
          <el-input v-model="selectedItem.ref_sistema"></el-input>
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
import axios from 'axios';
import { VueGoodTable } from 'vue-good-table-next';
import 'vue-good-table-next/dist/vue-good-table-next.css';

export default {
  name: 'Produtos',
  components: {
    VueGoodTable,
  },
  data() {
    return {
      produtos: [],
      selectedItem: {},
      isModalVisible: false,
      columns: [
        { label: 'ID', field: 'id', sortable: true },
        { label: 'Produto', field: 'produto', sortable: true },
        { label: 'NCM', field: 'ncm', sortable: true },
        { label: 'Ref. Sistema', field: 'ref_sistema', sortable: true },
        { label: 'Ações', field: 'actions' },
      ],
    };
  },
  mounted() {
    this.fetchProdutos();
  },
  methods: {
    fetchProdutos() {
      axios
        .get(process.env.VUE_APP_API_BASE_URL + '/produtos')
        .then((response) => {
          this.produtos = response.data;
        })
        .catch((error) => {
          console.error('Erro ao buscar produtos:', error);
        });
    },
    openModal(item = {}) {
      console.log("Abrindo modal");
      this.selectedItem = { ...item }; // Clona o item selecionado
      this.isModalVisible = true; // Abre o modal
      console.log("isModalVisible: ", this.isModalVisible); // Verifique se está abrindo
    },
    closeModal() {
      this.isModalVisible = false; // Fecha o modal
    },
    saveChanges() {
    if (this.selectedItem.id) {
      // Atualiza o item existente
      axios
        .put(`${process.env.VUE_APP_API_BASE_URL}/produtos/${this.selectedItem.id}`, this.selectedItem)
        .then((response) => {
          console.log('Item atualizado com sucesso:', response.data);
          this.fetchProdutos(); // Atualiza a lista de produtos
        })
        .catch((error) => {
          console.error('Erro ao atualizar o item:', error);
        });
    } else {
      // Cria um novo item
      axios
        .post(`${process.env.VUE_APP_API_BASE_URL}/produtos`, this.selectedItem)
        .then((response) => {
          console.log('Novo item criado com sucesso:', response.data);
          this.fetchProdutos(); // Atualiza a lista de produtos
        })
        .catch((error) => {
          console.error('Erro ao criar o item:', error);
        });
    }
    this.closeModal(); // Fecha o modal após salvar as alterações
  },
  deleteItem(id) {
    axios
      .delete(`${process.env.VUE_APP_API_BASE_URL}/produtos/${id}`)
      .then(() => {
        console.log(`Item com id ${id} excluído com sucesso.`);
        this.fetchProdutos(); // Atualiza a lista de produtos após exclusão
      })
      .catch((error) => {
        console.error('Erro ao excluir o item:', error);
      });
    },
  },
};
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}

.el-dialog {
  z-index: 9999 !important;
}
</style>
