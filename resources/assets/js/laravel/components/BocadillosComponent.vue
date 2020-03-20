<style>

</style>

<template>
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <table style="width:100%">
                    <tr>
                        <td># Personas</td>
                        <td><input v-model="personas" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                        <td>Numero de bocadillos</td>
                        <td><input v-model="bocadillos" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                        <td>Servilleta</td>
                        <td><input v-model="servilleta" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                        <td>Plato Pastelero</td>
                        <td><input v-model="platoPastelero" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                    </tr>
                </table>
                <table style="width:40%; margin-top:20px">
                    <tr>
                        <td>#bocadillos</td>
                        <td><input type="text" :value="personas*bocadillos"></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-7">
                <table style="width:100%; text-align:center; font-size:12px; border:solid">
                    <tr style="color:white; background:FE6E4F">
                        <th>POSTRE</th>
                        <th>BOCADILLOS POR MESA</th>
                        <th>PRECIO PAQUETE</th>
                    </tr>
                    
                    <tr>
                        <td>Bolitas de nuez (min 40)</td>
                        <td><input type="text" v-model="bolitasNuez" value="0" style="text-align:center"></td>
                        <td><input type="text" v-model="precioBolasNuez" style="text-align:center"></td>
                    </tr>
                    <tr>
                        <td>VOLOVANES DE POLLOa la crema y pizca de chipotle  (charola 30 pz)</td>
                        <td><input type="text" v-model="volovan" value="0" style="text-align:center"></td>
                        <td><input type="text" v-model="precioVolovan" style="text-align:center"></td>
                    </tr>
                    <tr>
                        <td>BROCHETAS DE MELON, QUESO Y JAMONCLLO MIN 16 PZ)</td>
                        <td><input type="text" v-model="brochetasQueso" value="0" style="text-align:center"></td>
                        <td><input type="text" v-model="precioBrochetasQueso" style="text-align:center"></td>
                    </tr>
                </table>
                <table style="width:50%; font-weight:bold">
                <tr>
                <td>bocadillos: </td>
                <td>$0.00 </td>
                </tr>
                <tr>
                <td>Servilletas: </td>
                <td>$0.00 </td>
                </tr>
                <tr>
                <td>Platos (desechables): </td>
                <td>$0.00 </td>
                </tr>
                    
                </table>
            </div>
            <div class="col-md-5">
                <table style="width:100%; text-align:center; font-size:12px; border:solid">
                    <tr  style="color:white; background:FE6E4F">
                        <th>CANT</th>
                        <th>TOTAL DE BOCADILLOS</th>
                        <th>PRECIO PAQUETE</th>
                    </tr>
                    <tr>
                        <td><input type="text" v-model="cantBolasNuez" style="text-align:center"></td>
                        <td><input type="text" :value="cantBolasNuez*bolitasNuez" style="text-align:center"></td>
                        <td><input type="text" :value="cantBolasNuez*bolitasNuez*precioBolasNuez" style="text-align:center"></td>
                    </tr>
                    <tr>
                        <td><input type="text" v-model="cantVolovan" style="text-align:center"></td>
                        <td><input type="text" :value="cantVolovan*volovan" style="text-align:center"></td>
                        <td><input type="text" :value="cantVolovan*volovan*precioVolovan" style="text-align:center"></td>
                    </tr>
                    <tr>
                        <td><input type="text" v-model="cantBrochetasQueso" style="text-align:center"></td>
                        <td><input type="text" :value="cantBrochetasQueso*brochetasQueso" style="text-align:center"></td>
                        <td><input type="text" :value="cantBrochetasQueso*brochetasQueso*precioBrochetasQueso" style="text-align:center"></td>
                    </tr>
                    <tr style="background:orange; color:white">
                        <td>TOTAL:</td>
                        <td><input type="text" style="text-align:center" :value="(cantBrochetasQueso*brochetasQueso)+(cantVolovan*volovan)+(cantBolasNuez*bolitasNuez)"></td>
                        <td><input type="text" style="text-align:center" :value="(cantBrochetasQueso*brochetasQueso*precioBrochetasQueso)+(cantVolovan*volovan*precioVolovan)+(cantBolasNuez*bolitasNuez*precioBolasNuez)"></td>
                    </tr>
                </table>
            
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'Bocadillos',

    data(){
        return{
            personas:0,
            bocadillos:0,
            servilletas:0,
            platoPastelero:0,
            bolitasNuez:0,
            precioBolasNuez:9,
            cantBolasNuez:0,
            volovan:0,
            precioVolovan:360,
            cantVolovan:0,
            brochetasQueso:0,
            cantBrochetasQueso:0,
            precioBrochetasQueso:10,

        }
    },

    created(){
        
    },

    computed:{

    },

    methods: {

    }
}
</script>