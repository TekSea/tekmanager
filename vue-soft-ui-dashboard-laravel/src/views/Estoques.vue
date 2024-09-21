<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="pb-0 card-header">
            <div class="d-lg-flex">
              <div>
                <h5 class="mb-0">Controle de Estoque</h5>
              </div>
              <div class="my-auto mt-4 ms-auto mt-lg-0">
                <div class="my-auto ms-auto">
                  <a @click="addEstoque" class="mb-0 btn bg-gradient-success btn-sm">
                    +&nbsp; Novo Item
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="px-4 pb-4 card-body">
            <table id="estoque-table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Produto</th>
                  <th>NCM</th>
                  <th>Ref. Sistema</th>
                  <th>Ações</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import $ from 'jquery';
import 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

export default {
  name: 'Estoques',
  data() {
    return {
      estoques: [],
    };
  },
  mounted() {
    this.fetchEstoques();
  },
  methods: {
    fetchEstoques() {
      axios.get(process.env.VUE_APP_API_BASE_URL + '/estoques')
        .then(response => {
          this.estoques = response.data;
          this.initializeDataTable();
        })
        .catch(error => {
          console.error("Erro ao buscar estoques:", error);
        });
    },
    initializeDataTable() {
      $('#estoque-table').DataTable({
        data: this.estoques,
        columns: [
          { data: 'id' },
          { data: 'produto' },
          { data: 'ncm' },
          { data: 'ref_sistema' },
          {
            data: null,
            render: (data) => {
              return `
                <a href="#" class="btn btn-sm btn-primary" onclick="editItem(${data.id})">Editar</a>
                <a href="#" class="btn btn-sm btn-danger" onclick="deleteItem(${data.id})">Excluir</a>
              `;
            }
          }
        ],
        paging: true,
        searching: true,
        ordering: true,
        responsive: true,
        /*language: {
           url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
        },*/
        lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"] ], // Opções de registros por página
        pageLength: 5,
        //dom: '<"top"f>rt<"bottom"ip><"clear">',
      });
    }
  }
};
</script>

<style>
@import "~datatables.net-bs5/css/dataTables.bootstrap5.min.css";
@import "~bootstrap/dist/css/bootstrap.min.css";

</style>
