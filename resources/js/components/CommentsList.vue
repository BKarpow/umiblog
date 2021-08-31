<template>
  <div class="comments">
    <div v-if="comments.length" class="comments__list" >
              <Comment
                  v-for="comment in comments"
                  :key="comment.id"
                  :comment-id="comment.id"
                  :comment="comment.comment"
                  :author-name="comment.author"
                  :author-avatar="comment.avatar"
                  :date="comment.date"
               />
      </div>
      <!-- /.comments__list -->
      <div v-if="problem" class="text-center py-2">
        <h3>Вибачте, але коментарів не вдалося знайти за вказаними параметрами :(</h3>
      </div>
      <!-- /.text-center py-2 -->
      <div v-if="!problem" class="comments__more mt-2">
        <Spinner v-if="load" />
        <button v-else ref="btn" type="button" @click="showMore">
          Показати ще...
        </button>
      </div>
      <!-- /.article__more -->
  </div>
  <!-- /.article -->
</template>

<script>


export default {
  props: {
    comments: {
      type: Array,
      default: [],
    },
    load: {
      type: Boolean,
      default: true,
    }
  }, 
  data(){
    return {
      problem: false,
    }
  },
  
  methods:{
    isVisible(elem) {
      let coords = elem.getBoundingClientRect();
      let windowHeight = document.documentElement.clientHeight;
      // верхний край элемента виден?
      let topVisible = coords.top > 0 && coords.top < windowHeight;
      // нижний край элемента виден?
      let bottomVisible = coords.bottom < windowHeight && coords.bottom > 0;
      return topVisible || bottomVisible;
    },
    scrollList(){
      if (this.isVisible(this.$refs.btn)) {
        this.showMore();
      }
    },
    showMore(){
      this.$emit('more', true)
    },
  },
  mounted(){
    document.addEventListener('scroll', this.scrollList);
    if (this.comments.length === 0){
      setTimeout(()=>{
        if (this.comments.length === 0){ 
          this.problem = true;
        }
      }, 4000)
    }
  }
}
</script>

<style scoped lang="scss">
  .comments{
    display: flex;
    flex-direction: column;
    column-gap: .7rem;
    &__more{
      button{
        outline: none;
        background: inherit;
        width: 100%;
        padding: 1rem;
        text-transform: uppercase;
        font-size: 20px;
        font-weight: bold;
        letter-spacing: 4px;
        transition: all .8s ;
        border: 1px solid black;
        &:hover{
          background: tomato;
          border-radius: 9px;
        }
      }
    }
  }
</style>
