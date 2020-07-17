<template>
    <div>
        <h2 class="intro-y text-lg font-medium mt-10">
            Liste des parents
        </h2>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
                <router-link tag="button" to="/parents/new" class="button text-white bg-theme-1 shadow-md mr-2">
                    Ajouter un Parent
                </router-link>
                <!--<button class="button text-white bg-theme-1 shadow-md mr-2">Nouvel Parent</button>-->
                <div class="dropdown relative">
                    <button class="dropdown-toggle button px-2 box text-gray-700">
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                    </button>
                    <div class="dropdown-box mt-10 absolute w-40 top-0 left-0 z-20">
                        <div class="dropdown-box__content box p-2">
                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Imprimer </a>
                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Exporter en PDF </a>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block mx-auto text-gray-600">

                </div>
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-gray-700">
                        <input type="text" class="input w-56 box pr-10 placeholder-theme-13" @keyup="filter" placeholder="Recherche...">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">

                <div v-if="parentsSort.length === 0" class="rounded-md flex items-center px-5 py-4 mb-2 bg-gray-200 text-gray-600 mt-5 "> <i data-feather="alert-triangle" class="w-6 h-6 mr-2"></i> Aucune données dans le système. <i data-feather="x" class="w-4 h-4 ml-auto"></i> </div>


                <table v-else class="table table-report -mt-2">
                    <thead>
                    <tr>
                        <th class="whitespace-no-wrap">NOM & PRENOM</th>
                        <th class="text-center whitespace-no-wrap">EMAIL</th>
                        <th class="text-center whitespace-no-wrap">VILLE</th>
                        <th class="text-center whitespace-no-wrap">TELEPHONE</th>
                        <th class="text-center whitespace-no-wrap">ACTIONS</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(parent, index) in parentsSort" class="intro-x">
                            <td>
                                <a href="javascript:void(0)" class="font-medium whitespace-no-wrap"> {{ parent.nom === null ? '' : parent.nom }} {{ parent.prenom === null ? '' : ' ' + parent.prenom }} </a>
                                <div class="text-gray-600 text-xs whitespace-no-wrap">{{  }}</div>
                            </td>
                            <td class="text-center">{{ parent.email }}</td>
                            <td>
                                {{ parent.profession === null ? 'non définie' : parent.ville }}
                            </td>
                            <td>
                                {{ parent.telephone === null ? 'non définie' : parent.telephone }}
                            </td>
                           <!-- <td class="w-40">
                                <div class="flex items-center justify-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>
                            </td>-->
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <router-link  :to="'/parents/edit/' + parent.id" tag="a" class="flex items-center mr-3" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Modifier </router-link>
                                    <!--<a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Supprimer </a>
                                -->
                                    <confirm-delete :elt="parent" v-on:confirm-del="deleteElt"></confirm-delete>

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
            <!-- BEGIN: Pagination -->

            <!-- END: Pagination -->
        </div>
        <!-- BEGIN: Delete Confirmation Modal -->
        <div class="modal" id="delete-confirmation-modal">
            <div class="modal__content">
                <div class="p-5 text-center">
                    <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-gray-600 mt-2">Do you really want to delete these records? This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button>
                    <button type="button" class="button w-24 bg-theme-6 text-white">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import confirmDelete from "./../../components/DeleteConfirmation";

    export default {
        name: "List",

        components: {
            'confirm-delete': confirmDelete,
        },

        data() {
            return {
                parents: [],
                parentsSort: [],
                parent: null,
            }
        },

        mounted() {
            feather.replace();

            this.getParents();
        },

        methods: {
            getParents() {
                axios.get('/api/parents').then(res => {
                    this.parents = res.data;
                    this.parentsSort = res.data;

                    setTimeout(() => {
                        feather.replace();
                    }, 200);
                }).catch(err => {
                    console.log(err);
                });
            },

            deleteElt(id) {
                axios.delete('/api/parents/' + id).then(res => {

                    this.parentsSort.forEach((elt, index) => {
                        if (elt.id === id) {
                            this.parents.splice(index, 1);

                        }
                    });

                    setTimeout(() => {
                        this.parentsSort = this.parents;
                        feather.replace();
                    }, 200);
                }).catch(err => {
                    console.log(err);
                });
            },

            filter($event) {

                let string = $event.target.value;
                // console.log(string);
                if (string === "") {
                    this.parentsSort = this.parents;
                } else {
                    this.parentsSort = this.parents.filter(data =>
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
