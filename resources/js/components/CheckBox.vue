<template>
    <div class="form-check">
        <input ref="check" class="form-check-input" type="checkbox" :name="name" value="true" :id="name" >
        <label class="form-check-label" :for="name">
            <slot></slot>
        </label>
    </div>
</template>

<script>
export default {
    props:{
        name: {
            type: String,
            default: '',
        },
        check:{
            type: Boolean,
            default: false
        },
    },
    mounted() {
        if (this.check) {
            this.$refs.check.setAttribute('checked', '');
        }
    }
}
</script>
