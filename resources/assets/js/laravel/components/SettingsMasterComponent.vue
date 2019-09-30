<style>
.row-tasks {
  color: black;
}
.row-tasks:hover {
  background: #f5f5f5;
}
</style> 
<template>
  <div class="js-appear-enabled animated fadeIn" data-toggle="appear">
      <div class="form-group row">
        <div class="col-6">
          <div class="form-material">
            <input
              type="text"
              class="form-control"
              id="material-gridf"
              value="0"
              name="material-gridf"
              v-model="commission.porcentajeCrecimientoVentas"
            />
            <label for="material-gridf">Porcentaje Meta De Crecimiento En ventas</label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-material">
            <input
              type="text"
              class="form-control"
              id="material-gridl"
              value="0"
              name="material-gridl"
              v-model="commission.porcentajeCrecimientoUtilidad"
            />
            <label for="material-gridl">Porcentaje Meta De Crecimiento En Utilidad</label>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-6">
          <div class="form-material">
            <input
              type="text"
              class="form-control"
              id="material-gridf"
              value="1000"
              name="material-gridf"
              v-model="commission.bonoObjetivoVentas"
            />
            <label for="material-gridf">Bono monetario si se alcanza el objetivo de ventas</label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-material">
            <input
              type="text"
              class="form-control"
              id="material-gridl"
              value="0"
              name="material-gridl"
              v-model="commission.bonoObjetivoNoVentas"
            />
            <label for="material-gridl">Bono monetario si no se alcanza el objetivo de ventas</label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-material">
            <input
              type="text"
              class="form-control"
              id="material-gridl"
              value="5%"
              name="material-gridl"
              v-model="commission.comisionContrato"
            />
            <label for="material-gridl">Comision general por contrato</label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-material">
            <input
              type="text"
              class="form-control"
              id="material-gridl"
              value="2000"
              name="material-gridl"
              v-model="commission.bonoVendedorMes"
            />
            <label for="material-gridl">Bono monetario para vendedor del mes</label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-material">
            <input
              type="text"
              class="form-control"
              id="material-gridl"
              value="2000"
              name="material-gridl"
              v-model="commission.minimoVentaComision"
            />
            <label for="material-gridl">Minimo de venta para comisión</label>
          </div>
        </div>
        <div class="col-md-10"></div>
        <div class="col-md-2" style="padding-top:20px">
          <button class="btn btn-info" @click="guardarConfiguraciones()">Guardar</button>
        </div>
      </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            commission: {
               'porcentajeCrecimientoVentas': '',
               'porcentajeCrecimientoUtilidad': '',
               'bonoObjetivoVentas': '',
               'bonoObjetivoNoVentas': '',
               'comisionContrato': '',
               'bonoVendedorMes': '',
               'minimoVentaComision': '', 
            }
        };
    },
    created() {
      this.obtenerConfiguraciones();
    },
    methods: {
        obtenerConfiguraciones: function(){
          let URL = '/configuraciones';

          axios.get(URL).then((response) => {
            this.commission = response.data;
          }).catch((error) => {
            console.log(error.data);
          })
        },

        guardarConfiguraciones: function(){
          let URL = '/configuraciones/create';

          axios.post(URL, this.commission).then((response) => {
            Swal.fire(
              'Correcto',
              'Configuraciones guardadas',
              'success'
            );
            this.obtenerConfiguraciones();
          }).catch((error) => {
            Swal.fire(
              'Incorrecto',
              'Configuraciones no guardadas',
              'error'
            );
            this.obtenerConfiguraciones();
          })
        },
    }
};
</script>
