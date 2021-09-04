<template>
    <div class="categoryBox">

        <div class="modal fade" ref="modalEdit" :id="modalId" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Редагувати категорію</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Категорія</label>
                            <input type="text" id="name"
                                   v-model="name" class="form-control"
                            >
                            <!-- /.form-control -->
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label for="description">Опис категорії</label>
                            <textarea
                                id="description"
                                v-model="description"
                                class="form-control"></textarea>
                            <!-- /.form-control -->
                        </div>
                        <!-- /.form-group -->
                        <load-image @success="setImage" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button @click="updateSubmit" type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <h5>{{categories.name}}</h5>
        <div class="my-1 d-flex justify-content-end">
            <EditDeleteButtons @edit="getModal" @delete="onDelete"/>
        </div>
        <!-- /.my-1 -->
        <p>{{categories.description}}</p>

    </div>
    <!-- /.categoryBox -->
</template>

<script>
import Swal from "sweetalert2";

export default {
    props: {
        categories: {
            type: Object,
        }
    },
    data(){
        return {
            name: this.categories.name,
            description: this.categories.description,
            image: '',
        }
    },
    computed:{
        modalId(){
            return 'categoryItemId-' + this.categories.id;
        }
    },
    methods:{
        setImage(image){
            this.image = image[0];
        },
        onDelete(){
            route('panel.api.deleteCategory')
                .then(uri => {
                    axios.post(uri.data.uri, {category_id: this.categories.id})
                        .then(resp => {
                            if (resp.data.ok) {
                                Swal.fire({
                                    title: 'Category deleted',
                                    icon: 'success',
                                })
                                this.$emit('success', true)
                            } else {
                                Swal.fire({
                                    title: 'Error deleted',
                                    icon: 'error'
                                })
                            }
                        }).catch(err => {
                        Swal.fire({
                            title: 'Error deleted, incorrect data valid',
                            icon: 'error'
                        })
                    })
                }).catch(err => {
                Swal.fire({
                    title: 'Error getting name route.',
                    icon: 'error'
                })
            })
        },
        getData(){
            return {
                name: this.name,
                description: this.description,
                image: this.image,
                category_id: this.categories.id
            }
        },
        getModal(){
            $(this.$refs.modalEdit).modal('toggle');
        },
        updateSubmit(){
            route('panel.api.updateCategory')
                .then(uri => {
                    axios.post(uri.data.uri, this.getData())
                        .then(resp => {
                            if (resp.data.ok) {
                                Swal.fire({
                                    title: 'Категорію товарів оновлено',
                                    icon: 'success'
                                })
                                this.$emit('success', true)
                            } else {
                                Swal.fire({
                                    title: 'Error update category, (error in your data)',
                                    icon:'error',
                                })
                            }
                        }).catch(err => {
                        Swal.fire({
                            title: 'Error update category',
                            icon:'error',
                        })
                    })
                }).catch(err => {
                Swal.fire({
                    title: 'Error getting route name',
                    icon:'error',
                })
            })
        }
    }
}
</script>

<style scoped lang="scss">
h5{
    font-weight: bold;
}
p{
    color: #ccc;
    font-size: 13px;
}
</style>
