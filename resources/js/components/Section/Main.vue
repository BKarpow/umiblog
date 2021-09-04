<template>
    <div class="sections">
        <h3 class="text-center">Ваші секції</h3>
        <!-- /.text-center -->
        <div class="btn-group my-2">
            <SectionCreate @success="fetchSections" />
        </div>
        <!-- /.btn-group my-2 -->
        <div class="sections-list">
            <SectionSection
                v-if="sections.length"
                v-for="section in sections"
                :key="section.id"
                :section-data="section"
                :categories="section.categories"
                @success="fetchSections"
            > <SectionCreateCategory
                :section-id="section.id"
                @success="fetchSections"
                :section-title="section.name" /> </SectionSection>
            <div v-else class="msg">
                <strong>Поки-що немає секцій, створіть новеньку :)</strong>
            </div>
            <!-- /.msg -->
            <div v-if="emptyDataFetch" class="alert alert-success">
                <strong>Секцій більше немає</strong>
            </div>
            <!-- /.alert alert-success -->
        </div>
        <!-- /.sections-list -->
    </div>
    <!-- /.sections -->
</template>

<style scoped lang="scss">
.sections-list{
    display: flex;
    flex-wrap: wrap;
}
</style>

<script>
import Swal from "sweetalert2";
export default {
    data(){
        return {
            sections: [],
            emptyDataFetch: false,
        }
    },

    methods:{
        fetchSections(){
            route('panel.api.getSections')
            .then(uri => {
                axios.get(uri.data.uri)
                .then(resp => {
                    if (resp.data.ok) {
                        this.sections = resp.data.data;
                        if (resp.data.length === 0) {
                            this.emptyDataFetch = true;
                        } else {
                            this.emptyDataFetch = false;
                        }
                    } else {
                        Swal.fire({
                            title: resp.data.message,
                            icon:'error',
                        })
                    }
                }).catch(err => {
                    Swal.fire({
                        title: 'Error load sections',
                        icon:'error',
                    })
                })
            }).catch(err => {
                Swal.fire({
                    title: 'Error getting uri from panel.api.getSections',
                    icon:'error',
                })
            })
        },
    },
    mounted() {
        this.fetchSections();
    }
}
</script>
