<template>
    <section class="card">
        <div class="col-md-4 text-center">
            <p>{{ producto.nombre }}</p>
        </div>
    </section>
</template>

<script>
    export default {
        props: {
            producto: {
                type: Object,
                required: true,
            }
        }
    }
</script>
