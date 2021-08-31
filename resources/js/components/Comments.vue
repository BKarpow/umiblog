<template>
    <div id="commentsBox">
        <create-comment
            @success="fetchComments"
            :article-id="articleId"
        />

        <div class="comments">
            <CommentsList 
                :comments="commentsList" 
                :load="load" 
                @more="fetchComments"
            />
            
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
            limit: 20,
            offset: 0,
            load: false,
        }
    },
    methods:{
        getFetchUri(uri) {
            let uriParams = uri + '?'
            uriParams += 'article_id=' + this.articleId + '&';
            uriParams += 'limit=' + this.limit + '&';
            uriParams += 'offset=' + this.offset;
            return uriParams
        },
        fetchComments(){
            this.load = true;
            route('api.comment.fetch')
            .then(ro => {
                axios.get(this.getFetchUri(ro.data.uri)).then(resp => {
                    if (resp.data.ok) {
                        this.commentsList = _.concat(this.commentsList, resp.data.data);
                        this.load = false;
                        this.offset += this.limit;
                    } else {
                        console.error(resp.data.message)
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
