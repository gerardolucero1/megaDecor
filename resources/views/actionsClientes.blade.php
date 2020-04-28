@if($permisos->clientesEditar==1)
                                        <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn btn-sm btn-primary " data-toggle="tooltip" title="Editar Cliente"  data-original-title="View Customer">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        @endif
                                        <button onclick="event.preventDefault();
                                                        Swal.fire({
                                                            title: '¿Estas seguro?',
                                                            text: 'Se eliminaran tambien todos los contratos y presupuestos',
                                                            type: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Eliminar'
                                                            }).then((result) => {
                                                            if (result.value) {
                                                                document.getElementById('delete-cliente-{{ $cliente->id }}').submit();
                                                                Swal.fire(
                                                                '¡Eliminado!',
                                                                'El cliente ha sido eliminado',
                                                                'success'
                                                                )
                                                            }
                                                        });
                                                    "
                                                    type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar cliente" data-original-title="Delete Client">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                        <form id="delete-cliente-{{ $cliente->id }}" action="{{ route('cliente.delete', $cliente->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                        </form>