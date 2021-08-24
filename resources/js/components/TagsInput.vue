<template>
    <div id="input-tags">
        <input
            type="text"
            class="tags__input"
            v-model="tags"
            placeholder="Вкажіть теги через кому"
        >
        <div class="create my-2" v-if="createBox">
            <button type="button" @click="createNewTag" class="btn btn-success">
                Створити "{{tags}}"
            </button>
        </div>
        <div class="tags__list-search" v-else>
            <ul class="border" v-if="tagsSearchList.length">
                <li v-for="tag in searchResult" @click="addToSelect(tag)" :key="tag.id">
                    {{tag.name}}
                </li>
            </ul>
        </div>
        <div class="tags__list" v-if="tagsList.length">
            <h4 class="text-center">
                Теги запису
            </h4>
            <!-- /.text-center -->
            <ul>
                <li v-for="tag in tagsList" :key="tag.id">
                    {{tag.name}}
                    <span class="btn-delete" @click="deleteSelectTag(tag.id)">&times;</span>
                    <!-- /.btn-delete -->
                </li>
            </ul>
        </div>
        <!-- /.tags__list -->
        <input type="hidden" name="tags" :value="jsonTagsObject">
    </div>
    <!-- /#input-tags -->
</template>

<script>
export default {
    data(){
        return {
            tags: '',
            createBox: false,
            tagsList: [],
            tagsSearchList: [],
        }
    },
    computed:{
        jsonTagsObject(){
            return JSON.stringify(this.tagsList)
        },
        searchResult(){
            return this.tagsSearchList.filter(item => {
                let res = true
                this.tagsList.forEach(it => {
                    if (typeof it['id'] !== 'undefined') {
                        if (it.id === item.id){
                            res = false;
                        }
                    }

                })
                return res
            })
        }
    },
    watch:{
        tags(){
            if (this.tags.length > 3 && this.tags.length < 35) {
                this.getSearchResult()
            } else {
                this.setDefaultStateNotTags()
            }

        }
    },
    methods:{
        setDefaultStateNotTags(){
            this.createBox = false;
            // this.tagsList = [];
            this.tagsSearchList = [];
        },
        deleteSelectTag(tagId){
            this.tagsList = this.tagsList.filter(item => {
                if (item.id === tagId) {
                    return false;
                } else {
                    return true;
                }
            })
        },
        isTagNotExists(responseData) {
            if (typeof responseData.data !== 'undefined') {
                return responseData.data.length === 0;
            }
            return false;
        },
        getSearchResult(){
            axios.post('/api/tag/search', {s: this.tags})
            .then(resp => {
                if (this.isTagNotExists(resp.data)) {
                    this.createBox = true;
                    this.tagsSearchList = [];
                } else {
                    this.createBox = false;
                    resp.data.data.forEach(item => {
                        this.tagsSearchList.push(item)
                    })
                }
            })
        },
        addToSelect(item){
            this.tagsList.push(item)
            this.tags = '';
            this.tagsSearchList = [];
            this.createBox = false
        },
        createNewTag(){
            axios.post('/api/tag/create', {name:this.tags})
            .then(resp => {
                if (resp.data.ok) {
                    this.addToSelect(resp.data.data)
                    this.createBox = false;
                    this.tags = '';
                }
            })
        }
    }
}
</script>

<style scoped lang="scss">
@mixin ulMix(){
    ul{
        list-style: none;
        padding: .3rem .5rem;
        margin: 0;
        display: flex;
        flex-direction: column;
        column-gap: .7rem;
        li{
            font-size: 16px;
            font-weight: bold;
            transition: all .5s;
            padding-left: 1rem;
            cursor: pointer;
            &:hover{
                background: #383838;
                color: #fcfcfc;
                transition: all .5s;
            }
        }
    }
}

    .btn-delete{
        width: 20px;
        height: 20px;
        background: #383838;
        color: #fcfcfc;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        border-radius: 50%;
        transition: all .5s;
        &:hover{
            width: 20px;
            height: 20px;
            transition: all .5s;
        }
    }

    .tags__input{
        outline: none;
        border: 1px solid #383838;
        padding: .7rem 1rem;
        border-radius: 16px;
        width: 100%;
        margin: 1rem auto;
    }
    .tags__list-search{
        position: relative;
        .border{
            position: absolute;
            top: -1rem;
            left: 0;
            right: 0;
            border: 1px solid #383838;
            border-radius: 16px;
        }
        @include ulMix;
    }

    .tags__list{
        margin: 1rem 1rem;
        border: 1px solid #383838;
        border-radius: 16px;
        padding: .7rem;
        @include ulMix;
    }
</style>
