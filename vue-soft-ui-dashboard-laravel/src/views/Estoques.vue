<template>
  <div class="container">
    <h1>Estoque</h1>
    <EstoqueTable :estoque="estoque" />
  </div>
</template>

<script>
import axios from 'axios';
import EstoqueTable from './components/EstoqueTable.vue';

const API_URL = process.env.VUE_APP_API_BASE_URL + '/';

export default {
  name: 'Estoques',
  components: {
    EstoqueTable,
  },
  data() {
    return {
      estoque: [],
    };
  },
  created() {
    this.fetchEstoque();
  },
  methods: {
    fetchEstoque() {
      axios.get(API_URL + 'estoques')
        .then(response => {
          this.estoque = response.data;
        })
        .catch(error => {
          console.error('Erro ao buscar dados do estoque:', error);
        });
    },
  },
};
</script>

<style scoped>
.container {
  margin-top: 20px;
}
</style>
