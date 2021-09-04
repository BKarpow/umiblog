<template>
    <div class="container">
        <div class="row justify-content-center align-items-center">
           <div class="col-md-8">
               <div class="input-group">
                   <div class="custom-file">
                       <input type="file"
                              class="custom-file-input"
                              id="file"
                              ref="file"
                              @change="handleFileUpload">
                       <label class="custom-file-label" for="file"> <slot></slot> </label>
                   </div>
                   <div class="input-group-append">
                       <button
                           class="btn btn-outline-secondary"
                           type="button" @click="submitFile">Вивантажити фото</button>
                   </div>
               </div>
               <div class="progress mt-2" v-if="uploadPercentage !== 0" style="height: 40px;">
                   <div
                       class="progress-bar"
                       role="progressbar"
                       :style="percentageStyle"
                       :aria-valuenow="uploadPercentage"
                       :aria-valuemin="0" aria-valuemax="100">{{percentageText}}</div>
               </div>

               <div v-if="avatars.length" class="mt-2 p-1 d-flex justify-content-center align-items-center">
                   <div class="d-block" v-for="a in avatars">
                       <img class="img-thumbnail" :src="a" alt="">
                       <input type="hidden" name="image" :value="a">
                   </div>
                   <!-- /.d-block -->

               </div>
               <!-- /.mt-2 p-1 -->
           </div>
           <!-- /.col-md-8 -->
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2'
export default {
    props: ['uri', 'workerId'],
    data(){
        return {
            file: '',
            uploadPercentage: 0,
            avatars: []
        }
    },
    computed:{
        percentageStyle(){
            return `width: ${this.uploadPercentage}%;`;
        },
        percentageText(){
            return `${this.uploadPercentage}%`;
        }
    },
    methods: {
        handleFileUpload(){
            this.file = this.$refs.file.files[0];
        },
        submitFile(){

            let formData = new FormData();
            formData.append('image', this.file);
            axios.post( '/ajax/upload/image',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function(progressEvent) {
                        this.uploadPercentage = parseInt(Math.round(( progressEvent.loaded / progressEvent.total) * 100));
                    }.bind(this)
                }
            ).then(r => {
                if (r.data.ok){
                    this.avatars = [r.data.data.path]
                    Swal.fire({
                        icon: 'success',
                        title: 'Фото завантажено!',
                        timer:956
                    })
                    this.$emit('success', this.avatars);

                }
            })
                .catch(function(){
                    console.log('FAILURE!!');
                });
        },
    }
}
</script>
