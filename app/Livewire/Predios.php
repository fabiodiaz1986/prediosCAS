<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Predio;
use App\Models\Municipio;


class Predios extends Component
{
        
    public $id, $geom, $objectid, $nombre, $matricula, $regional, $municipio_, $ha_sig, $ha_compra, $vallas, 
            $estado_ref, $ha_refores, $aisla_mts, $regen_natu, $observacio, $shape_leng, $shape_area;
    public $isOpen = false;

     // NUEVOS CAMPOS
    public $form_regional;
    public $form_municipio_;
    public $regionales = [];
    public $municipios = [];

    public $predioId;


    
    public function mount()
    {
        $this->regionales = Municipio::select('provincia')
            ->distinct()
            ->orderBy('provincia')
            ->pluck('provincia')
            ->toArray();
        
    }

    public function updatedFormRegional($value)
    {
        $this->form_municipio_ = null; // resetea el valor seleccionado
        $this->municipios = Municipio::where('provincia', $value)
            ->select('nom_munici') // Asegúrate de seleccionar el campo que necesitas
            ->distinct()
            ->orderBy('nom_munici')
            ->pluck('nom_munici')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.predios', [
            'predios' => Predio::all()
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required',
            'matricula' => 'required',
            'regional' => 'required',
            'municipio_' => 'required',
            'ha_compra' => 'required|numeric',
        ]);

        Predio::updateOrCreate(['id' => $this->predio_id], [
            'nombre' => $this->nombre,
            'matricula' => $this->matricula,
            'regional' => $this->regional,
            'municipio_' => $this->municipio_,
            'ha_compra' => $this->ha_compra,
            'ha_sig' => $this->ha_sig,
        ]);

        session()->flash('message', $this->predio_id ? 'Predio actualizado correctamente.' : 'Predio creado exitosamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $predio = Predio::findOrFail($id);
        $this->predioId = $predio->id;
        //$this->geom = $geom->geom;        
        //$this->objectid = $objectid->objectid;
        $this->nombre = $predio->nombre;
        $this->matricula = $predio->matricula;        
        $this->regional = $predio->regional;
        $this->municipio_ = $predio->municipio_;
        $this->ha_sig = $predio->ha_sig;
        $this->ha_compra = $predio->ha_compra;
        $this->vallas = $predio->vallas;
        $this->estado_ref = $predio->estado_ref;
        $this->ha_refores = $predio->ha_refores;
        $this->aisla_mts = $predio->aisla_mts;
        $this->regen_natu = $predio->regen_natu;
        $this->observacio = $predio->observacio;
        //$this->shape_leng = $shape_leng->shape_leng;
        //$this->shape_area = $shape_area->shape_area;

        $this->isOpen = true;
    }


    public function delete($id)
    {
        Predio::findOrFail($id)->delete();
        session()->flash('message', 'Predio eliminado correctamente.');
    }

    private function resetInputFields()
    {
        $this->nombre = '';
        $this->matricula = '';
        $this->form_regional = '';
        $this->form_municipio_ = '';
        $this->ha_compra = '';
        $this->ha_sig = '';
        //$this->predio_id = null;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    
    protected $listeners = ['eliminarPredio'];

    public function eliminarPredio($id)
    {
        Predio::findOrFail($id)->delete();
        session()->flash('message', 'Registro eliminado correctamente.');
    }
}
