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
                        <label>Code</label>
                        <input type="text" v-model="frai.code" required class="input w-full border mt-2" placeholder="Saisir le nom">
                    </div>

                    <div>
                        <label>Libelle</label>
                        <input type="text" v-model="frai.libelle"  required class="input w-full border mt-2" placeholder="Le prénom">
                    </div>

                    <div>
                        <label>Montant (CFA)</label>
                        <input type="number" v-model="frai.montant"  required class="input w-full border mt-2">
                    </div>

                    <div>
                        <label>Allant de </label>
                        <input type="date" v-model="frai.date_debut"  required class="input w-full border mt-2" >
                    </div>

                    <div>
                        <label>à </label>
                        <input type="date" v-model="frai.date_fin"  required class="input w-full border mt-2" >
                    </div>

                    <div class="text-right mt-5">
                        <router-link to="/frais" tag="button" class="button w-24 border text-gray-700 mr-1">
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
    export default {
        name: "AddAndEdit",

        data() {
            return {
                frai: null,
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

            this.lookUrl();
        },

        methods: {

            lookUrl() {
                if (this.$route.params.id === undefined) {
                    this.frai = {};
                    this.headerTitle = 'Ajout d\'un frais';
                    this.open = true;
                } else {
                    this.getFrai(this.$route.params.id);
                }
            },


            getFrai(id) {
                axios.get('/api/motifs/' + id).then(res => {
                    this.frai = res.data;

                    this.headerTitle = 'Modification frais : ' + this.frai.code;
                    this.open = true;
                }).catch(err => {
                    console.log(err);
                });
            },

            action() {

                this.loading = true;

                if (this.frai.id !== undefined) {
                    this.update();
                } else {
                    this.save();
                }
            },

            save() {
                axios.post('/api/motifs', this.frai).then(res => {
                    this.frai = res.data;

                    this.showSucces();

                    setTimeout(() => {
                        // this.$router.push('/frais/edit/' + this.frai.id);
                        this.$router.push({ path: '/frais/edit/' + this.frai.id })
                        location.reload();
                    }, 100);

                }).catch(err => {
                    this.loading = false;
                    this.showError(err.response.data.message)
                });
            },

            update() {
                axios.put('/api/motifs/'  + this.frai.id, this.frai).then(res => {
                    this.frai = res.data;

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
