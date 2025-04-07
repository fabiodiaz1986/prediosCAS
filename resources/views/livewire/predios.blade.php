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
                    <th>Acción</th>
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
                        <td>
                            <div class="d-flex gap-2">
                                <button wire:click="edit({{ $predio->id }})" class="btn btn-warning btn-sm">Editar</button>
                                <button wire:click="delete({{ $predio->id }})" class="btn btn-danger btn-sm">Eliminar</button>
                            </div>
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
                        <div class="form-group mb-3">
                            <label>Nombre</label>
                            <input type="text" wire:model="nombre" class="form-control" placeholder="Nombre del Predio">
                        </div>
                    
                        <div class="form-group mb-3">
                            <label>Matrícula</label>
                            <input type="text" wire:model="matricula" class="form-control" placeholder="Matrícula">
                        </div>
                    
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label>Regional</label>
                                <select wire:model="form_regional" class="form-select">
                                    <option value="">-- Selecciona una Regional --</option>
                                    @foreach($regionales as $reg)
                                        <option value="{{ $reg }}">{{ $reg }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="form-group mb-3">
                                <label>Municipio</label>
                                <select wire:model="form_municipio_" class="form-select" {{ empty($municipios) ? 'disabled' : '' }}>
                                    <option value="">-- Selecciona un Municipio --</option>
                                    @foreach($municipios as $mun)
                                        <option value="{{ $mun }}">{{ $mun }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                        <div class="form-group mb-3">
                            <label>Área Compra Ha.</label>
                            <input type="number" wire:model="ha_compra" class="form-control" placeholder="Área de compra">
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