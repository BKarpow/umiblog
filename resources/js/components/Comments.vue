<template>
    <div id="commentsBox">
        <create-comment
            @success="fetchComments"
            :article-id="articleId"
        />

        <div class="comments">
            <ul class="comments__list">
                <li
                    v-for="comment in commentsList"
                    :key="comment.id"
                    class="comment-item"
                >
                    <div class="comment-body">
                        <div class="comment-avatar">
                            <img :src="comment.avatar"
                                 class="img-thumbnail"
                                 :alt="comment.author" />
                        </div>
                        <!-- /.comment-avatar -->
                        <div class="comment-author">
                            <strong>{{comment.author}}</strong>
                        </div>
                        <!-- /.comment-author -->
                        <div class="comment-text">
                            {{comment.comment}}
                        </div>
                        <!-- /.comment-text -->
                        <div class="comment-meta">
                            <small> {{comment.created_at}} </small>
                        </div>
                        <!-- /.comment-meta -->
                    </div>
                    <!-- /.comment-body -->
                </li>
                <!-- /.comment-item -->
            </ul>
            <!-- /.comments__list -->
        </div>
        <!-- /.comments -->
    </div>
    <!-- /#commentsBox -->
</template>

<style scoped lang="scss">
ul{
    list-style: none;
    padding: .7rem .3rem;
    display: flex;
    flex-direction: column;
    row-gap: .4rem;
    li{
        padding: .6rem;
        border-radius: 9px;
        background: #383838;
        color: #fff;
    }
}

    .comment-body{
        display: grid;
        grid-template-columns: 4rem 1fr;
        grid-template-rows: repeat(3, 1fr);
        column-gap: .7rem;
        .comment-avatar{
            grid-column: 1/2;
            grid-row: 1/4;
        }
        .comment-author{
            grid-column: 2/3;
            grid-row: 1/2;
        }
        .comment-text{
            grid-column: 2/3;
            grid-row: 2/3;
        }
        .comment-meta{
            grid-column: 2/3;
            grid-row: 3/4;
        }
    }
</style>

<script>
export default {
    props: ['articleId'],
    data(){
        return {
            commentsList: [],
        }
    },
    methods:{
        fetchComments(){
            route('api.comment.get')
            .then(ro => {
                const uri = ro.data.uri + '?article_id=' + this.$props.articleId;
                axios.get(uri).then(resp => {
                    if (resp.data.ok) {
                        this.commentsList = resp.data.data;
                    }
                }).catch(err => console.log(resp))
            }).catch(err => console.log(resp))
        }
    },
    mounted() {
        this.fetchComments()
    }
}
</script>
