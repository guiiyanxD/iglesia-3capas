const editarModal = document.getElementById('editarModal');
const closeButton = document.querySelector('.close-button');
const editarButtons = document.querySelectorAll('.editar-btn');
const editarForm = document.getElementById('editarForm');
const editarIdInput = document.getElementById('editar_id');
const editarNombreInput = document.getElementById('editar_nombre');
const editarDescripcionInput = document.getElementById('editar_descripcion');

editarButtons.forEach(button => {
    button.addEventListener('click', function() {
        const cargoId = this.dataset.id;

        // Llamada AJAX para obtener los datos del cargo específico
        fetch(`obtener_cargo.php?id=${cargoId}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    editarIdInput.value = data.id;
                    editarNombreInput.value = data.nombre;
                    editarDescripcionInput.value = data.descripcion;
                    editarModal.style.display = 'block'; // Mostrar el modal
                } else {
                    alert('Error al obtener los datos del cargo.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al comunicarse con el servidor.');
            });
    });
});

closeButton.addEventListener('click', function() {
    editarModal.style.display = 'none'; // Ocultar el modal
});

window.addEventListener('click', function(event) {
    if (event.target === editarModal) {
        editarModal.style.display = 'none'; // Cerrar al hacer clic fuera
    }
});

editarForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar envío normal del formulario

    const formData = new FormData(editarForm);

    fetch('procesar_editar_cargo.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cargo actualizado correctamente.');
                window.location.reload(); // Recargar la página como ejemplo
            } else {
                alert('Error al actualizar el cargo: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al comunicarse con el servidor.');
        });
});