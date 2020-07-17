<template>
    <div class="intro-y  lg:mt-5">

        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-gray-700">
                <input type="text" class="input w-56 box pr-10 placeholder-theme-13" @keyup="filter" placeholder="Recherche...">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
            </div>
        </div>

        <div v-if="caractsSort.length === 0" class="rounded-md flex items-center px-5 py-4 mb-2 bg-gray-200 text-gray-600 mt-5 "> <i data-feather="alert-triangle" class="w-6 h-6 mr-2"></i> Aucune données dans le système. <i data-feather="x" class="w-4 h-4 ml-auto"></i> </div>


        <table v-else class="table table-report -mt-2">
            <thead>
            <tr>
                <th class="whitespace-no-wrap">Code</th>
                <th class="text-center whitespace-no-wrap">Libelle</th>
                <th class="text-center whitespace-no-wrap">Montant</th>
                <th class="text-center whitespace-no-wrap">actions</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(caract, index) in caractsSort" class="intro-x">
                <td>
                    <a href="javascript:void(0)" class="font-medium whitespace-no-wrap"> {{ caract.code }}  </a>
                    <div class="text-gray-600 text-xs whitespace-no-wrap">du {{ caract.date_debut }} au {{ caract.date_fin }}</div>
                </td>
                <td class="text-center">{{ caract.libelle }}</td>
                <td class="text-center">{{ caract.montant + ' CFA' }}</td>

                <!-- <td class="w-40">
                     <div class="flex items-center justify-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>
                 </td>-->
                <td class="table-report__action w-56">
                    <div class="flex justify-center items-center">

                        <a class="flex items-center mr-3" @click="editForm(caract)" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i>  </a>
                        <!--<a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Supprimer </a>
                    -->
                        <confirm-delete :elt="caract" v-on:confirm-del="deleteElt"></confirm-delete>

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
        name: "ListCaract",

        props: {
            motif: {}
        },

        components: {
            'confirm-delete': confirmDelete,
        },

        data() {
            return {
                caracts: [],
                caractsSort: [],
                caract: null,
            }
        },

        mounted() {
            feather.replace();

            this.getcaracts();
        },

        methods: {
            getcaracts() {
                axios.get('/api/frais-caracteristiques/' + this.motif.id).then(res => {
                    this.caracts = res.data;
                    this.caractsSort = res.data;

                    setTimeout(() => {
                        feather.replace();
                    }, 200);
                }).catch(err => {
                    console.log(err);
                });
            },

            deleteElt(id) {
                axios.delete('/api/caracteristiques/' + id).then(res => {

                    this.caractsSort.forEach((elt, index) => {
                        if (elt.id === id) {
                            this.caracts.splice(index, 1);

                        }
                    });

                    setTimeout(() => {
                        this.caractsSort = this.caracts;
                        feather.replace();
                    }, 200);
                }).catch(err => {
                    console.log(err);
                });
            },

            editForm(caract) {
                this.$emit('edit-caract', caract)
            },

            filter($event) {

                let string = $event.target.value;
                // console.log(string);
                if (string === "") {
                    this.caractsSort = this.caracts;
                } else {
                    this.caractsSort = this.caracts.filter(data =>
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
