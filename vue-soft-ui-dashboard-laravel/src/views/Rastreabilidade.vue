<template>
    <div class="container">
      <h1>Rastreabilidade</h1>
      <RastreabilidadeTable :rastreabilidade="rastreabilidade" />
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import RastreabilidadeTable from './components/RastreabilidadeTable.vue';
  
  const API_URL = process.env.VUE_APP_API_BASE_URL + '/';
  
  export default {
    name: 'Rastreabilidade',
    components: {
      RastreabilidadeTable,
    },
    data() {
      return {
        rastreabilidade: [],
      };
    },
    created() {
      this.fetchRastreabilidade();
    },
    methods: {
      fetchRastreabilidade() {
        axios.get(API_URL + 'rastreabilidades')
          .then(response => {
            this.rastreabilidade = response.data;
          })
          .catch(error => {
            console.error('Erro ao buscar dados de rastreabilidade:', error);
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
  