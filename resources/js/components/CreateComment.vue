<template>
    <div id="createCommentForm">
        <h4 >Створити коментар</h4>
        <div class="form-group comment">
            <textarea
                cols="30"
                rows="10"
                v-model="comment"
                class="comment__control"
                placeholder="Текст коментаря"
            ></textarea>
            <span v-if="comment.length" class="len">Символів залишилось: {{getLen}}.</span>
        </div>
        <!-- /.form-group -->
        <div class="form-g" v-if="showButton">
            <button type="button" @click="createNew">
                Опублікувати
            </button>
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /#createCommentForm -->
</template>

<script>
export default {
    props: ['articleId'],
    data() {
        return {
            comment: '',
            maxLength: 250,
        }
    },
    computed: {
        showButton(){
            if (this.comment.length > 3) {
                return true;
            }
            return false;
        },
        getLen() {
            return (this.maxLength - this.comment.length);
        }
    },
    watch: {
        comment(){
            this.comment = this.comment.substring(0, 250);
        }
    },
    methods: {
        getDataForm(){
            return {
                article_id: this.$props.articleId,
                comment: this.comment,
            }
        },
        createNew() {
            route('comment.create')
            .then(r => {
                axios.post(r.data.uri, this.getDataForm())
                .then(resp => {
                    if (resp.data.ok) {
                        console.log(resp.data.message);
                        this.$emit('success', resp.data.message);
                        this.comment = '';
                    }
                }).catch(err => console.error(err))
            }).catch(err => console.error(err))
        },
    }
}
</script>

<style scoped lang="scss">
.form-g{
    display: flex;
    justify-content: flex-end;
    button{
        padding: 1rem;
        background: indigo;
        color: #fff;
        border: 1px solid #383838;
        border-radius: 6px;
        transition: all .8s ease;
        &:hover{
            background: darken( indigo, 15);
            border-radius: 9px;
            transition: all .8s ease;
        }
    }
}
    .comment{
        display: flex;
        flex-direction: column;
        column-gap: .7rem;
        textarea{
            outline: none;
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 1px solid skyblue;
            padding: .6rem .4rem;
            height: 4rem;
        }
        span{
            display: block;
            text-align: right;
            padding: .2rem .2rem;
            color: #383838;
        }
    }
</style>
