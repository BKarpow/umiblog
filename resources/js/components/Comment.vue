<template>
  <div :id="commentID" class="comment__item">
    <div class="avatar">
        {{authorAvatar}}
<!--        <img :src="authorAvatar" :alt="authorName" class="avatar__item img_fluid" />-->
    </div>
    <!-- /.avatar -->
    <div class="title">
      <strong>{{authorName}}</strong>
    </div>
    <!-- /.title -->
    <div class="body">
      <p>{{comment}}</p>
    </div>
    <!-- /.body -->
    <div class="meta">
      <small> {{date}} </small>
    </div>
    <!-- /.meta -->
  </div>
</template>

<script>
export default {
  props: {
    commentId:{
      type:Number,
      default: 0
    },
    comment:{
      type: String,
      default: '',
    },
    authorName:{
      type:String,
      default: '',
    },
    authorAvatar:{
      type:String,
      default: '',
    },
    date:{
      type:String,
      default: '',
    }
  },
  computed:{
    commentID(){
      return 'comment-' + this.commentId;
    },
  }
}
</script>

<style scoped lang="scss">
p{
  margin-top: .6rem;
  line-height: 15px;
}
.comment__item{
  display: grid;
  grid-template-columns: 75px 1fr;
  grid-template-rows: 16px 1fr 14px;
  padding: .8rem;
  border:1px solid #383838;
  border-radius:9px;
  column-gap: .7rem;
  margin: .6rem auto;
  .avatar{
    grid-column: 1/2;
    grid-row: 1/4;
  }
  .title{
    grid-column: 2/3;
    grid-row: 1/2;
  }
  .body{
    grid-column: 2/3;
    grid-row: 2/3;
  }
  .meta{
    grid-column: 2/3;
    grid-row: 3/4;
  }
}
</style>
