<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="pb-0 card-header">
            <div class="d-lg-flex">
              <div>
                <h5 class="mb-0">Lista de Estoques</h5>
              </div>
              <div class="my-auto mt-4 ms-auto mt-lg-0">
                <div class="my-auto ms-auto">
                  <a @click="addEstoque" class="mb-0 btn bg-gradient-success btn-sm">
                    +&nbsp; Novo Estoque
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="px-4 pb-4 card-body">
            <estoque-table :estoques="estoques" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import EstoqueTable from "./components/EstoqueTable.vue";

const API_URL = process.env.VUE_APP_API_BASE_URL + "/";

export default {
  name: "Estoques",
  components: {
    EstoqueTable,
  },
  data() {
    return {
      estoques: [],
    };
  },
  created() {
    this.fetchEstoques();
  },
  methods: {
    fetchEstoques() {
      axios
        .get(API_URL + "estoques")
        .then((response) => {
          this.estoques = response.data;
        })
        .catch((error) => {
          console.error("Erro ao buscar estoques:", error);
        });
    },
    addEstoque() {
      // Lógica para adicionar um novo estoque
    },
  },
};
</script>
