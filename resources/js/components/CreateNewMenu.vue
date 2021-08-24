<template>
    <div id="createMenu">
        <modal-window
            modal-id="createNewMenu"
            title="Створити пункт меню"
            button-text-open="Створити новий пункт"
            button-text-success="Зберегти"
            button-text-close="Відиіна"
            @success="createNew"
        >
            <div class="form">
                <div class="form__group">
                    <label for="name_menu">Створити нову позицію меню</label>
                    <input
                        type="text"
                        id="name_menu"
                        v-model="menu"
                        placeholder="Назва меню"
                    >
                    <h5 v-if="menuList.length">Обрати позицію </h5>
                    <ul v-if="menuList.length">
                        <li
                            v-for="(item, index) in menuList"
                            :key="index"
                            @click="changeMenu(item.name_menu)"
                        >
                            {{item.name_menu}}
                        </li>
                    </ul>
                </div>
                <!-- /.form__group -->

                <div class="form__group">
                    <label for="href">Адреса</label>
                    <input
                        type="text"
                        id="href"
                        v-model="href"
                        placeholder="http://example.com"
                    >
                    <h5 v-if="routes.length" >Обрати готовий роут</h5>
                    <select
                        v-if="routes.length"
                        v-model="routeSelect"
                        name="route"
                        id="route">
                        <option v-for="item in routes"
                                :value="item.route">
                            {{item.route}}
                        </option>
                    </select>
                    <span
                        v-if="routeSelect.length"
                        class="msg"
                        @click="disableRouteMode">
                        Відмінити роут mode і вказати адресу вручну
                    </span>
                    <!-- /.msg -->
                </div>
                <!-- /.form__group -->

                <div class="form__group">
                    <label for="title">Заголовок</label>
                    <input
                        type="text"
                        id="title"
                        v-model="title"
                        placeholder="Назва пункту"
                    >
                </div>
                <!-- /.form__group -->
                <div class="form__group-checkbox">
                    <label for="target">Відкривати на окремі сторінці</label>
                    <input v-model="target" type="checkbox" id="target">
                </div>
                <!-- /.form__group -->
            </div>
            <!-- /.form -->
        </modal-window>
    </div>
    <!-- /#createMenu -->
</template>

<script>
    export default {
        data(){
            return {
                menu: '',
                href: '',
                title: '',
                target: false,
                menuList: [],
                routes: [],
                routeSelect: '',

            }
        },
        watch:{
            routeSelect(){
                this.href = this.routeSelect;

            }
        },
        methods:{
            getDataForm(){
                let data = {
                    name_menu: this.menu,
                    href: this.href,
                    title: this.title,
                }
                if (this.routeSelect.length) {
                    data.route = 'true';
                }
                if (this.target) {
                    data.target = 'true';
                }
                return data;
            },
            disableRouteMode(){
                this.href = '';
                this.routeSelect = '';
            },
            changeMenu(menu) {
                this.menu = menu;
            },
            fetchRoutes(){
                axios.get('/api/routes')
                    .then(resp => {
                        if (resp.data.ok){
                            this.routes = resp.data.data;
                        } else {
                            console.error('Error incorrect fetch positions');
                        }
                    }).catch(err => {
                    console.error(err);
                })
            },
            fetchMenus() {
                axios.post('/api/menu/positions')
                .then(resp => {
                    if (resp.data.ok){
                        this.menuList = resp.data.data;
                    } else {
                        console.error('Error incorrect fetch positions');
                    }
                }).catch(err => {
                    console.error(err);
                })
            },
            createNew() {
                route('panel.menu.create.action')
                    .then(resp => {
                        // console.log('URI', resp.data.uri);
                        axios.post(resp.data.uri, this.getDataForm())
                            .then(r => {
                                if (r.data.ok) {
                                    reload();
                                }
                            })
                    })
                    .catch(err => { console.error(err) })
            }
        },
        mounted() {
            this.fetchMenus();
            this.fetchRoutes();
        }
    }
</script>

<style scoped lang="scss">
.msg{
    display: block;
    margin-top: .7rem;
    font-size: 14px;
    text-transform: uppercase;
    padding: 1rem;
    border-radius: 9px;
    background: #1f6fb2;
    cursor: pointer;
}
    .form{
        &__group-checkbox{
            margin-top: .7rem;
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            justify-content: start;
            column-gap: .7rem;
            label{
                line-height: 2px;
                padding: 0;
            }
        }
        &__group{

            label{
                display: block;
            }
            input{
                display: block;
                outline: none;
                padding: .4rem;
                border: 1px solid #333;
                border-radius: 9px;
                width: 100%;
                margin: .3rem auto;
            }
            select{
                margin-top: .7rem;
                padding: .7rem .3rem;
                outline: none;
                background: inherit;
                border: 1px solid #333;
                border-radius: 9px;
            }
            ul{
                list-style: none;
                margin-top: 1rem;
                padding: .7rem .3rem;
                display: flex;
                width: 320px;
                flex-direction: column;
                row-gap: .7rem;
                border: 1px solid #333;
                border-radius: 9px;
                li{
                    display: inline-block;
                    padding-top: .3rem;
                    padding-bottom: .3rem;
                    border-bottom: 1px solid #333;
                    cursor: pointer;
                    text-align: center;
                    text-transform: uppercase;
                    letter-spacing: 5px;
                    transition: all .8s ease;
                    &:hover{
                        background: #333;
                        color: #fff;
                        border-radius: 9px;
                        transition: all .8s ease;
                    }
                }
            }
        }
    }
</style>

