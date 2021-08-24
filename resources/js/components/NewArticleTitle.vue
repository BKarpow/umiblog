<template>
    <div class="form-group">
        <label for="title">Заголовок</label>
        <input
            type="text"
            placeholder="Заголовок"
            name="title"
            v-model="title"
            @blur="getTran"
            class="form-control"
        >
        <div class="mt-1" v-if="titleTransliteration.length">
            <span>URL: {{titleTransliteration}}</span>
            <input type="hidden" name="url" :value="titleTransliteration">
        </div>
        <!-- /.mt-1 -->
    </div>
    <!-- /.form-group -->
</template>

<script>
    export default {
        data(){
            return {
                title: '',
                titleTransliteration: '',
            }
        },
        methods:{
            getTran(){
                axios.post('/api/transliteration', {text: this.title})
                    .then(resp => {
                        if (resp.data.ok){
                            this.titleTransliteration = resp.data.data.text
                        }
                    })
            }
        }
    }
</script>
