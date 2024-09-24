<template>
    <div class="card">
      <!-- Card header -->
      <div class="pb-0 card-header">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">{{ title }}</h5>
          </div>
          <div class="my-auto mt-4 ms-auto mt-lg-0">
            <div class="my-auto ms-auto">
              <!-- Slot para os botões na barra de título -->
              <slot name="buttons"></slot>
            </div>
          </div>
        </div>
      </div>
      <!-- Card body (conteúdo da tabela) -->
      <div class="px-4 pb-4 card-body">
        <slot name="tableContent"></slot>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'CardTable',
    props: {
      title: {
        type: String,
        required: true
      }
    }
  }
  </script>
  
  <style scoped>
  /* Aqui você pode adicionar estilos personalizados, se necessário */
  </style>
  