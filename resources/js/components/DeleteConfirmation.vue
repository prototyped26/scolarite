<template>
    <span>
        <a v-if="!confirm" @click="askDel" class="flex items-center text-theme-6" href="javascript:void(0);" > <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Supprimer </a>
        <a v-else @click="confirmDel" class="flex items-center text-theme-6" href="javascript:void(0);" > <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Confirmer ! </a>
    </span>
</template>

<script>
    export default {
        name: "DeleteConfirmation",

        props: {
            elt: {}
        },

        data() {
            return {
                confirm: false
            }
        },

        mounted() {
            feather.replace();
        },

        methods: {
            askDel() {
              this.confirm = true;

              setTimeout(() => {
                  this.confirm = false;
              }, 3000);
            },

            confirmDel() {
                this.$emit('confirm-del', this.elt.id);
            },
        }
    }
</script>

<style scoped>

</style>
