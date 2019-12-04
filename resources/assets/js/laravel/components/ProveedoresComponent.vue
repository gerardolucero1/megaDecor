<template>
    <section class="container">
        <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#registrarProveedor">Registrar proveedor</button>
    
        <!-- Modal -->
        <div class="modal fade" id="registrarProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Registrar proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section class="container">
                        <div class="row">
                            <div class="col-md-7">
                                <h4>Datos del proveedor</h4>
                                <div class="form-group row">
                                    <label class="col-12" for="example-text-input">Nombre de Proveedor</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="nombre" name="nombre" v-model="proveedor.nombre">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12" for="example-text-input">Direccion</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="edireccion" name="direccion" v-model="proveedor.direccion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12" for="example-text-input">Teléfono General</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="edireccion" name="direccion" v-model="proveedor.telefonoGeneral">
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
                                    <label class="col-12" for="example-text-input">Nombre de contacto</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="nombre" v-model="telefono.nombre">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12" for="example-text-input">Telefono</label>
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" name="direccion" v-model="telefono.telefono">
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
                                    <tbody v-if="telefonos.length != 0">
                                        <tr v-for="(item, index) in telefonos" :key="index">
                                            <th scope="row">{{ index }}</th>
                                            <td>{{ item.nombre }}</td>
                                            <td>{{ item.telefono }}</td>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="registrarProveedor()">Guardar Proveedor</button>
                </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data(){
        return{
            proveedor: {
                nombre: '',
                direccion: '',
                tipo: 'NORMAL',
                descripcion: '',
                telefonoGeneral: '',
            },
            telefono: {
                nombre: '',
                telefono: '',
                correo: '',
                tipo: '',
                ext: '',
            },
            edicion: false,
            index: 0,
            telefonos: []
        }
    },
    methods: {
        agregarTelefono(){
            if(this.edicion){
                this.telefonos.splice(this.index, 1, this.telefono)
                this.edicion = false
                this.telefono = {nombre: '', telefono: '', correo: ''}
                return
            }
            this.telefonos.push(this.telefono)
            this.telefono = {nombre: '', telefono: '', correo: ''}
        },
        borrarTelefono(index){
            this.telefonos.splice(index, 1)
        },
        editarTelefono(item, index){
            this.edicion = true
            this.index = index

            this.telefono = item
        },
        async registrarProveedor(){
            for(const prop in this.proveedor){
                if(this.proveedor[prop].length == 0){
                    console.log('vacio')
                    Swal.fire(
                        'Datos faltantes!',
                        'Llena los datos del proveedor.',
                        'warning'
                    )
                    return
                }
            }

            if(this.telefonos.length == 0){
                Swal.fire(
                    'Datos faltantes!',
                    'Ingresa un telefono minimo',
                    'warning'
                )
                return
            }

            let URL = '/proveedores'

            try{
                const response = await axios.post(URL, {
                    'proveedor': this.proveedor,
                    'telefonos': this.telefonos,
                })
            }
            catch(error){
                console.log(error.data)
            }
            finally{
                Swal.fire({
                    title: 'Proveedor registrado',
                    text: "El proveedor ha sido registrado",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        location.reload()
                    }
                }) 
            }
        }
    }
}
</script>