document.addEventListener('DOMContentLoaded', function() {  
    const newsItems = document.querySelectorAll('.news-item');  

    const options = {  
        root: null, // Usar el viewport  
        rootMargin: '0px',  
        threshold: 0.1 // Activar cuando el 10% del elemento es visible  
    };  

    const callback = (entries, observer) => {  
        entries.forEach(entry => {  
            if (entry.isIntersecting) {  
                entry.target.classList.add('visible'); // Añadir clase de visibilidad  
                observer.unobserve(entry.target); // Dejar de observar  
            }  
        });  
    };  

    const observer = new IntersectionObserver(callback, options);  
    
    newsItems.forEach(item => {  
        observer.observe(item); // Observar cada noticia  
    });  
});  