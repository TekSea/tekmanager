<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
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
          <div class="px-4 pb-4 card-body">
            <rastreabilidade-table :rastreabilidades="rastreabilidades" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import RastreabilidadeTable from "./components/RastreabilidadeTable.vue";

const API_URL = process.env.VUE_APP_API_BASE_URL + "/";

export default {
  name: "Rastreabilidade",
  components: {
    RastreabilidadeTable,
  },
  data() {
    return {
      rastreabilidades: [],
    };
  },
  created() {
    this.fetchRastreabilidades();
  },
  methods: {
    fetchRastreabilidades() {
      axios
        .get(API_URL + "rastreabilidade_friendly")
        .then((response) => {
          this.rastreabilidades = response.data;
        })
        .catch((error) => {
          console.error("Erro ao buscar rastreabilidades:", error);
        });
    },
    addRastreabilidade() {
      // Lógica para adicionar um novo registro de rastreabilidade
    },
  },
};
</script>
