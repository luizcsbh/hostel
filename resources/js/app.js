/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import 'bootstrap-icons/font/bootstrap-icons.css';

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
/* importando e configurando o vuex*/
import Vuex from 'Vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        item: {},
        transacao: { status:'', mensagem: '', dados:'', }
    }
})



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('home-component', require('./components/Home.vue').default);
Vue.component('input-container-component', require('./components/InputContainer.vue').default);
Vue.component('select-container-component', require('./components/SelectContainer.vue').default);
Vue.component('table-component', require('./components/Table.vue').default);
Vue.component('card-component', require('./components/Card.vue').default);
Vue.component('modal-component', require('./components/Modal.vue').default);
Vue.component('alert-component', require('./components/Alert.vue').default);
Vue.component('paginate-component', require('./components/Paginate.vue').default);
Vue.component('login-component', require('./components/Login.vue').default);
Vue.component('type-rooms-component', require('./components/TypesRoom.vue').default);
Vue.component('dailies-component', require('./components/Daily.vue').default);
Vue.component('document-type-component', require('./components/DocumentType.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.filter('formataDataTempoGlobal', function(d){
    if (!d) return ''

    d= d.split('T')

    let data = d[0]
    let tempo = d[1]
    
    data = data.split('-')
    data = data[2] + '/' + data[1] +'/' + data[0]

    tempo = tempo.split('.')
    tempo = tempo[0]
    
    return data + ' ' + tempo
})

const app = new Vue({
    el: '#app',
    store
});
