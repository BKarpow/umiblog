<template>
    <div class="PublicToggle">
        <div class="toggleButton"  @click="onToggle">
            <svg v-if="toggle" xmlns="http://www.w3.org/2000/svg" :width="sizeSvg" :height="sizeSvg" fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
                <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
            </svg>

            <svg v-else xmlns="http://www.w3.org/2000/svg" :width="sizeSvg" :height="sizeSvg" fill="currentColor" class="bi bi-toggle-off" viewBox="0 0 16 16">
                <path d="M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z"/>
            </svg>
        </div>
    </div>
    <!-- /.PublicToggle -->
</template>

<script>
    export default {
        props:{
            uriToggle:{
                type: String,
                default: '',
            },
            status:{
                type: String,
                default: '',
            },
        },
        data(){
            return {
                toggle: false,
                sizeSvg: 32,
            }
        },
        methods:{
            onToggle(){
                axios.get(this.uriToggle)
                    .then(resp => {
                        if (resp.data.ok) {
                            this.toggle = Boolean(resp.data.data.toggle)
                        }
                    }).catch(err => console.error(err))
            },
        },
        mounted() {
            if (this.status.length) {
                this.toggle = true;
            } else {
                this.toggle = false;
            }
        }
    }
</script>

<style scoped>
    .toggleButton{
        cursor: pointer;
    }
</style>
