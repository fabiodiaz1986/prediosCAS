<div class="container mt-4">
    <button wire:click="create" class="btn btn-primary mb-3">Nuevo Predio</button>

    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Área</th>
                    <th>Valor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($predios as $predio)
                    <tr>
                        <td>{{ $predio->nombre }}</td>
                        <td>{{ $predio->direccion }}</td>
                        <td>{{ $predio->latitud }}</td>
                        <td>{{ $predio->longitud }}</td>
                        <td>{{ $predio->area }}</td>
                        <td>{{ number_format($predio->valor, 2) }}</td>
                        <td>
                            <button wire:click="edit({{ $predio->id }})" class="btn btn-warning btn-sm">Editar</button>
                            <button wire:click="delete({{ $predio->id }})" class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($isOpen)
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Formulario de Predio</h5>
                        <button type="button" class="close" wire:click="closeModal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" wire:model="nombre" class="form-control" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" wire:model="direccion" class="form-control" placeholder="Dirección">
                        </div>
                        <div class="form-group">
                            <label>Latitud</label>
                            <input type="number" wire:model="latitud" class="form-control" placeholder="Latitud">
                        </div>
                        <div class="form-group">
                            <label>Longitud</label>
                            <input type="number" wire:model="longitud" class="form-control" placeholder="Longitud">
                        </div>
                        <div class="form-group">
                            <label>Área</label>
                            <input type="number" wire:model="area" class="form-control" placeholder="Área">
                        </div>
                        <div class="form-group">
                            <label>Valor</label>
                            <input type="number" wire:model="valor" class="form-control" placeholder="Valor">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="store" class="btn btn-success">Guardar</button>
                        <button wire:click="closeModal" class="btn btn-secondary">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>