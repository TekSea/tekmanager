<template>
    <el-dialog v-model="isVisible" title="Buscar Cliente" width="600px">
      <el-form label-width="200px">
        <el-form-item label="Nome do Cliente">
          <el-input v-model="searchQuery" @input="searchClientes"></el-input>
        </el-form-item>
        <el-table :data="clientes" style="width: 100%">
          <el-table-column prop="id" label="ID" width="50"></el-table-column>
          <el-table-column prop="nome" label="Nome"></el-table-column>
          <el-table-column label="Ações" width="120">
            <template v-slot="scope">
              <el-button type="primary" size="mini" @click="selectCliente(scope.row)">Selecionar</el-button>
            </template>
          </el-table-column>
        </el-table>
      </el-form>
      <template #footer>
        <el-button @click="closeModal">Fechar</el-button>
      </template>
    </el-dialog>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "BuscaClienteModal",
    props: {
      modelValue: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {
        searchQuery: "",
        clientes: [],
      };
    },
    computed: {
      isVisible: {
        get() {
          return this.modelValue;
        },
        set(value) {
          this.$emit("update:modelValue", value);
        },
      },
    },
    methods: {
      searchClientes() {
        if (this.searchQuery) {
          axios
            .get(`${process.env.VUE_APP_API_BASE_URL}/busca/cliente`, {
              params: { query: this.searchQuery },
            })
            .then((response) => {
              this.clientes = response.data;
            })
            .catch((error) => {
              console.error("Erro ao buscar clientes:", error);
            });
        } else {
          this.clientes = [];
        }
      },
      selectCliente(cliente) {
        this.$emit("cliente-selecionado", cliente);
        this.closeModal();
      },
      closeModal() {
        this.isVisible = false;
      },
    },
  };
  </script>
  
  <style scoped>
  /* Se necessário, personalize os estilos aqui */
  </style>
  