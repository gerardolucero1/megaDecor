<template>
    <section class="container" v-if="productos.length > 0">
        <div class="row">
            <producto :producto="producto" v-for="producto in productos" :key="producto.id">

            </producto>
        </div>
    </section>
</template>

<script>
import Producto from './InventarioItemComponent';
import {mapGetters} from 'vuex';

export default {
    components: {
        Producto
    },
    computed: {
        ...mapGetters({
            productos: 'filteredProductos',
        })
    }

}
</script>

