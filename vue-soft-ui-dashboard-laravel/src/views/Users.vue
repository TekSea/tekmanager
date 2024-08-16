<template>
  <div class="py-4 container-fluid">
    <div class="form-group">      
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="pb-0 card-header">
            <div class="d-lg-flex">
              <div>
                <h5 class="mb-0">Lista de Usuários do Sistema</h5>
              </div>
              <div class="my-auto mt-4 ms-auto mt-lg-0">
                <div class="my-auto ms-auto">
                  <a @click="addUser" class="mb-0 btn bg-gradient-success btn-sm">
                    +&nbsp; Novo Usuário
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="px-0 pb-0 card-body">
            <div class="table-responsive">
              <table id="users-list" ref="usersList" class="table table-flush">
                <thead class="thead-light">
                  <tr>
                    <th>Nome</th>
                    <th>Email</th>                    
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody class="text-sm">
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                      <a
                        @click="editUser(user.id)"
                        class="actionButton cursor-pointer me-3"
                        data-bs-toggle="tooltip"
                        title="Editar Usuário"
                      >
                        <i class="fas fa-user-edit text-secondary"></i>
                      </a>
                      <a
                        @click="deleteUser(user.id)"
                        class="actionButton deleteButton cursor-pointer"
                        data-bs-toggle="tooltip"
                        title="Excluir Usuário"
                      >
                        <i class="fas fa-trash text-secondary"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div
            class="d-flex justify-content-center justify-content-sm-between flex-wrap"
            style="padding: 24px 24px 0px"
          >
            <div>
              <p>Mostrando {{ paginatedUsers.length }} de {{ users.length }} usuários</p>
            </div>
            <ul class="pagination pagination-success pagination-md">
              <li class="page-item prev-page" :class="{ disabled: currentPage === 1 }">
                <a class="page-link" @click="prevPage" aria-label="Previous">
                  <span aria-hidden="true">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                  </span>
                </a>
              </li>
              <li
                v-for="page in totalPages"
                :key="page"
                class="page-item"
                :class="{ active: currentPage === page }"
              >
                <a
                  class="page-link"
                  @click="setPage(page)"
                  style="color: white"
                >
                  {{ page }}
                </a>
              </li>
              <li class="page-item next-page" :class="{ disabled: currentPage === totalPages }">
                <a class="page-link" @click="nextPage" aria-label="Next">
                  <span aria-hidden="true">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

const API_URL = process.env.VUE_APP_API_BASE_URL + "/";

export default {
  name: "Users",
  data() {
    return {
      users: [],
      currentPage: 1,
      itemsPerPage: 10,
    };
  },
  computed: {
    paginatedUsers() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.users.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.users.length / this.itemsPerPage);
    },
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      axios
        .get(API_URL + "users")
        .then((response) => {
          this.users = response.data;
        })
        .catch((error) => {
          console.error("Erro ao buscar usuários:", error);
        });
    },
    addUser() {
      // Lógica para adicionar um novo usuário
    },
    editUser(id) {
      // Lógica para editar o usuário
      console.log("Editar usuário:", id);
    },
    deleteUser(id) {
      // Lógica para excluir o usuário
      console.log("Excluir usuário:", id);
    },
    setPage(page) {
      this.currentPage = page;
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
  },
};
</script>

