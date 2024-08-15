<template>
    <div class="container mt-5">
      <h1 class="mb-4">Clientes</h1>
      <b-card>
        <b-form-input
          v-model="search"
          class="mb-3"
          placeholder="Pesquisar clientes..."
        ></b-form-input>
        <b-table
          bordered
          hover
          :items="filteredClientes"
          :fields="fields"
          v-model:sortBy="sortBy"
          v-model:sortDesc="sortDesc"
          @filtered="onFiltered"
        >
          <template #cell(nome)="data">
            <span>{{ data.item.nome }}</span>
          </template>
          <template #cell(nome_fantasia)="data">
            <span>{{ data.item.nome_fantasia }}</span>
          </template>
          <template #cell(uf)="data">
            <span>{{ data.item.uf }}</span>
          </template>
          <template #cell(cidade)="data">
            <span>{{ data.item.cidade }}</span>
          </template>
          <template #cell(representante)="data">
            <span>{{ data.item.representante }}</span>
          </template>
          <template #cell(situacao)="data">
            <span>{{ data.item.situacao }}</span>
          </template>
        </b-table>
  
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="right"
          class="my-0 mt-3"
        ></b-pagination>
      </b-card>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  const API_URL = process.env.VUE_APP_API_BASE_URL + "/";
  
  export default {
    name: "Clientes",
    data() {
      return {
        clientes: [],
        search: "",
        currentPage: 1,
        perPage: 10,
        totalRows: 0,
        sortBy: "nome",
        sortDesc: false,
        fields: [
          { key: "id", label: "ID", sortable: true },
          { key: "nome", label: "Nome", sortable: true },
          { key: "nome_fantasia", label: "Nome Fantasia", sortable: true },
          { key: "uf", label: "UF", sortable: true },
          { key: "cidade", label: "Cidade", sortable: true },
          { key: "representante", label: "Representante", sortable: true },
          { key: "situacao", label: "Situação", sortable: true },
        ],
      };
    },
    computed: {
      filteredClientes() {
        return this.clientes.filter((cliente) => {
          return (
            cliente.nome.toLowerCase().includes(this.search.toLowerCase()) ||
            cliente.nome_fantasia
              .toLowerCase()
              .includes(this.search.toLowerCase()) ||
            cliente.uf.toLowerCase().includes(this.search.toLowerCase()) ||
            cliente.cidade.toLowerCase().includes(this.search.toLowerCase()) ||
            cliente.representante
              .toLowerCase()
              .includes(this.search.toLowerCase()) ||
            cliente.situacao.toLowerCase().includes(this.search.toLowerCase())
          );
        });
      },
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
            this.totalRows = this.clientes.length;
          })
          .catch((error) => {
            console.error("Erro ao buscar clientes:", error);
          });
      },
      onFiltered(filteredItems) {
        this.totalRows = filteredItems.length;
        this.currentPage = 1;
      },
    },
  };
  </script>
  
  <style scoped>
  .container {
    max-width: 1200px;
  }
  
  .table {
    border-radius: 5px;
    border: 1px solid #dee2e6;
  }
  
  .mb-4 {
    color: #2c3e50;
    text-align: center;
  }
  
  .b-table {
    background-color: #f9f9f9;
  }
  
  .b-pagination {
    margin-top: 20px;
  }
  </style>
  