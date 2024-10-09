<template>
    <el-dialog v-model="isVisible" title="Buscar Produto" width="600px">
      <el-form label-width="200px">
        <el-form-item label="Nome do Produto">
          <el-input v-model="searchTerm" @input="buscarProduto" placeholder="Digite para buscar produtos"></el-input>
        </el-form-item>
        <el-table :data="produtos" style="width: 100%">
          <el-table-column prop="id" label="ID" width="50"></el-table-column>
          <el-table-column prop="produto" label="Nome"></el-table-column>
          <el-table-column prop="ref_sistema" label="Ref. Sistema"></el-table-column>
          <el-table-column prop="ncm" label="Código NCM"></el-table-column>
          <el-table-column label="Ações" width="120">
            <template v-slot="scope">
              <el-button type="primary" size="mini" @click="selecionarProduto(scope.row)">Selecionar</el-button>
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
    name: "BuscaProdutoModal",
    props: {
      modelValue: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {
        searchTerm: "",
        produtos: [],
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
      buscarProduto() {
        if (this.searchTerm) {
          axios
            .get(`${process.env.VUE_APP_API_BASE_URL}/busca/produto`, {
              params: { query: this.searchTerm },
            })
            .then((response) => {
              this.produtos = response.data;
            })
            .catch((error) => {
              console.error("Erro ao buscar produtos:", error);
            });
        } else {
          this.produtos = [];
        }
      },
      selecionarProduto(produto) {
        this.$emit("produto-selecionado", produto);
        this.closeModal();
      },
      closeModal() {
        this.isVisible = false;
        this.searchTerm = "";
        this.produtos = [];
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos adicionais, se necessário */
  </style>
  