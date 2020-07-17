<template>
    <div class="intro-y  lg:mt-5">

        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-gray-700">
                <input type="text" class="input w-56 box pr-10 placeholder-theme-13" @keyup="filter" placeholder="Recherche...">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
            </div>
        </div>

        <div v-if="elevesSort.length === 0" class="rounded-md flex items-center px-5 py-4 mb-2 bg-gray-200 text-gray-600 mt-5 "> <i data-feather="alert-triangle" class="w-6 h-6 mr-2"></i> Aucune données dans le système. <i data-feather="x" class="w-4 h-4 ml-auto"></i> </div>


        <table v-else class="table table-report -mt-2">
            <thead>
            <tr>
                <th class="whitespace-no-wrap">Nom</th>
                <th class="text-center whitespace-no-wrap">Matricule</th>
                <th class="text-center whitespace-no-wrap">Genre</th>
                <th class="text-center whitespace-no-wrap">actions</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(eleve, index) in elevesSort" class="intro-x">
                <td>
                    <a href="javascript:void(0)" class="font-medium whitespace-no-wrap"> {{ eleve.nom  + ' ' + (eleve.prenom ? null : eleve.prenom ) }}  </a>
                </td>
                <td class="text-center">{{ eleve.matricule }}</td>
                <td class="text-center">
                    <span v-if="eleve.genre ==='feminin' "><b>F</b></span>
                    <span v-else><b>G</b></span>
                </td>

                <!-- <td class="w-40">
                     <div class="flex items-center justify-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>
                 </td>-->
                <td class="table-report__action w-56">
                    <div class="flex justify-center items-center">

                        <a class="flex items-center mr-3" @click="editForm(eleve)" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i>  </a>
                        <!--<a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Supprimer </a>
                    -->
                        <confirm-delete :elt="eleve" v-on:confirm-del="deleteElt"></confirm-delete>

                    </div>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    import confirmDelete from "../../components/DeleteConfirmation";

    export default {
        name: "ListEleve",

        props: {
            classe: {}
        },

        components: {
            'confirm-delete': confirmDelete,
        },

        data() {
            return {
                eleves: [],
                elevesSort: [],
                eleve: null,
            }
        },

        mounted() {
            feather.replace();

            this.geteleves();
        },

        methods: {
            geteleves() {
                axios.get('/api/eleve-classe/' + this.classe.id).then(res => {
                    this.eleves = res.data;
                    this.elevesSort = res.data;

                    setTimeout(() => {
                        feather.replace();
                    }, 200);
                }).catch(err => {
                    console.log(err);
                });
            },

            deleteElt(id) {
                axios.delete('/api/eleves/' + id).then(res => {

                    this.elevesSort.forEach((elt, index) => {
                        if (elt.id === id) {
                            this.eleves.splice(index, 1);

                        }
                    });

                    setTimeout(() => {
                        this.elevesSort = this.eleves;
                        feather.replace();
                    }, 200);
                }).catch(err => {
                    console.log(err);
                });
            },

            editForm(eleve) {
                this.$emit('edit-eleve', eleve)
            },

            filter($event) {

                let string = $event.target.value;
                // console.log(string);
                if (string === "") {
                    this.elevesSort = this.eleves;
                } else {
                    this.elevesSort = this.eleves.filter(data =>
                        JSON.stringify(data).toLowerCase().indexOf(string.toLowerCase()) !== -1
                    );
                }
                setTimeout(() => {
                    feather.replace();
                }, 200);
            }
        },
    }
</script>

<style scoped>

</style>
