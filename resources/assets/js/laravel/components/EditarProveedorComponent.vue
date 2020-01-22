<template>
    <section class="container">
        <section class="container">
            <div class="row">
                <div class="col-md-7">
                    <h4>Datos del proveedor</h4>
                    <div class="form-group row">
                        <label class="col-12" for="example-text-input">Nombre</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="nombre" name="nombre" v-model="proveedor.nombre">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12" for="example-text-input">Direccion</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="edireccion" name="direccion" v-model="proveedor.direccion">
                        </div>
                        <div class="col-12" style="padding-top:15px">
                            <label for=""><input type="checkbox" v-model="proveedor.publico"> Mostrar este proveedor a vendedores</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12" for="example-text-input">Descripcion de proveedor</label>
                        <div class="col-md-12">
                            <textarea class="form-control" name="descripcion" id="" cols="30" rows="4" v-model="proveedor.descripcion"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <h4>Numeros de contacto</h4>
                    <div class="row">
                        <div class="col-md-6" style="padding: 0;">
                            <label class="col-12" for="example-text-input">Tipo</label>
                            <div class="col-md-12">
                                <select class="form-control" name="tipo" id="tipo" v-model="telefono.tipo">
                                    <option value="CASA">Casa</option>
                                    <option value="CELULAR">Celular</option>
                                    <option value="OFICINA">Oficina</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding: 0;">
                            <label class="col-12" for="example-text-input">EXT</label>
                            <div class="col-md-12">
                                <input type="number" class="form-control" name="nombre" v-model="telefono.ext">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12" for="example-text-input">Nombre</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="nombre" v-model="telefono.nombre">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12" for="example-text-input">Telefono</label>
                        <div class="col-md-12">
                            <input type="number" class="form-control" name="direccion" v-model="telefono.numero">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12" for="example-text-input">Correo</label>
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="direccion" v-model="telefono.correo">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button class="btn btn-sm btn-primary btn-block" @click="agregarTelefono()">Añadir telefono</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Numero</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">EXT</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody v-if="proveedor.telefonos.length != 0">
                            <tr v-for="(item, index) in proveedor.telefonos" :key="index">
                                <th scope="row">{{ index }}</th>
                                <td>{{ item.nombre }}</td>
                                <td>{{ item.numero }}</td>
                                <td>{{ item.tipo }}</td>
                                <td>{{ item.ext }}</td>
                                <td>{{ item.correo }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button @click="editarTelefono(item, index)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button @click="borrarTelefono(index)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Delete">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="container pb-3">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <button @click="registrarProveedor()" class="btn btn-block btn-sm btn-success">Guardar</button>
                </div>
            </div>
        </section>
    </section>
</template>

<script>
export default {
    props: {
        proveedor: {
            type: Object,
            required: true,
        }
    },
    data(){
        return{
            telefono: {
                nombre: '',
                numero: '',
                correo: '',
                tipo: '',
                ext: '',
            },
            edicion: false,
            index: 0,
        }
    },
    methods: {
        agregarTelefono(){
            if(this.edicion){
                this.proveedor.telefonos.splice(this.index, 1, this.telefono)
                this.edicion = false
                this.telefono = {nombre: '', numero: '', correo: ''}
                return
            }
            this.proveedor.telefonos.push(this.telefono)
            this.telefono = {nombre: '', numero: '', correo: ''}
        },
        borrarTelefono(index){
            this.proveedor.telefonos.splice(index, 1)
        },
        editarTelefono(item, index){
            this.edicion = true
            this.index = index

            this.telefono = item
        },
        async registrarProveedor(){
            for(const prop in this.proveedor){
               /* if(this.proveedor[prop].length == 0){
                    console.log('vacio')
                    Swal.fire(
                        'Datos faltantes!',
                        'Llena los datos del proveedor.',
                        'warning'
                    )
                    return
                } */
            }

            if(this.proveedor.telefonos.length == 0){
                Swal.fire(
                    'Datos faltantes!',
                    'Ingresa un telefono minimo',
                    'warning'
                )
                return
            }

            let URL = '/proveedores/update/' + this.proveedor.id

            try{
                const response = await axios.put(URL, {
                    'proveedor': this.proveedor,
                })
            }
            catch(error){
                console.log(error.data)
            }
            finally{
                Swal.fire(
                    'Correcto',
                    'El proveedor ha sido actualizado',
                    'success'
                )
            }
        }
    },
}
</script>

<style>

</style>