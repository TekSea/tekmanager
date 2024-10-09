<template>
    <el-dialog v-model="isVisible" :title="modalTitle" width="600px">
        <el-form label-width="200px">
            <el-form-item label="Número de Série">
                <el-input v-model="rastreabilidade.numero_serie"></el-input>
            </el-form-item>
            <el-form-item label="Data de Geração">
                <el-date-picker v-model="rastreabilidade.data_geracao" type="date"></el-date-picker>
            </el-form-item>
            <el-form-item label="Responsável pela Criação">
                <el-input v-model="responsavel_criacao" readonly></el-input>
            </el-form-item>
            <el-form-item label="Cliente">
                <el-input v-model="clienteNome" readonly placeholder="Selecione um cliente"></el-input>
                <el-button type="primary" @click="openBuscaClienteModal">Buscar Cliente</el-button>
            </el-form-item>
            <el-form-item label="Produto">
                <el-input v-model="produtoNome" readonly placeholder="Selecione um produto"></el-input>
                <el-button type="primary" @click="openBuscaProdutoModal">Buscar Produto</el-button>
            </el-form-item>
            <el-form-item label="PV">
                <el-input v-model="rastreabilidade.pv"></el-input>
            </el-form-item>
            <el-form-item label="Ordem de Produção">
                <el-input v-model="rastreabilidade.op"></el-input>
            </el-form-item>
            <el-form-item label="Código NET">
                <el-input v-model="rastreabilidade.codigo_net"></el-input>
            </el-form-item>
            <el-form-item label="Referência do Sistema">
                <el-input v-model="rastreabilidade.ref_sistema"></el-input>
            </el-form-item>
            <el-form-item label="Obra Alocada">
                <el-input v-model="rastreabilidade.obra_alocada"></el-input>
            </el-form-item>
            <el-form-item label="Número da Fatura">
                <el-input v-model="rastreabilidade.n_fatura"></el-input>
            </el-form-item>
            <el-form-item label="Data de Envio">
                <el-date-picker v-model="rastreabilidade.data_enviado" type="date"></el-date-picker>
            </el-form-item>
            <el-form-item label="Garantia (dias)">
                <el-input v-model="rastreabilidade.garantia_dias"></el-input>
            </el-form-item>
            <el-form-item label="Expira Garantia">
                <el-date-picker v-model="rastreabilidade.expira_garantia" type="date"></el-date-picker>
            </el-form-item>
            <el-form-item label="Status da Garantia">
                <el-input v-model="rastreabilidade.status_garantia"></el-input>
            </el-form-item>
            <el-form-item label="Condição da Garantia">
                <el-input v-model="rastreabilidade.condicao_garantia"></el-input>
            </el-form-item>
        </el-form>
        <template #footer>
            <el-button @click="closeModal">Cancelar</el-button>
            <el-button type="primary" @click="saveChanges">Salvar</el-button>
        </template>

        <!-- Modal de busca de cliente -->
        <busca-cliente-modal v-model="isBuscaClienteModalVisible" @cliente-selecionado="selecionarCliente" />

        <!-- Modal de busca de produto -->
        <busca-produto-modal v-model="isBuscaProdutoModalVisible" @produto-selecionado="selecionarProduto" />
    </el-dialog>
</template>

<script>
import axios from "axios";
import BuscaClienteModal from "./BuscaClienteModal.vue";
import BuscaProdutoModal from "./BuscaProdutoModal.vue";


export default {
    name: "EditarRastreabilidadeModal",
    components: {
        BuscaClienteModal,
        BuscaProdutoModal,
    },
    props: {
        modelValue: {
            type: Boolean,
            default: false,
        },
        id: {
            type: Number,
            default: null,
        },
    },
    data() {
        return {
            rastreabilidade: this.createEmptyItem(),
            clienteNome: "",
            isBuscaClienteModalVisible: false,
            produtoNome: "",
            isBuscaProdutoModalVisible: false,
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
        modalTitle() {
            return this.id ? "Editar Rastreabilidade" : "Nova Rastreabilidade";
        },
    },
    watch: {
        id: {
            immediate: true,
            handler(newId) {
                if (newId) {
                    this.fetchRastreabilidade(newId);
                } else {
                    this.rastreabilidade = this.createEmptyItem();
                }
            },
        },
    },
    methods: {
        fetchRastreabilidade(id) {
            axios
                .get(`${process.env.VUE_APP_API_BASE_URL}/rastreabilidades/${id}`)
                .then((response) => {
                    this.rastreabilidade = response.data;
                    this.fetchCliente(this.rastreabilidade.cliente_id);
                    this.fetchProduto(this.rastreabilidade.produto_id);
                    this.fetchResponsavelCriacao(this.rastreabilidade.responsavel_criacao);
                })
                .catch((error) => {
                    console.error("Erro ao buscar rastreabilidade:", error);
                });
        },
        fetchCliente(id) {
            if (id) {
                axios
                    .get(`${process.env.VUE_APP_API_BASE_URL}/clientes/${id}`)
                    .then((response) => {
                        this.clienteNome = response.data.nome;
                    })
                    .catch((error) => {
                        console.error("Erro ao buscar cliente:", error);
                    });
            } else {
                this.clienteNome = "";
            }
        },
        fetchProduto(id){
            if (id) {
                axios
                    .get(`${process.env.VUE_APP_API_BASE_URL}/produtos/${id}`)
                    .then((response) => {
                        this.produtoNome = response.data.produto;
                    })
                    .catch((error) => {
                        console.error("Erro ao buscar produto:", error);
                    });
            } else {
                this.produtoNome = "";
            }
        },
        fetchResponsavelCriacao(id) {
            if (id) {
                axios
                    .get(`${process.env.VUE_APP_API_BASE_URL}/usuarios/${id}`)
                    .then((response) => {
                        console.log(response.data.name);
                        this.responsavel_criacao = response.data.name;
                    })
                    .catch((error) => {
                        console.error("Erro ao buscar responsável pela criação:", error);
                    });
            } else {
                this.responsavel_criacao = "";
            }
        },
        createEmptyItem() {
            return {
                numero_serie: "",
                data_geracao: null,
                responsavel_criacao: "",
                cliente_id: null,
                produto_id: null,
                pv: "",
                op: "",
                codigo_net: null,
                ref_sistema: "",
                obra_alocada: "",
                n_fatura: "",
                data_enviado: null,
                garantia_dias: null,
                expira_garantia: null,
                status_garantia: "",
                condicao_garantia: "",
            };
        },
        saveChanges() {
            const request = this.id
                ? axios.put(`${process.env.VUE_APP_API_BASE_URL}/rastreabilidades/${this.id}`, this.rastreabilidade)
                : axios.post(`${process.env.VUE_APP_API_BASE_URL}/rastreabilidades`, this.rastreabilidade);

            request
                .then(() => {
                    this.$emit("saved");
                    this.closeModal();
                })
                .catch((error) => {
                    console.error("Erro ao salvar alterações:", error);
                });
        },
        closeModal() {
            this.isVisible = false;
        },
        openBuscaClienteModal() {
            this.isBuscaClienteModalVisible = true;
        },
        selecionarCliente(cliente) {
            this.rastreabilidade.cliente_id = cliente.id;
            this.clienteNome = cliente.nome;
            this.isBuscaClienteModalVisible = false;
        },
        openBuscaProdutoModal() {
            this.isBuscaProdutoModalVisible = true;
        },
        selecionarProduto(produto) {
            this.rastreabilidade.produto_id = produto.id;
            this.produtoNome = produto.produto;
            this.isBuscaProdutoModalVisible = false;
        },
    },
};
</script>

<style scoped>
/* Personalize estilos se necessário */
</style>