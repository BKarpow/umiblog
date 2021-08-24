<template>
    <div id="source-fields">
        <div class="form-group">
            <label for="source_main">Джерело</label>
            <input
                type="url"
                class="form-control"
                name="source_main"
                id="source_main"
            >
            <!-- /.form-control -->
            <button
                class="btn btn-success mt-2"
                type="button"
                v-if="!showSource1"
                @click="showSource1 = true"
            >
                Додати ще джерело
            </button>
            <!-- /.btn btn-success mt-2 -->
        </div>
        <!-- /.form-group -->

        <div class="form-group" v-if="showSource1">
            <label for="source_1">Джерело 2</label>
            <input
                type="url"
                class="form-control"
                name="source_1"
                id="source_1"
            >
            <!-- /.form-control -->
            <button
                class="btn btn-success mt-2"
                type="button"
                v-if="!showSource2"
                @click="showSource2 = true"
            >
                Додати ще джерело
            </button>
            <!-- /.btn btn-success mt-2 -->
            <button
                class="btn btn-danger mt-2 ml-2"
                type="button"
                v-if="showSource1"
                @click="showSource1 = false"
            >
                ВИДАЛИТИ
            </button>
            <!-- /.btn btn-success mt-2 -->
        </div>
        <!-- /.form-group -->

        <div class="form-group" v-if="showSource2">
            <label for="source_2">Джерело 3</label>
            <input
                type="url"
                class="form-control"
                name="source_2"
                id="source_2"
            >
            <!-- /.form-control -->
            <button
                class="btn btn-success mt-2"
                type="button"
                v-if="!showSource3"
                @click="showSource3 = true"
            >
                Додати ще джерело
            </button>
            <!-- /.btn btn-success mt-2 -->
            <button
                class="btn btn-danger mt-2 ml-2"
                type="button"
                v-if="showSource2"
                @click="showSource2 = false"
            >
                ВИДАЛИТИ
            </button>
            <!-- /.btn btn-success mt-2 -->
        </div>
        <!-- /.form-group -->

        <div class="form-group" v-if="showSource3">
            <label for="source_3">Джерело 4</label>
            <input
                type="url"
                class="form-control"
                name="source_3"
                id="source_3"
            >
            <!-- /.form-control -->
            <button
                class="btn btn-success mt-2"
                type="button"
                v-if="!showSourceOther"
                @click="showSourceOther = true"
            >
                Додати список джеред
            </button>
            <!-- /.btn btn-success mt-2 -->
            <button
                class="btn btn-danger mt-2 ml-2"
                type="button"
                v-if="showSource3"
                @click="showSource3 = false"
            >
                ВИДАЛИТИ
            </button>
            <!-- /.btn btn-success mt-2 -->
        </div>
        <!-- /.form-group -->

        <div class="form-group" v-if="showSourceOther">
            <label for="source_other">Джерела</label>
            <textarea
                name="source_other"
                id="source_other"
                cols="30" rows="10"
                placeholder="Кожне джерело на новому рядку."
                class="form-control"></textarea>
            <!-- /#.form-control -->
            <!-- /.form-control -->
            <button
                class="btn btn-danger mt-2 ml-2"
                type="button"
                v-if="showSourceOther"
                @click="showSourceOther = false"
            >
                ВИДАЛИТИ
            </button>
            <!-- /.btn btn-success mt-2 -->
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /#source-fields -->
</template>

<script>
export default {
    data(){
        return {
            showSource1: false,
            showSource1: false,
            showSource2: false,
            showSource3: false,
            showSourceOther: false,
        }
    }
}
</script>
