// script.js (mejorado)
document.addEventListener('DOMContentLoaded', function() {
    const profileImage = document.getElementById('profileImage');
    const profileInput = document.getElementById('profileInput');
    const profileOptions = document.getElementById('profileOptions');
    const selectPhoto = document.getElementById('selectPhoto');
    const removePhoto = document.getElementById('removePhoto');
    const placeholderText = document.getElementById('placeholderText');

    // Mostrar modal al hacer clic en la imagen
    profileImage.addEventListener('click', function() {
        profileOptions.classList.add('show');
        document.body.style.overflow = 'hidden'; // Evitar scroll cuando el modal está abierto
    });

    // Seleccionar foto
    selectPhoto.addEventListener('click', function(e) {
        e.preventDefault();
        profileInput.click();
        closeModal();
    });

    // Eliminar foto
    removePhoto.addEventListener('click', function(e) {
        e.preventDefault();
        profileImage.src = 'imagenes/default.webp';
        placeholderText.style.display = 'block';
        closeModal();
    });

    // Cargar imagen seleccionada
    profileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.src = e.target.result;
                placeholderText.style.display = 'none';
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Cerrar modal al hacer clic fuera del contenido
    profileOptions.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Función para cerrar el modal con animación
    function closeModal() {
        profileOptions.classList.remove('show');
        document.body.style.overflow = 'auto'; // Restaurar scroll
    }

    // Cerrar con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && profileOptions.classList.contains('show')) {
            closeModal();
        }
    });
});