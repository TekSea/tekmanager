<template>
  <div
    class="w-auto h-auto collapse navbar-collapse max-height-vh-100 h-100"
    id="sidenav-collapse-main"
  >
    <ul class="navbar-nav">
      <li class="mt-3 nav-item">
        <h6
          class="text-xs ps-4 text-uppercase font-weight-bolder opacity-6"
          :class="this.$store.state.isRTL ? 'me-4' : 'ms-2'"
        >
          Gestão do Sistema
        </h6>
      </li>
      <!--
      <li class="nav-item">
        <sidenav-collapse navText="Login" :to="{ name: 'Login' }">
          <template #icon>
            <document />
          </template>
        </sidenav-collapse>
      </li> 
      <li class="nav-item">
        <sidenav-collapse navText="Register" :to="{ name: 'Register' }">
          <template #icon>
            <spaceship />
          </template>
        </sidenav-collapse>
      </li> -->
      <li class="nav-item">
        <sidenav-collapse navText="Dados Pessoais" :to="{ name: 'Profile' }">
          <template #icon>
            <customer-support />
          </template>
        </sidenav-collapse>
      </li>
      <li class="nav-item">
        <sidenav-collapse navText="Usuários" :to="{ name: 'Users' }">
          <template #icon>
            <switches />
          </template>
        </sidenav-collapse>
      </li>
      <li class="mt-3 nav-item">
        <h6
          class="text-xs ps-4 text-uppercase font-weight-bolder opacity-6"
          :class="this.$store.state.isRTL ? 'me-4' : 'ms-2'"
        >
          Sistemas
        </h6>
      </li>
      
      <li class="nav-item">
        <sidenav-collapse navText="Clientes" :to="{ name: 'Clientes' }">
          <template #icon>
            <document />
          </template>
        </sidenav-collapse>
      </li>
      
      <li class="nav-item">
        <sidenav-collapse navText="Estoque" :to="{ name: 'Estoques' }">
          <template #icon>
            <office />
          </template>
        </sidenav-collapse>
      </li>
      <!--
      <li class="nav-item">
        <sidenav-collapse navText="Rastreabilidade" :to="{ name: 'Rastreabilidade' }">
          <template #icon>
            <credit-card />
          </template>
        </sidenav-collapse>
      </li>
      -->

      
    </ul>
  </div>
  <div class="pt-3 mx-3 mt-3 sidenav-footer">
    <sidenav-card
      :class="cardBg"
      textPrimary="Precisa de ajuda?"
      textSecondary="Documentação do sistema"
      route="https://teksea.net"
      label="Documentação"
      icon="ni ni-diamond"
    />
    >
  </div>
</template>
<script>
import SidenavCollapse from "./SidenavCollapse.vue";
import SidenavCard from "./SidenavCard.vue";
import CustomerSupport from "../../components/Icon/CustomerSupport.vue";
import Switches from "../../components/Icon/Switches.vue";
import Document from "../../components/Icon/Document.vue";

export default {
  name: "SidenavList",
  props: {
    cardBg: String,
  },
  data() {
    return {
      title: "TekManager",
      controls: "dashboardsExamples",
      isActive: "active",
    };
  },
  components: {
    SidenavCollapse,
    SidenavCard,   
    CustomerSupport,
    Switches,
    Document,
  },
  methods: {
    getRoute() {
      const routeArr = this.$route.path.split("/");
      return routeArr[1];
    },
  },
};
</script>
