// Selecciona los elementos del menú usando selectores de CSS
const dropdown = document.querySelector('.dropdown'); // Selecciona el contenedor principal del menú
const dropbtn = document.querySelector('.dropbtn'); // Selecciona el botón del menú
const dropdownContent = document.querySelector('.dropdown-content'); // Selecciona el contenido desplegable

// Agrega un event listener al botón para mostrar u ocultar el menú al hacer clic
dropbtn.addEventListener('click', () => {
  // Cambia la propiedad display del contenido desplegable entre 'block' y 'none'
  dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
});

// Agrega un event listener a la ventana para ocultar el menú si el usuario hace clic fuera del botón
window.addEventListener('click', (event) => {
  // Verifica si el elemento clicado no es el botón del menú
  if (!event.target.matches('.dropbtn')) {
    // Verifica si el contenido desplegable está visible
    if (dropdownContent.style.display === 'block') {
      // Oculta el contenido desplegable
      dropdownContent.style.display = 'none';
    }
  }
});