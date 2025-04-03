<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Predio;

class Predios extends Component
{
        
    public $id, $geom, $objectid, $nombre, $matricula, $regional, $municipio_, $ha_sig, $ha_compra, $vallas, 
            $estado_ref, $ha_refores, $aisla_mts, $regen_natu, $observacio, $shape_leng, $shape_area;
    public $isOpen = false;

    public function render()
    {
        return view('livewire.predios', [
            'predios' => Predio::all() // Asegurar que pasamos la variable a la vista
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
            'direccion' => 'required',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'area' => 'required|numeric',
            'valor' => 'required|numeric',
        ]);

        Predio::updateOrCreate(['id' => $this->predio_id], [
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'area' => $this->area,
            'valor' => $this->valor,
        ]);

        session()->flash('message', $this->predio_id ? 'Predio actualizado correctamente.' : 'Predio creado exitosamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $predio = Predio::findOrFail($id);
        $this->id = $id;
        $this->geom = $geom->geom;        
        $this->objectid = $objectid->objectid;
        $this->nombre = $nombre->nombre;
        $this->matricula = $matricula->matricula;        
        $this->regional = $regional->regional;
        $this->municipio_ = $municipio_->municipio_;
        $this->ha_sig = $ha_sig->ha_sig;
        $this->ha_compra = $ha_compra->ha_compra;
        $this->vallas = $vallas->vallas;
        $this->estado_ref = $estado_ref->estado_ref;
        $this->ha_refores = $ha_refores->ha_refores;
        $this->aisla_mts = $aisla_mts->aisla_mts;
        $this->regen_natu = $regen_natu->regen_natu;
        $this->observacio = $observacio->observacio;
        $this->shape_leng = $shape_leng->shape_leng;
        $this->shape_area = $shape_area->shape_area;

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
        $this->direccion = '';
        $this->latitud = '';
        $this->longitud = '';
        $this->area = '';
        $this->valor = '';
        $this->predio_id = null;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }
}
