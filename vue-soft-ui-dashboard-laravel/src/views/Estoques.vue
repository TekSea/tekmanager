<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="pb-0 card-header">
            <div class="d-lg-flex">
              <div>
                <h5 class="mb-0">Estoque</h5>
              </div>
              <div class="my-auto mt-4 ms-auto mt-lg-0">
                <div class="my-auto ms-auto">
                  <a @click="addItem" class="mb-0 btn bg-gradient-success btn-sm">
                    +&nbsp; Novo Item
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="px-4 pb-4 card-body">
            <div>
              <vue-good-table :columns="columns" :rows="estoques" :search-options="{ enabled: true }"
                :pagination-options="{ enabled: true, perPageDropdown: [10, 25, 50, 100] }">
                <template v-slot:table-row="props">
                  <span v-if="props.column.field === 'actions'">
                    <!-- Ícone de edição com Tippy -->
                    <tippy content="Editar">
                      <font-awesome-icon icon="edit" class="text-primary cursor-pointer"
                        @click="editItem(props.row.id)" />
                    </tippy>

                    <!-- Ícone de exclusão com Tippy -->
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
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { VueGoodTable } from 'vue-good-table-next';
import 'vue-good-table-next/dist/vue-good-table-next.css';

export default {
  name: 'Estoques',
  components: {
    VueGoodTable,
  },
  data() {
    return {
      estoques: [], // Dados dos estoques
      columns: [
        {
          label: 'ID',
          field: 'id',
          sortable: true,
        },
        {
          label: 'Produto',
          field: 'produto',
          sortable: true,
        },
        {
          label: 'NCM',
          field: 'ncm',
          sortable: true,
        },
        {
          label: 'Ref. Sistema',
          field: 'ref_sistema',
          sortable: true,
        },
        {
          label: 'Ações',
          field: 'actions',
        },
      ],
    };
  },
  mounted() {
    this.fetchEstoques();
  },
  methods: {
    fetchEstoques() {
      axios
        .get(process.env.VUE_APP_API_BASE_URL + '/estoques')
        .then((response) => {
          this.estoques = response.data;
        })
        .catch((error) => {
          console.error('Erro ao buscar estoques:', error);
        });
    },
    editItem(id) {
      console.log('Editando item com id:', id);
    },
    deleteItem(id) {
      console.log('Excluindo item com id:', id);
    },
  },
};
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>
