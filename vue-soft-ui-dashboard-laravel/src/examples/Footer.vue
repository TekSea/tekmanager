<template>
  <footer class="py-3 footer">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="mb-4 col-lg-6 mb-lg-0">
          <div
            class="text-sm text-center copyright text-muted"
            :class="this.$store.state.isRTL ? 'text-lg-end' : 'text-lg-start'"
          >
           <a
              href="https://teksea.net"
              class="font-weight-bold"
              target="_blank"
              >TekSea© </a
            >

            {{ new Date().getFullYear() }} - Todos os direitos reservados.            
            
          </div>
        </div>
        <div class="col-lg-6">
          <ul
            class="nav nav-footer justify-content-center justify-content-lg-end"
          >
            <li class="nav-item">
              <a
                href="https://teksea.net"
                class="nav-link text-muted"
                target="_blank"
                >TekSea</a
              >
            </li>            
            <li class="nav-item">
              <a
                href="https://teksea.net/sobre-teksea/"
                class="nav-link text-muted"
                target="_blank"
                >Sobre</a
              >
            </li>
            <li class="nav-item">
              <a
                href="https://teksea.net/fale-conosco/"
                class="nav-link text-muted"
                target="_blank"
                >Contato</a
              >
            </li>            
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: "app-footer",
};
</script>
