<template>
  <div id="listArticleFromTag">
    <show-articles :articles="articles" :load="load" @more="fetchArticles" />
  </div>
  <!-- /#listArticleFromTag -->
</template>

<script>
export default {
  props:{
      tag:{
        type: String,
        default: '',
      }
    },

  data(){
    
    return {
      articles: [],
      perPage: 9,
      offset: 0,
      load: false,
    }
  },

  methods: {
    getParamsFromGetArticle(uri){
      let params = uri + '?';
      params += 'tag=' + this.tag + '&';
      params += 'limit=' + this.perPage + '&';
      params += 'offset=' + this.offset;
      return params;
    },
    fetchArticles() {
      this.load = true;
      route('api.article.get')
        .then(resp => {
          const uri = this.getParamsFromGetArticle(resp.data.uri)
          console.log("Uri from article get",uri)
          axios.get(uri)
            .then(r => {
              if (r.data.ok) {
                this.articles = _.concat(this.articles, r.data.data)
                this.offset += this.perPage;
                this.load = false;
              } else {
                console.error(r.data.message)
              }
            }).catch(e => console.error(e))
        }).catch(e => console.error(e))
    },
  },
  mounted(){
    this.fetchArticles()
  }
}
</script>