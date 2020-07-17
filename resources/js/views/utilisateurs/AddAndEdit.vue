<template>
    <div>
        <div class="intro-y flex items-center mt-8">

            <h2 class="text-lg font-medium mr-auto">
                {{ headerTitle }}
            </h2>
        </div>
        <div v-if="open" class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-3"></div>
            <div class="intro-y col-span-12 lg:col-span-6">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <div>
                        <label>Nom</label>
                        <input type="text" v-model="utilisateur.nom" class="input w-full border mt-2" placeholder="Saisir le nom">
                    </div>

                    <div>
                        <label>Prénom</label>
                        <input type="text" v-model="utilisateur.prenom" class="input w-full border mt-2" placeholder="Le prénom">
                    </div>

                    <div>
                        <label>Profession</label>
                        <input type="text" v-model="utilisateur.profession" class="input w-full border mt-2" placeholder="...">
                    </div>

                    <div>
                        <label>Téléphone</label>
                        <input type="number" v-model="utilisateur.telephone" class="input w-full border mt-2" placeholder="685xxxx">
                    </div>

                    <div>
                        <label>Rôle</label>
                        <select name="role" v-model="utilisateur.role_id" class="input w-full border mt-2" id="role">
                            <option v-for="role in roles" :value="role.id"> {{ role.libelle }} </option>
                        </select>
                    </div>

                    <div>
                        <label>Login</label>
                        <input type="email" v-model="utilisateur.login" class="input w-full border mt-2" placeholder="email de connexion / login">
                    </div>

                    <div class="text-right mt-5">
                        <router-link to="/utilisateurs" tag="button" class="button w-24 border text-gray-700 mr-1">
                            Annuler
                        </router-link>
                        <button type="button" @click="action()" class="button w-24 bg-theme-1 text-white">Enregistrer</button>
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
                utilisateur: null,
                open: false,
                loading: false,
                headerTitle: '',
                roles: [],
            }
        },

        mounted() {
            feather.replace();

            this.getRoles();
            this.lookUrl();
        },

        methods: {

            lookUrl() {
                if (this.$route.params.id === undefined) {
                    this.utilisateur = {};
                    this.headerTitle = 'Ajout d\'un nouvel utilisateur';
                    this.open = true;
                } else {
                    this.getUser(this.$route.params.id);
                }
            },

            getRoles() {
                axios.get('/api/roles').then(res => {
                    this.roles = res.data;
                }).catch(err => {
                    console.log(err);
                });
            },

            getUser(id) {
                axios.get('/api/users/' + id).then(res => {
                    this.utilisateur = res.data;

                    this.headerTitle = 'Modification de l\'utilisateur : ' + this.utilisateur.nom;
                    this.open = true;
                }).catch(err => {
                    console.log(err);
                });
            },

            action() {

                this.utilisateur.email = this.utilisateur.login;

                if (this.utilisateur.id !== undefined) {
                    this.update();
                } else {
                    this.save();
                }
            },

            save() {
                axios.post('/api/users', this.utilisateur).then(res => {
                    this.utilisateur = res.data;


                }).catch(err => {
                    console.log(err);
                });
            },

            update() {
                axios.put('/api/users/'  + this.utilisateur.id, this.utilisateur).then(res => {
                    this.utilisateur = res.data;


                }).cache(err => {
                    console.log(err);
                });
            },

        },
    }
</script>

<style scoped>

</style>
