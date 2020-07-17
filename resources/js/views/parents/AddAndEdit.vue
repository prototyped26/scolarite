<template>
    <div>


        <div class="intro-y flex items-center mt-8">

            <h2 class="text-lg font-medium mr-auto">
                {{ headerTitle }}
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
                        <label>Nom</label>
                        <input type="text" v-model="parent.nom" class="input w-full border mt-2" placeholder="Saisir le nom">
                    </div>

                    <div>
                        <label>Prénom</label>
                        <input type="text" v-model="parent.prenom" class="input w-full border mt-2" placeholder="Le prénom">
                    </div>

                    <div>
                        <label>Ville</label>
                        <input type="text" v-model="parent.ville" class="input w-full border mt-2" placeholder="...">
                    </div>

                    <div>
                        <label>Adresse</label>
                        <input type="text" v-model="parent.adresse" class="input w-full border mt-2" placeholder="Sable, Deido, ...">
                    </div>

                    <div>
                        <label>Téléphone</label>
                        <input type="number" v-model="parent.telephone" class="input w-full border mt-2" placeholder="685xxxx">
                    </div>


                    <div>
                        <label>Email</label>
                        <input type="email" v-model="parent.email" class="input w-full border mt-2" placeholder="email ">
                    </div>

                    <div>
                        <label>Parent de : </label>
                        <multi-select :options="options"
                                      :selected-options="items"
                                      placeholder="Parent de ????"
                                      @select="onSelect">
                        </multi-select>
                    </div>


                    <div class="text-right mt-5">
                        <router-link to="/parents" tag="button" class="button w-24 border text-gray-700 mr-1">
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
    import { MultiSelect } from 'vue-search-select'

    export default {
        name: "AddAndEdit",

        components: {
            MultiSelect
        },

        data() {
            return {
                parent: null,
                open: false,
                loading: false,
                headerTitle: '',
                roles: [],
                success: null,
                error: null,
                options: [
                ],
                searchText: '', // If value is falsy, reset searchText & searchItem
                items: [],
                lastSelectItem: {}
            }
        },

        mounted() {
            feather.replace();

            this.getEleves();
            this.lookUrl();
        },

        methods: {

            onSelect (items, lastSelectItem) {
                this.items = items
                this.lastSelectItem = lastSelectItem
            },
            // deselect option
            reset () {
                this.items = [] // reset
            },
            // select option from parent component
            selectFromParentComponent () {
                this.items = _.unionWith(this.items, [this.options[0]], _.isEqual)
            },

            lookUrl() {
                if (this.$route.params.id === undefined) {
                    this.parent = {};
                    this.headerTitle = 'Ajout d\'un nouvel parent';
                    this.open = true;
                } else {
                    this.getUser(this.$route.params.id);
                }
            },

            nameWithLang ({ nom, prenom }) {
                return `${nom}  ${prenom}`
            },

            getEleves() {
                axios.get('/api/eleves').then(res => {
                    res.data.forEach(item => {
                        this.options.push({
                            value: item.id,
                            text: item.nom + ' ' + (item.prenom === null ? '' : item.prenom)
                        })
                    });
                }).catch(err => {
                    this.showError(err.response.data.message)
                })
            },

            getUser(id) {
                axios.get('/api/parents/' + id).then(res => {
                    this.parent = res.data;

                    this.parent.familles.forEach(famille => {
                        this.items.push({ value: famille.eleve.id, text: famille.eleve.nom + ' ' + (famille.eleve.prenom === null ? '' : famille.eleve.prenom) })
                    });

                    this.headerTitle = 'Modification du parent : ' + this.parent.nom;
                    this.open = true;
                }).catch(err => {
                    this.showError(err.response.data.message)
                });
            },

            action() {

                this.loading = true;
                let tab = [];
                this.items.forEach(item => {
                    tab.push(item.value);
                });
                this.parent.famille = tab;

                if (this.parent.id !== undefined) {
                    this.update();
                } else {
                    this.save();
                }
            },

            save() {
                axios.post('/api/parents', this.parent).then(res => {
                    this.parent = res.data;

                    this.showSucces();

                    setTimeout(() => {
                        this.$router.push('/parents/edit/' + this.parent.id);
                        location.reload();
                    }, 100);

                }).catch(err => {
                    this.loading = false;
                    this.showError(err.response.data.message)
                });
            },

            update() {
                axios.put('/api/parents/'  + this.parent.id, this.parent).then(res => {
                    this.parent = res.data;

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
