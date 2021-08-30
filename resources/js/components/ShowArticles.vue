<template>
  <div class="article">
    <div v-if="articles.length" class="article__list">
              <cart-panel
                  v-for="article in articles"
                  :key="article.id"
                  :title="article.title"
                  :image="article.image"
                  :short-content="article.short_content"
                  :href="article.href"
              >
              </cart-panel>
      </div>
      <!-- /.article__list -->
      <div v-if="problem" class="text-center py-2">
        <h3>Вибачте, але статтей не вдалося знайти за вказаними параметрами :(</h3>
      </div>
      <!-- /.text-center py-2 -->
      <div v-if="!problem" class="article__more mt-2">
        <Spinner v-if="load" />
        <button v-else type="button" @click="showMore">
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
    articles: {
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
    showMore(){
      this.$emit('more', true)
    },
  },
  mounted(){
    if (this.articles.length === 0){
      setTimeout(()=>{
        if (this.articles.length === 0){ 
          this.problem = true;
        }
      }, 4000)
    }
  }
}
</script>

<style scoped lang="scss">
  .article{
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
