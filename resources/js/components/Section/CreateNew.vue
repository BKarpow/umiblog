<template>
    <div class="createNewSection">
        <modal-window
            modal-id="createNewSection"
            title="Створити секцію"
            button-text-open="Створити секцію"
            button-text-success="Зберегти"
            button-text-close="Відміна"
            @success="createSubmit"
        >
            <div class="form-group">
                <label for="name">Ім'я секції</label>
                <input type="text" id="name" v-model="name" class="form-control">
                <!-- /.form-control -->
            </div>
            <!-- /.form-group -->
            <div class="form-group">
                <label for="description">Опис секції</label>
                <textarea  id="description" v-model="description" class="form-control"></textarea>
                <!-- /.form-control -->
            </div>
            <!-- /.form-group -->
            <load-image @success="setImage" />
        </modal-window>
    </div>
    <!-- /.createNewSection -->
</template>

<script>
import Swal from "sweetalert2";
export default {
    data(){
        return {
            name: '',
            description: '',
            image: '',
        }
    },
    methods:{
        setImage(image){
            this.image = image[0];
        },
        getData(){
            return {
                name: this.name,
                description: this.description,
                image: this.image,
            }
        },
        createSubmit(){
            route('panel.api.createSection')
                .then(uri => {
                    axios.post(uri.data.uri, this.getData())
                    .then(resp => {
                        if (resp.data.ok) {
                            Swal.fire({
                                title: 'Снкцію товарів створено',
                                icon: 'success'
                            })
                            this.$emit('success', true)
                        } else {
                            Swal.fire({
                                title: 'Error create section, (error in your data)',
                                icon:'error',
                            })
                        }
                    }).catch(err => {
                        Swal.fire({
                            title: 'Error create section',
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
