<template>
    <div class="container">

        <button type="button"
                class="btn btn-primary"
                data-toggle="modal" :data-target="'#' + modalId">
            {{buttonTextOpen}}
        </button>

        <!-- Modal -->
        <div class="modal fade" :id="modalId" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{title}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot></slot>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{buttonTextClose}}</button>
                        <button @click="btnSuccess" type="button" class="btn btn-primary">{{buttonTextSuccess}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            modalId:{
                type: String,
                default: 'modal-1'
            },
            title:{
                type: String,
                default: ''
            },
            buttonTextOpen:{
                type: String,
                default: 'Open modal'
            },
            buttonTextClose:{
                type: String,
                default: 'Close'
            },
            buttonTextSuccess:{
                type: String,
                default: 'Save'
            },
        },
        methods:{
            btnSuccess(){
                this.$emit('success', true)
            }
        },
        mounted() {

        }
    }
</script>
