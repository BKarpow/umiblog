<template>
    <div class="section-product">

        <div class="modal fade" ref="modalEdit" :id="modalId" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Редагувати секцію</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Ім'я секції</label>
                            <input type="text" id="name"
                                   v-model="name" class="form-control"
                                   >
                            <!-- /.form-control -->
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label for="description">Опис секції</label>
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

        <div class="section-title">
            {{sectionData.name}}
            <EditDeleteButtons @edit="editSectionModal" @delete="onDelete" />
        </div>
        <!-- /.section-title -->
        <div class="section-categories">
            <div class="my-1">
                <slot></slot>
            </div>
            <ul class="categories">
                <li v-if="!categories.length" class="empty-category">
                    <h5>Для цієї секції ще не створено категорій.</h5>
                    <p>Для створення натисніть "+".</p>
                </li>
                <li v-else v-for="cat in categories" :key="cat.id">
                   <CategoryCategory
                       :categories="cat"
                       @success="$emit('success', true)"
                   />
                </li>
            </ul>
            <!-- /.categories -->
        </div>
        <!-- /.section-categories -->
    </div>
    <!-- /.sectionProduct -->
</template>

<style scoped lang="scss">
.empty-category{
    h5{
        font-weight: bold;
        line-height: 18px;
        padding: .3rem;
        border-bottom: 1px solid #111;
        margin-bottom: 0;
    }
    p{
        padding-top: .3rem;
        color: #333;
    }
}
.section-product{
    padding: 0;
    margin: .35rem;
    border: 1px solid #383d41;
    border-radius: 9px;
    width: 360px;
    .section-title{
        padding: .6rem;
        font-weight: bold;
        font-size: 22px;
        width: 100%;
        background: #111;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .section-categories{
        padding: .5rem;
        ul{
            margin-top: .7rem;
            display: flex;
            padding: 0;
            flex-direction: column;
            row-gap: .5rem;
            li{
                display: block;
                font-weight: bold;
                cursor: pointer;

            }
        }
    }
}
</style>

<script>
import Swal from "sweetalert2";

export default {
    props:{

        sectionData:{
            type:Object
        },
        categories:{
            type:Array,
            default: [],
        }
    },
    data(){
        return {
            name: this.sectionData.name,
            description: this.sectionData.description,
            image: '',
        }
    },
    computed:{
        modalId(){
            return 'section-id-'+this.sectionData.id;
        }
    },
    methods:{
        onDelete(){
            route('panel.api.deleteSection')
            .then(uri => {
                axios.post(uri.data.uri, {section_id: this.sectionData.id})
                .then(resp => {
                    if (resp.data.ok) {
                        Swal.fire({
                            title: 'Section deleted',
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
        editSectionModal(){
            $(this.$refs.modalEdit).modal('toggle')
        },
        setImage(image){
            this.image = image[0];
        },
        getData(){
            return {
                name: this.name,
                description: this.description,
                image: this.image,
                section_id: this.sectionData.id
            }
        },
        updateSubmit(){
            route('panel.api.updateSection')
                .then(uri => {
                    axios.post(uri.data.uri, this.getData())
                        .then(resp => {
                            if (resp.data.ok) {
                                Swal.fire({
                                    title: 'Снкцію товарів оновлено',
                                    icon: 'success'
                                })
                                this.$emit('success', true)
                            } else {
                                Swal.fire({
                                    title: 'Error update section, (error in your data)',
                                    icon:'error',
                                })
                            }
                        }).catch(err => {
                        Swal.fire({
                            title: 'Error update section',
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


