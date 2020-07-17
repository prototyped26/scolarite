<template>
    <div>
        <div class="intro-y flex items-center mt-8">
            <h2 v-if="motif" class="text-lg font-medium mr-auto">
                Gestion des frais : <b> {{ motif.code }} </b>
            </h2>
        </div>

        <div  class="grid grid-cols-12 gap-6">

            <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
                <div class="intro-y box mt-5">
                    <div v-if="motif" class="relative flex items-center p-5">
                        <div class="ml-4 mr-auto">
                            <div class="font-medium text-base">{{ motif.code }}</div>
                            <div class="text-gray-600"> {{ motif.libelle }} </div>
                            <div class="text-gray-600"> Du {{ motif.date_debut }} au {{ motif.date_fin }} </div>
                        </div>
                        <div class="dropdown relative">
                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-700"></i> </a>
                            <div class="dropdown-box mt-5 absolute w-56 top-0 right-0 z-20">
                                <div class="dropdown-box__content box">
                                    <div class="p-4 border-b border-gray-200 font-medium">Options</div>
                                    <div class="p-2">
                                        <a href="javascript:void(0)" @click="openForm(null)" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                            <i data-feather="activity" class="w-4 h-4 text-gray-700 mr-2"></i> Inscrire une caractéristique
                                        </a>
                                        <router-link :to="'/frais/edit/' + motif.id" tag="a" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                            <i data-feather="check-square" class="w-4 h-4 text-gray-700 mr-2"></i> modifier
                                        </router-link>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                   <!-- <div class="p-5 border-t border-gray-200">
                        <a class="flex items-center text-theme-1 font-medium" href=""> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Personal Information </a>
                        <a class="flex items-center mt-5" href=""> <i data-feather="box" class="w-4 h-4 mr-2"></i> Account Settings </a>
                        <a class="flex items-center mt-5" href=""> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Change Password </a>
                        <a class="flex items-center mt-5" href=""> <i data-feather="settings" class="w-4 h-4 mr-2"></i> User Settings </a>
                    </div>
                    <div class="p-5 border-t border-gray-200">
                        <a class="flex items-center" href=""> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Email Settings </a>
                        <a class="flex items-center mt-5" href=""> <i data-feather="box" class="w-4 h-4 mr-2"></i> Saved Credit Cards </a>
                        <a class="flex items-center mt-5" href=""> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Social Networks </a>
                        <a class="flex items-center mt-5" href=""> <i data-feather="settings" class="w-4 h-4 mr-2"></i> Tax Information </a>
                    </div>-->
                    <div class="p-5 border-t flex">
                        <router-link to="/frais" tag="a" class="button button--sm border text-gray-700 ml-auto">retour</router-link>
                    </div>
                </div>
            </div>

            <div v-if="motif" class="col-span-12 lg:col-span-8 xxl:col-span-9">

                <list-caract v-if="listOpen" :motif="motif" v-on:edit-caract="editForm"></list-caract>
                <add-caract v-else :motif="motif" :caracteristiqueEdit="caract" v-on:close-form="closeForm()" ></add-caract>

            </div>

        </div>
    </div>
</template>

<script>

    import ListCaract from "./ListCaract";
    import AddCaract from "./AddCaract";

    export default {
        name: "Informations",

        components: {
            'list-caract': ListCaract,
            'add-caract': AddCaract
        },

        data() {
            return {
                motif: null,
                listOpen: true,
                caract: null,
            }
        },

        mounted() {
            setTimeout(() => {
                feather.replace();
            }, 500);

            this.getMotif(this.$route.params.id);
        },

        methods: {
            getMotif(id) {
                axios.get('/api/motifs/' + id).then(res => {
                    this.motif = res.data;

                    this.headerTitle = 'Modification de la motif : ' + this.motif.code;
                    this.open = true;

                    setTimeout(() => {
                        feather.replace();
                    }, 500);

                }).catch(err => {
                    console.log(err);
                });
            },

            openForm(caract) {

                this.caract = caract;

                this.openAdd();
            },

            closeForm() {
                this.caract = null;

                this.closeAdd();
            },

            editForm(caract) {
                this.openForm(caract);
            },

            openAdd() {
                this.listOpen = false;

                console.log(this.listOpen)
            },

            closeAdd() {
                this.listOpen = true;
            }

        },


    }
</script>

<style scoped>

</style>
