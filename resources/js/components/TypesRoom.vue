<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Início do card de busca -->
                 <card-component titulo="Busca de Tipo de Quartos">
                    <template v-slot:conteudo>
                        <div class="card-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <input-container-component titulo="ID" id="InputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do registro">
                                        <input type="number" class="form-control"  id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                    </input-container-component>
                                </div>
                                <div class="col mb-3">
                                    <input-container-component titulo="Tipo do Quarto" id="InputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o Tipo do Quarto">
                                        <input type="text" class="form-control"  id="inputNome" aria-describedby="nomeHelp" placeholder="Tipo do Quarto" v-model="busca.name">
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
                <card-component titulo="Relação de Tipo de Quartos" class="mt-4">
                    <template v-slot:conteudo>
                        <table-component 
                            :dados="typeRooms.data"
                            :visualizar="{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalTypesRoomVisualizar' }"
                            :atualizar="{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalTypesRoomAtualizar' }"
                            :remover="{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalTypesRoomRemover' }"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                name: {titulo: 'Nome', tipo: 'texto'},
                                created_at: {titulo: 'Data de criação', tipo: 'data'},
                            }"
                        >
                        </table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10 d-flex justify-content-center">
                                <paginate-component>
                                    <li v-for="l, key in typeRooms.links" :key="key"
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

        <!-- Início do modal inclusão Tipo de Quarto -->
        <modal-component id="modalTypesRoom" titulo="Adicionar Tipo de Quarto">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes"  titulo="Erro ao cadastrar o tipo de quarto" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Tipo do Quarto" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o Tipo do Quarto" >
                        <input type="text" class="form-control"  id="novoNome" aria-describedby="novoNomeHelp" placeholder="Tipo do Quarto" v-model="nomeTipoQuarto">
                    </input-container-component>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar">Salvar</button>
            </template>
        </modal-component>
        <!-- Fim do modal inclusão Tipo de Quarto -->

        <!-- Início do modal visualização Tipo de Quarto --> 
        <modal-component id="modalTypesRoomVisualizar" titulo="Visualizar Tipo de Quarto">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <div class="row">
                    <div class="col mb-6">
                        <input-container-component titulo="ID">
                            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container-component>
                    </div>
                    <div class="col mb-6">
                        <input-container-component titulo="Tipo de Quarto">
                            <input type="text" class="form-control" :value="$store.state.item.name" disabled>
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
        <!-- Fim do modal visualização Tipo de Quarto -->

        <!-- Início do modal remoção Tipo de Quarto --> 
        <modal-component id="modalTypesRoomRemover" titulo="Remoção Tipo de Quarto">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>
            
                <input-container-component titulo="Tipo de Quarto">
                    <input type="text" class="form-control" :value="$store.state.item.name" disabled>
                </input-container-component>   
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger"  @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>
        <!-- Fim do modal remoção Tipo de Quarto -->
        
        <!-- Início do modal atualização Tipo de Quarto -->
        <modal-component id="modalTypesRoomAtualizar" titulo="Atualizar Tipo de Quarto">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Tipo do Quarto" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o Tipo do Quarto" >
                        <input type="text" class="form-control"  id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Tipo do Quarto" v-model="$store.state.item.name">
                    </input-container-component>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar">Atualizar</button>
            </template>
        </modal-component>
        <!-- Fim do modal inclusão Tipo de Quarto -->
    </div>
    
</template>

<script>
import Paginate from './Paginate.vue'    
    export default {
        components: {Paginate},
        data() {
            return {
                urlBase: 'http://127.0.0.1:8000/api/v1/type-rooms',
                urlPaginacao:'',
                urlFiltro:'',
                nomeTipoQuarto: '',
                transacaoStatus: '',
                transacaoDetalhes:{},
                typeRooms:{ data:[] },
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
                console.log(url)
                axios.get(url)
                    .then(response => {
                        console.log('Resposta completa:', response.data);
                        this.typeRooms = response.data                      
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            salvar(){
                console.log(this.nomeTipoQuarto)

                let formData = new FormData();
                formData.append('name', this.nomeTipoQuarto)

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
                        this.nomeTipoQuarto = ''
                    });
            },
            atualizar(){
                console.log(this.$store.state.item)

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                let formData = new FormData()
                formData.append('_method', 'PATCH')
                formData.append('name', this.$store.state.item.name)

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.success
                        this.carregarLista()
                    })
                    .catch(errors => {
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
        },
        mounted() {
           this.carregarLista()
        }
    }
</script>
