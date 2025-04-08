import Swal from 'sweetalert2';

window.confirmarEliminacion = function (id) {
    Swal.fire({
        title: 'Eliminación de Prédio',
        text: "¿Está seguro de realizar la eliminación del registro?. \nEsta acción no se puede deshacer una vez la confirme.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('eliminarPredio', id);
        }
    });
};