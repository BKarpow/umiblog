<template>
  <div id="listArticleFromTag">
    <show-articles :articles="articles" :load="load" @more="fetchArticles" />
  </div>
  <!-- /#listArticleFromTag -->
</template>

<script>
export default {
  
  data(){
    
    return {
      articles: [],
      perPage: 36,
      offset: 0,
      load: false,
    }
  },

  methods: {
    getParamsFromGetArticle(uri){
      let params = uri + '?';
      params += 'limit=' + this.perPage + '&';
      params += 'offset=' + this.offset;
      return params;
    },
    fetchArticles() {
      this.load = true;
      route('api.article.main')
        .then(resp => {
          const uri = this.getParamsFromGetArticle(resp.data.uri)
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