<template>
    <span>
        <b v-if="parent"> {{ parent.nom + ( parent.prenom === null ? '' : ' ' + parent.prenom )}} </b>
    </span>
</template>

<script>
    export default {
        name: "ParentName",

        props: {
            id: null
        },

        data() {
            return {
                parent: null
            }
        },

        mounted() {
            this.getParent()
        },

        methods: {
            getParent() {
                axios.get('/api/parents/' + this.id).then(res => {
                    this.parent = res.data;
                }).catch(err => {
                    console.log(err.response)
                });
            }
        }
    }
</script>

<style scoped>

</style>
