<template>
    <div>


        <div class="intro-y flex items-center mt-8">

            <h2 class="text-lg font-medium mr-auto">
                Opération & paiments
            </h2>
        </div>

        <div v-if="success" class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-18 text-theme-9 mt-2">
            <i data-feather="check-circle" class="w-6 h-6 mr-2"></i> Action réussie avec succès ! <i data-feather="x" class="w-4 h-4 ml-auto"></i>
        </div>

        <div v-if="error" class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-31 text-theme-6 mt-2">
            <i data-feather="alert-triangle" class="w-6 h-6 mr-2"></i> {{ error }} <i data-feather="x" class="w-4 h-4 ml-auto"></i>
        </div>

        <div v-if="open" class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-3"></div>
            <div class="intro-y col-span-12 lg:col-span-6">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <div>
                        <label>Parent qui paie</label>
                        <model-list-select :list="options1"
                                           v-model="objectItem"
                                           option-value="value"
                                           option-text="text"
                                           :custom-text="codeAndNameAndDesc"
                                           placeholder="select item">
                        </model-list-select>
                    </div>

                    <div>
                        <label>Pour quel élève ?</label>
                        <model-list-select :list="options2"
                                           v-model="stringItem"
                                           option-value="value"
                                           option-text="text"
                                           :custom-text="codeAndNameAndDesc"
                                           placeholder="select item">
                        </model-list-select>
                    </div>

                    <div>
                        <label>Raison </label>
                        <select @change="updateCaract" required v-model="paiement.motif_id" class="input w-full border mt-2" name="motif" id="motif">
                            <option value=""></option>
                            <option v-for="motif in motifs" :value="motif.id"> {{ motif.code }} </option>
                        </select>
                    </div>

                    <div>
                        <label>Tranche</label>
                        <select class="input w-full border mt-2" v-model="paiement.caracteristique_id" name="motif" id="caracteristique">
                            <option value=""></option>
                            <option v-for="caracteristique in caracteristiques" :value="caracteristique.id"> {{ caracteristique.code + ' ( ' + caracteristique.montant + ' CFA )'  }} </option>
                        </select>
                    </div>

                    <div>
                        <label>Montant (CFA) </label>
                        <input type="number" required v-model="paiement.montant" class="input w-full border mt-2" placeholder="5000">
                    </div>

                    <div class="text-right mt-5">
                        <router-link to="/paiements" tag="button" class="button w-24 border text-gray-700 mr-1">
                            Annuler
                        </router-link>
                        <button v-if="!loading" @click="action()" class="button w-24 bg-theme-1 text-white inline-flex items-center ">
                            Enregistrer
                        </button>
                        <button v-else class="button w-24 mr-1 mb-2 bg-theme-14 text-theme-10"> ... </button>
                    </div>
                </div>
                <!-- END: Form Layout -->
            </div>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import { ModelListSelect  } from 'vue-search-select'

    export default {
        name: "AddAndEdit",

        components: {
            ModelListSelect
        },

        data() {
            return {
                paiement: null,
                open: false,
                loading: false,
                headerTitle: '',
                motifs: [],
                caracteristiques: [],
                success: null,
                error: null,
                options1: [

                ],
                objectItem: '',
                options2: [

                ],
                stringItem: ''
            }
        },

        mounted() {
            feather.replace();

            this.getEleves();
            this.getParents();
            this.getMotifs();

            this.lookUrl();
        },

        methods: {

            codeAndNameAndDesc (item) {
                return `${item.text}`
            },
            reset1 () {
                this.objectItem = ''
            },
            selectFromParentComponent1 () {
                // select option from parent component
                this.objectItem = this.options[0].value
            },
            reset2 () {
                this.stringItem = ''
            },
            selectFromParentComponent2 () {
                // select option from parent component
                this.stringItem = this.options[0].value
            },

            lookUrl() {
                if (this.$route.params.id === undefined) {
                    this.paiement = {};
                    this.headerTitle = 'Ajout d\'un nouvel paiement';
                    this.open = true;
                } else {
                    this.getUser(this.$route.params.id);
                }
            },

            nameWithLang ({ nom, prenom }) {
                return `${nom}  ${prenom}`
            },

            updateCaract($event) {

                if ($event.target.value === "") {
                    this.caracteristiques = [];
                    return;
                }

                this.motifs.forEach(motif => {
                   if (motif.id + "" === $event.target.value) {
                       this.caracteristiques = motif.caracteristiques;
                   }
                });
            },

            getEleves() {
                axios.get('/api/eleves').then(res => {
                    res.data.forEach(item => {
                        this.options2.push({
                            value: item.id,
                            text: item.nom + ' ' + (item.prenom === null ? '' : item.prenom)
                        })
                    });
                }).catch(err => {
                    this.showError(err.response.data.message)
                })
            },

            getMotifs() {
                axios.get('/api/motifs').then(res => {
                    this.motifs = res.data;
                }).catch(err => {
                    this.showError(err.response.data.message)
                })
            },

            getParents() {
                axios.get('/api/parents').then(res => {
                    res.data.forEach(item => {
                        this.options1.push({
                            value: item.id,
                            text: item.nom + ' ' + (item.prenom === null ? '' : item.prenom)
                        })
                    });
                }).catch(err => {
                    this.showError(err.response.data.message)
                })
            },

            getUser(id) {
                axios.get('/api/paiements/' + id).then(res => {
                    this.paiement = res.data;

                    this.paiement.familles.forEach(famille => {
                        this.items.push({ value: famille.eleve.id, text: famille.eleve.nom + ' ' + (famille.eleve.prenom === null ? '' : famille.eleve.prenom) })
                    });

                    this.headerTitle = 'Modification du paiement : ' + this.paiement.nom;
                    this.open = true;
                }).catch(err => {
                    this.showError(err.response.data.message)
                });
            },

            action() {

                if (this.objectItem.length === 0)
                    this.showError("Veuillez choisir le parent.");

                if (this.stringItem.length === 0)
                    this.showError("Veuillez choisir l'élève.");

                this.loading = true;

                this.paiement.eleve_id = this.stringItem;
                this.paiement.parent_eleve_id = this.objectItem;

                if (this.paiement.id !== undefined) {
                    this.update();
                } else {
                    this.save();
                }
            },

            save() {
                axios.post('/api/paiements', this.paiement).then(res => {
                    this.paiement = res.data;

                    this.showSucces();

                    setTimeout(() => {
                        this.$router.push('/paiements/edit/' + this.paiement.id);
                        location.reload();
                    }, 100);

                }).catch(err => {
                    this.loading = false;
                    this.showError(err.response.data.message)
                });
            },

            update() {
                axios.put('/api/paiements/'  + this.paiement.id, this.paiement).then(res => {
                    this.paiement = res.data;

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
