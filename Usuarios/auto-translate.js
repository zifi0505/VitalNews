const subscriptionKey = '4R9UpzNon2v9gm92oiS8GGtctWPuJgGIjBapvST5qrTEx0aJRsKlJQQJ99BEACLArgHXJ3w3AAAbACOGcMyC';
const endpoint = 'https://api.cognitive.microsofttranslator.com';
const region = 'southcentralus';

let isSpanish = true;

document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('translateBtn');
    if (!btn) return;

    btn.addEventListener('click', async () => {
        const elements = document.querySelectorAll('[data-translate]');
        const inputs = document.querySelectorAll('.traducible-placeholder');

        if (!isSpanish) {
            // Restaurar a español
            elements.forEach(el => {
                if (el.hasAttribute('data-original')) {
                    el.innerText = el.getAttribute('data-original');
                }
            });

            inputs.forEach(input => {
                if (input.hasAttribute('data-original-placeholder')) {
                    input.placeholder = input.getAttribute('data-original-placeholder');
                }
            });

            isSpanish = true;
            return;
        }

        // Guardar texto original antes de traducir
        elements.forEach(el => {
            if (!el.hasAttribute('data-original')) {
                el.setAttribute('data-original', el.innerText);
            }
        });

        inputs.forEach(input => {
            if (!input.hasAttribute('data-original-placeholder')) {
                input.setAttribute('data-original-placeholder', input.placeholder);
            }
        });

        // Traducción
        const textsToTranslate = Array.from(elements).map(el => el.innerText);
        const placeholdersToTranslate = Array.from(inputs).map(input => input.placeholder);
        const allTexts = textsToTranslate.concat(placeholdersToTranslate);

        try {
            const response = await fetch(`${endpoint}/translate?api-version=3.0&to=en`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Ocp-Apim-Subscription-Key': subscriptionKey,
                    'Ocp-Apim-Subscription-Region': region
                },
                body: JSON.stringify(allTexts.map(text => ({ Text: text })))
            });

            const data = await response.json();

            // Aplicar traducción
            data.forEach((item, index) => {
                if (index < elements.length) {
                    elements[index].innerText = item.translations[0].text;
                } else {
                    const placeholderIndex = index - elements.length;
                    inputs[placeholderIndex].placeholder = item.translations[0].text;
                }
            });

            isSpanish = false;
        } catch (error) {
            console.error('Error al traducir:', error);
        }
    });
});
