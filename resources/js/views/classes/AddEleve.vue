<template>
    <div class="intro-y box lg:mt-5">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Inscrire un élève
            </h2>

            <button @click="closeForm()" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="x-circle" class="w-4 h-4 mr-2"></i> annuler </button>
        </div>
        <div v-if="eleve" class="p-5">

            <div v-if="error" class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-31 text-theme-6 mt-2">
                <i data-feather="alert-triangle" class="w-6 h-6 mr-2"></i> {{ error }} <i data-feather="x" class="w-4 h-4 ml-auto"></i>
            </div>

            <div>
                <label>Nom</label>
                <input type="text" v-model="eleve.nom" required class="input w-full border mt-2" placeholder="Saisir le nom">
            </div>

            <div>
                <label>Prénom</label>
                <input type="text" v-model="eleve.prenom"  required class="input w-full border mt-2" placeholder="Le prénom">
            </div>

            <div>
                <label>Date Naissance</label>
                <input type="date" v-model="eleve.date_naissance"  required class="input w-full border mt-2" placeholder="Date">
            </div>

            <div>
                <label>Genre</label>
                <select v-model="eleve.genre"  required class="input w-full border mt-2" name="genre" id="genre">
                    <option value="feminin">Feminin</option>
                    <option value="masculin">Masculin</option>
                </select>
            </div>

            <div>
                <label>Matricule</label>
                <input type="text" v-model="eleve.matricule"  required class="input w-full border mt-2" placeholder="12c......">
            </div>

            <div class="text-right mt-5">
                <!--<router-link to="/eleves" tag="button" class="button w-24 border text-gray-700 mr-1">
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
        name: "AddEleve",

        props: {
            eleveEdit: {},
            classe: {}
        },

        data() {
            return {
                eleve: null,
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

            if (this.eleveEdit === null) {
                this.eleve = {};
            } else {
                this.eleve = this.eleveEdit;
            }
        },

        methods: {

            closeForm() {
                this.$emit('close-form');
            },

            action() {

                this.eleve.classe_id = this.classe.id;

                this.loading = true;

                if (this.eleve.id !== undefined) {
                    this.update();
                } else {
                    this.save();
                }
            },

            save() {
                axios.post('/api/eleves', this.eleve).then(res => {
                    this.eleve = res.data;

                    this.showSucces();

                    setTimeout(() => {
                        // this.$router.push('/eleves/edit/' + this.eleve.id);
                        this.closeForm();
                    }, 100);

                }).catch(err => {
                    this.loading = false;
                    this.showError(err.response.data.message)
                });
            },

            update() {
                axios.put('/api/eleves/'  + this.eleve.id, this.eleve).then(res => {
                    this.eleve = res.data;

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
