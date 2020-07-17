<template>
    <div>
        <h2 class="intro-y text-lg font-medium mt-10">
            Liste des frais
        </h2>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
                <router-link tag="button" to="/frais/new" class="button text-white bg-theme-1 shadow-md mr-2">
                    Nouveau frais
                </router-link>
                <!--<button class="button text-white bg-theme-1 shadow-md mr-2">Nouvel frai</button>-->
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

                <div v-if="fraisSort.length === 0" class="rounded-md flex items-center px-5 py-4 mb-2 bg-gray-200 text-gray-600 mt-5 "> <i data-feather="alert-triangle" class="w-6 h-6 mr-2"></i> Aucune données dans le système. <i data-feather="x" class="w-4 h-4 ml-auto"></i> </div>


                <table v-else class="table table-report -mt-2">
                    <thead>
                    <tr>
                        <th class="whitespace-no-wrap">CODE</th>
                        <th class="whitespace-no-wrap">LIBELLE</th>
                        <th class="whitespace-no-wrap">MONTANT</th>
                        <th class="whitespace-no-wrap">PERIODE</th>
                        <th class="whitespace-no-wrap">ACTIONS</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(frai, index) in fraisSort" class="intro-x">
                            <td>
                                <a href="javascript:void(0)" class="font-medium whitespace-no-wrap"> {{ frai.code }}  </a>
                             </td>
                            <td class="">{{ frai.libelle }}</td>
                            <td class="">{{ frai.montant + ' CFA' }}</td>
                            <td class="">{{ frai.date_debut + '-' + frai.date_fin }}</td>

                           <!-- <td class="w-40">
                                <div class="flex items-center justify-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>
                            </td>-->
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <router-link  :to="'/frais/infos/' + frai.id" tag="a" class="flex items-center text-theme-3 mr-3" href="javascript:;"> <i data-feather="info" class="w-4 h-4 mr-1"></i> info </router-link>

                                    <router-link  :to="'/frais/edit/' + frai.id" tag="a" class="flex items-center mr-3" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Modifier </router-link>
                                    <!--<a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Supprimer </a>
                                -->
                                    <confirm-delete :elt="frai" v-on:confirm-del="deleteElt"></confirm-delete>

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
                frais: [],
                fraisSort: [],
                frai: null,
            }
        },

        mounted() {
            feather.replace();

            this.getfrais();
        },

        methods: {
            getfrais() {
                axios.get('/api/motifs').then(res => {
                    this.frais = res.data;
                    this.fraisSort = res.data;

                    setTimeout(() => {
                        feather.replace();
                    }, 200);
                }).catch(err => {
                    console.log(err);
                });
            },

            deleteElt(id) {
                axios.delete('/api/motifs/' + id).then(res => {

                    this.fraisSort.forEach((elt, index) => {
                        if (elt.id === id) {
                            this.frais.splice(index, 1);

                        }
                    });

                    setTimeout(() => {
                        this.fraisSort = this.frais;
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
                    this.fraisSort = this.frais;
                } else {
                    this.fraisSort = this.frais.filter(data =>
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
