<template>
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header pb-0">
            <h5 class="mb-0">Bem-vindo ao TekManager</h5>
          </div>
          <div class="card-body">
            <p class="text-sm">
              O <strong>TekManager</strong> é um sistema integrado de gestão empresarial desenvolvido para
              facilitar e otimizar a administração de suas operações. Com uma interface intuitiva e
              ferramentas poderosas, o TekManager oferece controle completo sobre os processos de sua empresa, 
              desde a gestão de clientes e produto até a rastreabilidade de produtos.
            </p>
            <p class="text-sm">
              Nosso objetivo é fornecer uma solução que não apenas automatize tarefas, mas também ofereça 
              insights valiosos para apoiar a tomada de decisões estratégicas. Seja bem-vindo a uma nova era de 
              eficiência e controle, onde cada aspecto do seu negócio pode ser gerido com precisão e facilidade.
            </p>
            <p class="text-sm">
              Explore as funcionalidades disponíveis através do menu lateral, onde você encontrará módulos específicos para 
              cada área de sua empresa. Se precisar de assistência, nossa documentação está disponível e nossa equipe de suporte 
              está sempre pronta para ajudar.
            </p>
            <p class="text-sm">
              <strong>Principais Módulos:</strong>
            </p>
            <ul class="text-sm">
              <li>Gestão de Clientes: Mantenha o controle sobre suas relações comerciais com um banco de dados robusto e flexível.</li>
              <li>Gestão de Produto: Monitore seus produtos em tempo real, com alertas e relatórios detalhados.</li>
              <li>Rastreabilidade de Produtos: Garanta a qualidade e segurança com rastreabilidade completa de cada item.</li>
              <li>Gestão de Usuários: Controle de acesso e permissões para garantir a segurança das informações.</li>
            </ul>
            <p class="text-sm">
              Aproveite ao máximo as capacidades do TekManager e leve a gestão da sua empresa para o próximo nível.
            </p>
            <p class="text-sm mb-0">
              <strong>Equipe TekSea</strong>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Home",
};
</script>

<style scoped>
.card {
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
}

.card-header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #dee2e6;
  padding: 16px 24px;
}

.card-body {
  padding: 24px;
}

.text-sm {
  font-size: 0.875rem;
  color: #6c757d;
  line-height: 1.5;
}

ul.text-sm {
  padding-left: 20px;
  margin-bottom: 16px;
}

ul.text-sm li {
  margin-bottom: 8px;
}

h5.mb-0 {
  font-size: 1.25rem;
  font-weight: bold;
  color: #32325d;
}
</style>
