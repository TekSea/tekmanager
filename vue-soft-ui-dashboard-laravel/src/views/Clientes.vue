<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="pb-0 card-header">
            <div class="d-lg-flex">
              <div>
                <h5 class="mb-0">Lista de Clientes</h5>
              </div>
              <div class="my-auto mt-4 ms-auto mt-lg-0">
                <div class="my-auto ms-auto">
                  <a @click="addClient" class="mb-0 btn bg-gradient-success btn-sm">
                    +&nbsp; Novo Cliente
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="px-4 pb-4 card-body">
            <clientes-table :clientes="clientes" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import ClientesTable from "./components/ClientesTable.vue";

const API_URL = process.env.VUE_APP_API_BASE_URL + "/";

export default {
  name: "Clientes",
  components: {
    ClientesTable,
  },
  data() {
    return {
      clientes: [],
    };
  },
  created() {
    this.fetchClientes();
  },
  methods: {
    fetchClientes() {
      axios
        .get(API_URL + "clientes")
        .then((response) => {
          this.clientes = response.data;
        })
        .catch((error) => {
          console.error("Erro ao buscar clientes:", error);
        });
    },
    addClient() {
      // Lógica para adicionar um novo cliente
    },
  },
};
</script>
