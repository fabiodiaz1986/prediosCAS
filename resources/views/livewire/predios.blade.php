<div class="container mt-4">
    <!--<button wire:click="create" onclick="editarPredio('s')" class="btn btn-success mb-3">
    Nuevo Predio
    <span wire:loading wire:target="create" class="spinner-border spinner-border-sm"></span>
    </button>-->

    <div class="d-flex justify-content-end align-items-center mb-2">
        <label for="filtroPredios" class="me-2 mb-0">
          <i class="bi bi-search"></i> Buscar:
        </label>
        <input type="text" id="filtroPredios" class="form-control form-control-sm w-50" placeholder="Buscar en la tabla...">
      </div>

    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="tablaPredios">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">Id</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Matricula</th>
                    <th class="text-center">Regional</th>
                    <th class="text-center">Municipio</th>
                    <th class="text-center">Area Compra (Ha.)</th>
                    <th class="text-center">Area SIG (Ha.)</th>                    
                    <th class="text-center">Acción</th>
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
                                <!--<button wire:click="edit({{ $predio->id }})" onclick="editarPredio('s')" class="btn btn-warning btn-sm">
                                    Editar
                                </button>-->
                                <button class="btn btn-warning btn-sm" onclick="verMapaPredio({{ $predio->id }})">
                                    VerMapa
                                </button>
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
                        <button wire:click="store" class="btn btn-success">Guardar </button>
                        <button wire:click="closeModal" class="btn btn-secondary">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>        
    @endif

    <!-- Spinner Global -->
    <div id="global-loading-spinner" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(255, 255, 255, 0.6); z-index: 2000; align-items: center; justify-content: center;">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

   <!-- Modal del visor de mapa -->
    <div class="modal fade" id="mapaModal" tabindex="-1" aria-labelledby="mapaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="mapaModalLabel">Ubicación del Predio</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <div id="visor-mapa" style="height: 400px;"></div>
            </div>
          </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('filtroPredios').addEventListener('input', function () {
        const valor = this.value.toLowerCase();
        const filas = document.querySelectorAll('#tablaPredios tbody tr');
        
        filas.forEach(fila => {
            const textoFila = fila.innerText.toLowerCase();
            fila.style.display = textoFila.includes(valor) ? '' : 'none';
        });
    });
</script>
