<template>
    <div class="intro-y box lg:mt-5">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Inscrire un caractère
            </h2>

            <button @click="closeForm()" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="x-circle" class="w-4 h-4 mr-2"></i> annuler </button>
        </div>
        <div v-if="caracteristique" class="p-5">

            <div v-if="error" class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-31 text-theme-6 mt-2">
                <i data-feather="alert-triangle" class="w-6 h-6 mr-2"></i> {{ error }} <i data-feather="x" class="w-4 h-4 ml-auto"></i>
            </div>

            <div>
                <label>Code</label>
                <input type="text" v-model="caracteristique.code" required class="input w-full border mt-2" placeholder="ED">
            </div>

            <div>
                <label>Libelle</label>
                <input type="text" v-model="caracteristique.libelle"  required class="input w-full border mt-2" placeholder="....">
            </div>

            <div>
                <label>Montant</label>
                <input type="number" v-model="caracteristique.montant"  required class="input w-full border mt-2" placeholder="12 000">
            </div>

            <div>
                <label>Période allant du </label>
                <input type="date" v-model="caracteristique.date_debut"  required class="input w-full border mt-2" >
            </div>

            <div>
                <label>au</label>
                <input type="date" v-model="caracteristique.date_fin"  required class="input w-full border mt-2">
            </div>


            <div class="text-right mt-5">
                <!--<router-link to="/caracteristiques" tag="button" class="button w-24 border text-gray-700 mr-1">
                    Annuler
                </router-link>-->
                <button v-if="!loading" @click="action()" class="button w-24 bg-theme-1 text-white inline-flex items-center ">
                    Enregistrer
                </button>
                <button v-else class="button w-24 mr-1 mb-2 bg-theme-14 text-theme-10"> ... </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddCaract",

        props: {
            caracteristiqueEdit: {},
            motif: {}
        },

        data() {
            return {
                caracteristique: null,
                open: false,
                loading: false,
                headerTitle: '',
                roles: [],
                success: null,
                error: null,
            }
        },

        mounted() {
            feather.replace();

            if (this.caracteristiqueEdit === null) {
                this.caracteristique = {};
            } else {
                this.caracteristique = this.caracteristiqueEdit;
            }
        },

        methods: {

            closeForm() {
                this.$emit('close-form');
            },

            action() {

                this.caracteristique.motif_id = this.motif.id;

                this.loading = true;

                if (this.caracteristique.id !== undefined) {
                    this.update();
                } else {
                    this.save();
                }
            },

            save() {
                axios.post('/api/caracteristiques', this.caracteristique).then(res => {
                    this.caracteristique = res.data;

                    this.showSucces();

                    setTimeout(() => {
                        // this.$router.push('/caracteristiques/edit/' + this.caracteristique.id);
                        this.closeForm();
                    }, 100);

                }).catch(err => {
                    this.loading = false;
                    this.showError(err.response.data.message)
                });
            },

            update() {
                axios.put('/api/caracteristiques/'  + this.caracteristique.id, this.caracteristique).then(res => {
                    this.caracteristique = res.data;

                    this.showSucces();
                    this.loading = false;
                }).catch(err => {
                    // console.log(err.response);
                    this.loading = false;
                    this.showError(err.response.data.message)
                });
            },

            showSucces() {
                this.success = "Réussie";

                setTimeout(() => {
                    this.success = null;
                }, 2000);
            },

            showError(message) {
                this.error = message;

                setTimeout(() => {
                    this.error = null;
                }, 3000);
            }

        },
    }
</script>

<style scoped>

</style>
