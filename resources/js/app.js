/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('modal-window', require('./components/ModalWindow.vue').default);
Vue.component('create-new-user', require('./components/CreateMewUserForm.vue').default);
Vue.component('create-new-menu', require('./components/CreateNewMenu.vue').default);
Vue.component('update-user', require('./components/UpdateUserModal.vue').default);
Vue.component('new-title', require('./components/NewArticleTitle.vue').default);
Vue.component('tags', require('./components/TagsInput.vue').default);
Vue.component('source-field', require('./components/SourceFields.vue').default);
Vue.component('check-box', require('./components/CheckBox.vue').default);
Vue.component('load-image', require('./components/LoadImage.vue').default);
Vue.component('cart-panel', require('./components/CartPanel.vue').default);
Vue.component('menu-header', require('./components/MenuHeader.vue').default);
Vue.component('create-comment', require('./components/CreateComment.vue').default);
Vue.component('comments', require('./components/Comments.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    methods:{
        showMenu(){
            this.$refs.burgerBtn.classList.add('burger_active');
        },
        hideMenu(){
            this.$refs.burgerBtn.classList.remove('burger_active');
        },
    },
    mounted() {
        document.addEventListener('keydown', ev => {
            if (ev.keyCode === 27) {
                this.$refs.burgerBtn.classList.remove('burger_active');
            }
        });
    }
});
