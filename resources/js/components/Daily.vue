<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Início do card de busca -->
                 <card-component titulo="Busca de preço de diárias">
                    <template v-slot:conteudo>
                        <div class="card-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <input-container-component titulo="ID" id="InputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do registro">
                                        <input type="number" class="form-control"  id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                    </input-container-component>
                                </div>
                                <div class="col mb-3">
                                    <input-container-component titulo="Diárias" id="InputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o Diárias">
                                        <input type="text" class="form-control"  id="inputNome" aria-describedby="nomeHelp" placeholder="Diárias" v-model="busca.name">
                                    </input-container-component>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-end" @click="pesquisar()"><i class="bi bi-search"></i>Pesquisar</button>
                    </template>
                 </card-component>
                <!-- Fim do Card de busca -->

                <!-- Início do card de Listagem de tipos de quartos -->
                <card-component titulo="Relação de preço de diárias" class="mt-4">
                    <template v-slot:conteudo>
                        <table-component 
                            :dados="dailies.data"
                            :visualizar="{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalDailiesVisualizar' }"
                            :atualizar="{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalDailiesAtualizar' }"
                            :remover="{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalDailiesRemover' }"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                price: {titulo: 'Preço', tipo: 'texto'},
                                type_of_room_id: {titulo: 'ID tipo de Quarto', tipo: 'texto'},
                                created_at: {titulo: 'Data de criação', tipo: 'data'},
                            }"
                        >
                        </table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10 d-flex justify-content-center">
                                <paginate-component>
                                    <li v-for="l, key in dailies.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item' " @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalTypesRoom">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- Fim do Card de de Listagem de tipos de quartos -->
            </div>
        </div>

        <!-- Início do modal inclusão Diárias -->
        <modal-component id="modalTypesRoom" titulo="Adicionar Diárias">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes"  titulo="Erro ao cadastrar o Diárias" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <select-container
                        titulo="Tipo de quarto"
                        texto="Selecione um tipo de quarto"
                        :items="typeRooms"
                        selectId="tipoDeQuartoSelect"
                        v-model="selectedRoomType"
                    ></select-container>
                    <input-container-component titulo="Preço da Diária" id="novoPrice" id-help="priceHelp" texto-ajuda="Informe o preço da diária" >
                        <input type="number" step="0.01" min="0.01" class="form-control"  id="novoPrice" aria-describedby="priceHelp" placeholder="Preço" v-model="precoDiaria">
                    </input-container-component>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar">Salvar</button>
            </template>
        </modal-component>
        <!-- Fim do modal inclusão Diárias -->

        <!-- Início do modal visualização Diárias --> 
        <modal-component id="modalDailiesVisualizar" titulo="Visualizar Diárias">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <div class="row form-group">
                    <div class="col">
                        <input-container-component titulo="ID">
                            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container-component>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col mb-6">
                        <select-container
                        titulo="Tipo de quarto"
                        selectId="tipoDeQuartoSelect"
                        :items="typeRooms"
                        v-model="$store.state.item.type_of_room_id"
                        :disabled="true"
                    ></select-container>
                    </div>
                    
                    <div class="col mb-6">
                        <input-container-component titulo="Preço da Diária">
                            <input type="number" class="form-control" :value="$store.state.item.price" disabled>
                        </input-container-component>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input-container-component titulo="Data de Criação">
                            <input type="text" class="form-control" :value="$store.state.item.created_at | formataDataTempoGlobal"  disabled>
                        </input-container-component> 
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- Fim do modal visualização Diárias -->

        <!-- Início do modal remoção Diárias --> 
        <modal-component id="modalDailiesRemover" titulo="Remoção Diárias">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <div class="row">
                    <div class="col">
                        <input-container-component titulo="ID">
                            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container-component>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-6">
                        <select-container
                            titulo="Tipo de quarto"
                            selectId="tipoDeQuartoSelect"
                            :items="typeRooms"
                            v-model="$store.state.item.type_of_room_id"
                            :disabled="true"
                        ></select-container>
                    </div>
                    <div class="col mb-6">
                        <input-container-component titulo="Preço da Diária">
                            <input type="number" class="form-control" :value="$store.state.item.price" disabled>
                        </input-container-component>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input-container-component titulo="Data de Criação">
                            <input type="text" class="form-control" :value="$store.state.item.created_at | formataDataTempoGlobal"  disabled>
                        </input-container-component> 
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger"  @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>
        <!-- Fim do modal remoção Diárias -->
        
        <!-- Início do modal atualização Diárias -->
        <modal-component id="modalDailiesAtualizar" titulo="Atualizar Preço da Diária">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                        <select-container
                        titulo="Tipo de quarto"
                        selectId="tipoDeQuartoSelect"
                        :items="typeRooms"
                        v-model="$store.state.item.type_of_room_id"
                        :disabled="false"
                    ></select-container>
                    <input-container-component titulo="Preço da diárias" id="atualizarPrice" id-help="atualizarPriceHelp" texto-ajuda="Informe o preço da diárias" >
                        <input type="number" step="0.01" min="0.01" class="form-control"  id="atualizarPrice" aria-describedby="atualizarPriceHelp" placeholder="Diárias" v-model="$store.state.item.price">
                    </input-container-component>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar">Atualizar</button>
            </template>
        </modal-component>
        <!-- Fim do modal inclusão Diárias -->
    </div>
    
</template>

<script>
import Paginate from './Paginate.vue'    
import SelectContainer from './SelectContainer.vue';
    export default {
        components: {Paginate, SelectContainer},
        data() {
            return {
                urlBase: 'http://127.0.0.1:8000/api/v1/dailies',
                urlPaginacao:'',
                urlFiltro:'',
                precoDiaria: '',
                transacaoStatus: '',
                selectedRoomType: '',
                transacaoDetalhes:{},
                dailies:{ data:[] },
                typeRooms:[],
                busca:{ id:'', name:'', }
            }
        },
        
        methods: {
            pesquisar() {
                
                let filtro = '';

                for(let chave in this.busca) {
                    
                    if(this.busca[chave]) {
                        
                        if(filtro != '') {
                            filtro += ";"
                        }
                    
                        filtro += chave + ':like:' + this.busca[chave]
                    }
                }
                if(filtro != '') {
                    this.urlPaginacao = 'page=1'
                    this.urlFiltro = '&filtro='+filtro
                } else {
                    this.urlFiltro = ''
                }

                this.carregarLista()
            },

            paginacao(l) {
                if (l.url) {
                    this.urlPaginacao = l.url.split('?')[1]
                    this.carregarLista()
                }   
            },
            carregarLista() {

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
                
                axios.get(url)
                    .then(response => {
                        this.dailies = response.data                      
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            salvar(){
               
                let formData = new FormData()

                formData.append('type_of_room_id', this.selectedRoomType) 
                formData.append('price', this.precoDiaria)

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                       
                        this.transacaoStatus = 'adicionado'
                        this.transacaoDetalhes = {
                            mensagem: 'ID do registro: ' + response.data.id
                        }
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        }  
                       
                    });
            },
            atualizar(){
               
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                let formData = new FormData()
                formData.append('_method', 'PATCH')
                formData.append('price', this.$store.state.item.price)
                formData.append('type_of_room_id', this.$store.state.item.type_of_room_id)

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.success
                        this.carregarLista()
                    })
                    .catch(errors => {
                        console.log("Os erros aqui ",errors.response.data)
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })
            },
            remover() {
                let confimacao = confirm('Tem certeza que deseja remover esse registro?')

                if (!confimacao) {
                    return false
                }

                let formData = new FormData()
                formData.append('_method', 'delete')
                
                let url = this.urlBase + '/' + this.$store.state.item.id
  
                axios.post(url, formData)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.success
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.error
                    })
            },
            carregarTypeRooms() {

                let url = 'http://127.0.0.1:8000/api/v1/all-type-rooms'
                
                axios.get(url)
                    .then(response =>{
                        this.typeRooms = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            }
        },
        mounted() {
           this.carregarLista(),
           this.carregarTypeRooms()
        }
    }
</script>
