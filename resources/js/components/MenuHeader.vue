<template>
    <nav id="header">
        <ul
            v-if="menuList.length"
            class="burger__body-list"
        >
            <li v-for="item in menuList" :key="item.id">
                <a :href="item.href" :target="item.target">
                    {{ item.title }}
                </a>
            </li>
        </ul>
        <div v-else>
            <h5>Loading menu...</h5>
        </div>
        <!-- #.burger__body-list -->
    </nav>
    <!-- /#header -->
</template>

<script>
export default {
    data(){
        return {
            menuList: [],
            nameMenu: 'Ліве меню',
        }
    },
    methods:{
        fetchMenu(){
            route('api.menu.get')
                .then(r => {
                    const uri = r.data.uri + '?nameMenu=' + this.nameMenu
                    axios.get(uri)
                        .then(resp => {
                            if (resp.data.ok) {
                                this.menuList = resp.data.data;
                            }
                        }).catch(err => console.log(err))
                })
        },
    },
    mounted() {
        this.fetchMenu()
    }
}
</script>
