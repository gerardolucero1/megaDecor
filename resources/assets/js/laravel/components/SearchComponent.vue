<template>
    <section class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <input type="text" class="form-control" v-model="search">
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        computed: {
            search: {
                get(){
                    return this.$store.state.filter.query;
                },
                set(val){
                    this.$store.commit('SET_QUERY', val);
                },
            }
        },
    }
</script>

