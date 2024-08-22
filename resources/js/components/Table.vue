<template>
    <div>
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key" >{{t.titulo}}</th>
                    <th v-if="visualizar.visivel || atualizar || remover"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'texto'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{ valor | formataDataTempoGlobal }}</span>
                    </td>
                    <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                        <button v-if="visualizar.visivel" class="btn btn-outline-secondary btn-sm" :data-bs-toggle="visualizar.dataBsToggle" :data-bs-target="visualizar.dataBsTarget" @click="setStore(obj)"><i class="bi bi-eye"></i></button>
                        <button v-if="atualizar" class="btn btn-outline-primary btn-sm" :data-bs-toggle="remover.dataBsToggle" :data-bs-target="atualizar.dataBsTarget" @click="setStore(obj)"><i class="bi bi-pencil"></i></button>
                        <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm" :data-bs-toggle="remover.dataBsToggle" :data-bs-target="remover.dataBsTarget" @click="setStore(obj)"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
       
        props: ['dados', 'titulos','visualizar','atualizar','remover'],
        computed: {
            dadosFiltrados() {

                let campos = Object.keys(this.titulos)
                let dadosFiltrados = []
                
                this.dados.map((item, chave) =>{
                    
                    let itemFiltrado = {}
                    campos.forEach(campo => {

                        itemFiltrado[campo] = item[campo]
                    })
                    dadosFiltrados.push(itemFiltrado)
                })

                return dadosFiltrados
            }
        },
        methods: {
            setStore(obj) {
                this.$store.state.transacao.status = ''
                this.$store.state.transacao.mensagem = ''
                this.$store.state.transacao.dados = ''
                this.$store.state.item = obj
            }
        }
    }
</script>
