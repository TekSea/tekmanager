<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-12">
        <clientes-table :clientes="clientes" />
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
      console.log("Buscando clientes em:", API_URL + "clientes");
      axios
        .get(API_URL + "clientes")
        .then((response) => {
          console.log("Clientes:", response.data);
          this.clientes = response.data;
        })
        .catch((error) => {
          console.error("Erro ao buscar clientes:", error);
        });
    },
  },
};
</script>
