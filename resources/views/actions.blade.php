<a style="margin-right:4px;" target="_blank" href="{{ route('inventory.edit', $id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Editar" data-original-title="Editar Presupuesto">
        <i class="fa fa-pencil"></i>
</a>
<form action="{{ route('inventory.archivar', $id) }}" method="POST" style="display:inline">
                @csrf
                @method('PUT')
                <button type="submit" style="margin-right:4px;" onclick="return confirm('¿Deseas archivar este producto?')" class="btn btn-sm btn-danger archivar" data-toggle="tooltip" title="Archivar Elemento" data-original-title="View Customer">
                    <i class="fa fa-remove"></i> 
                </button>
            </form>
<button data-id="{{ $id }}" data-tipo="alta" data-cantidad="cantidad-{{ $id }}" data-toggle="modal" data-target="#asignarAlta" class="altas btn btn-sm btn-success">
<i data-id="{{ $id }}" data-tipo="alta" data-cantidad="cantidad-{{ $id }}" class="fa fa-chevron-up"></i>
</button>
<button data-id="{{ $id }}" data-tipo="baja" data-cantidad="cantidad-{{ $id }}" data-toggle="modal" data-target="#asignarAlta" class="bajas btn btn-sm btn-success">
<i data-id="{{ $id }}" data-tipo="baja" data-cantidad="cantidad-{{ $id }}" class="fa fa-chevron-down"></i>
</button>
<form action="{{ route('inventory.NA', $id) }}" method="POST" style="display:inline">
    @csrf
    @method('PUT')
    <button type="submit" style="margin-right:4px;" onclick="return confirm('¿Estas seguro?')" @if(!$noAplica) class="btn btn-sm btn-danger archivar" @else class="btn btn-sm btn-success archivar" @endif data-toggle="tooltip" title="Archivar Elemento" data-original-title="View Customer">
        N/A
    </button>
</form>