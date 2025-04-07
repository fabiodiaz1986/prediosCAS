<div class="container mt-4">
    <button wire:click="create" class="btn btn-success mb-3">
    Nuevo Predio
    <span wire:loading wire:target="create" class="spinner-border spinner-border-sm"></span>
</button>

    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Matricula</th>
                    <th>Regional</th>
                    <th>Municipio</th>
                    <th>Ha Compra</th>
                    <th>Ha Geog.</th>
                    <th>Valor</th>
                    <th>Accion de Gestión</th>
                </tr>
            </thead>
            <tbody>
                @foreach($predios as $predio)
                    <tr>
                        <td>{{ $predio->objectid }}</td>
                        <td>{{ $predio->nombre }}</td>
                        <td>{{ $predio->matricula }}</td>
                        <td>{{ $predio->regional }}</td>
                        <td>{{ $predio->municipio_ }}</td>
                        <td>{{ $predio->ha_compra }}</td>
                        <td>{{ $predio->ha_sig }}</td>
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
                        <button type="button" class="close" wire:click="closeModal">
                            &times;
                            <span wire:loading wire:target="closeModal" class="spinner-border spinner-border-sm"></span>
                        </button>
                        
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" wire:model="nombre" class="form-control" placeholder="Nombre del Predio">
                        </div>
                        <div class="form-group">
                            <label>Matricula</label>
                            <input type="text" wire:model="matricula" class="form-control" placeholder="Matricula">
                        </div>
                        <div class="form-group">
                            <label>Regional</label>
                            <input type="number" wire:model="regional" class="form-control" placeholder="Regional">
                        </div>
                        <div class="form-group">
                            <label>Municipio</label>
                            <input type="number" wire:model="municipio" class="form-control" placeholder="Municipio">
                        </div>
                        <div class="form-group">
                            <label>Área Compra Ha.</label>
                            <input type="number" wire:model="ha_compra" class="form-control" placeholder="Área de compra">
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