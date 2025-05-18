const subscriptionKey = '4R9UpzNon2v9gm92oiS8GGtctWPuJgGIjBapvST5qrTEx0aJRsKlJQQJ99BEACLArgHXJ3w3AAAbACOGcMyC';
const endpoint = 'https://api.cognitive.microsofttranslator.com';
const region = 'southcentralus';

// Lee el idioma guardado o usa español por defecto
let isSpanish = localStorage.getItem('vitalnews_lang') !== 'en';

// Sincroniza isSpanish con localStorage siempre que se cargue la página
isSpanish = localStorage.getItem('vitalnews_lang') !== 'en';

document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('translateBtn');
    if (!btn) return;

    btn.addEventListener('click', async () => {
        // Sincroniza siempre antes de alternar
        isSpanish = localStorage.getItem('vitalnews_lang') !== 'en';
        if (isSpanish) {
            await traducirAPagina('en');
            isSpanish = false;
            localStorage.setItem('vitalnews_lang', 'en');
            // Forzar los placeholders con data-force-en
            document.querySelectorAll('.traducible-placeholder[data-force-en]').forEach(input => {
                input.placeholder = input.getAttribute('data-force-en');
            });
        } else {
            restaurarEspanol();
            isSpanish = true;
            localStorage.setItem('vitalnews_lang', 'es');
        }
    });

    // Si el idioma guardado es inglés, traduce al cargar
    if (!isSpanish) {
        traducirAPagina('en');
        // Forzar los placeholders con data-force-en
        document.querySelectorAll('.traducible-placeholder[data-force-en]').forEach(input => {
            input.placeholder = input.getAttribute('data-force-en');
        });
    }
});

async function traducirAPagina(toLang) {
    const elements = document.querySelectorAll('[data-translate]');
    const inputsConPlaceholder = document.querySelectorAll('.traducible-placeholder');

    // Guarda el texto original solo la primera vez
    elements.forEach(el => {
        if (!el.hasAttribute('data-original')) {
            el.setAttribute('data-original', el.innerText);
        }
    });
    inputsConPlaceholder.forEach(input => {
        if (!input.hasAttribute('data-original-placeholder')) {
            input.setAttribute('data-original-placeholder', input.placeholder);
        }
    });

    const texts = [
        ...Array.from(elements).map(el => el.hasAttribute('data-force-en') ? el.getAttribute('data-force-en') : el.getAttribute('data-original')),
        ...Array.from(inputsConPlaceholder).map(input => input.getAttribute('data-original-placeholder'))
    ];
    const filteredTexts = texts.filter(text => text && text.trim());

    if (filteredTexts.length === 0) return;

    const fromLang = toLang === 'en' ? 'es' : 'en';

    try {
        const response = await fetch(`${endpoint}/translate?api-version=3.0&from=${fromLang}&to=${toLang}`, {
            method: 'POST',
            headers: {
                'Ocp-Apim-Subscription-Key': subscriptionKey,
                'Ocp-Apim-Subscription-Region': region,
                'Content-type': 'application/json'
            },
            body: JSON.stringify(filteredTexts.map(text => ({ Text: text })))
        });

        const data = await response.json();

        if (!Array.isArray(data) || data.length !== filteredTexts.length) return;

        let offset = 0;
        elements.forEach(el => {
            if (!isSpanish && el.hasAttribute('data-force-en')) {
                el.innerText = el.getAttribute('data-force-en');
                offset++; // Saltar este texto en la respuesta de la API
            } else {
                el.innerText = data[offset++].translations[0].text;
            }
        });
        inputsConPlaceholder.forEach(input => {
            // Forzar traducción si tiene data-force-en
            if (!isSpanish && input.hasAttribute('data-force-en')) {
                input.placeholder = input.getAttribute('data-force-en');
                offset++;
            } else {
                input.placeholder = data[offset++].translations[0].text;
            }
        });
    } catch (error) {
        console.error('Error al traducir:', error);
    }
}

function restaurarEspanol() {
    const elements = document.querySelectorAll('[data-translate]');
    const inputsConPlaceholder = document.querySelectorAll('.traducible-placeholder');
    elements.forEach(el => {
        if (el.hasAttribute('data-original')) {
            el.innerText = el.getAttribute('data-original');
        }
    });
    inputsConPlaceholder.forEach(input => {
        // Siempre restaura el placeholder original, aunque tenga data-force-en
        if (input.hasAttribute('data-original-placeholder')) {
            input.placeholder = input.getAttribute('data-original-placeholder');
        }
    });
}

// Diccionario para SweetAlert y textos dinámicos
const translationsDict = {
    "INICIO DE SESION": "LOGIN",
    "Usuario": "Username",
    "Nombre de usuario": "Username",
    "Clave de seguridad": "Security key",
    "Contraseña": "Password",
    "Recuperar Contraseña": "Recover Password",
    "Recordar contraseña": "Remember password",
    "Entrar": "Enter",
    "¿No tiene cuenta?": "Don't have an account?",
    "Registrar": "Register",
    "¿Quiere regresar al ": "Do you want to return to the",
    "Inicio?": "Home?",
    "Buscar":"Search",
    "Idioma": "Language",
    "Ir al inicio": "Go to Home",
    "Faltan campos": "Missing fields",
    "Por favor completa todos los campos.": "Please complete all fields.",
    "Usuario no encontrado": "User not found",
    "Verifica el nombre de usuario.": "Check the username.",
    "Contraseña incorrecta": "Incorrect password",
    "Verifica tu clave de seguridad.": "Check your security key.",
    "¡Bienvenido!": "Welcome!",
    "Inicio de sesión exitoso.": "Login successful.",
    "¡Registro exitoso!": "Successful registration!",
    "Tu cuenta ha sido registrada correctamente.": "Your account has been successfully registered.",
    "Listo": "Done",
    "¡Error de registro!": "Registration error!",
    "El nombre de usuario o el correo electrónico ya están registrados.": "Username or email is already registered.",
    "Intentar de nuevo": "Try again",
    "Correo inválido": "Invalid email",
    "Introduce un correo electrónico válido (ej. ejemplo@dominio.com).": "Enter a valid email address (e.g. example@domain.com).",
    "Contraseña inválida": "Invalid password",
    "Debe tener al menos 10 caracteres y no contener espacios.": "Must be at least 10 characters and contain no spaces.",
    "¿Estás seguro?": "Are you sure?",
    "Se enviará el formulario para registrar tu cuenta.": "The form will be submitted to register your account.",
    "Sí, registrar": "Yes, register",
    "Cancelar": "Cancel",
    "Cancelado": "Cancelled",
    "Tu registro ha sido cancelado.": "Your registration has been cancelled.",
    // Para recuperar contraseña
    "RECUPERAR CONTRASEÑA": "RECOVER PASSWORD",
    "Correo Electrónico": "Email",
    "Enviar enlace de recuperación": "Send recovery link",
    "¿Ya tienes cuenta?": "Already have an account?",
    "Iniciar Sesión": "Login",
    "Campo vacío": "Empty field",
    "Por favor ingresa tu correo electrónico.": "Please enter your email address.",
    "¿Enviar enlace de recuperación?": "Send recovery link?",
    "Se enviará un enlace a tu correo si está registrado.": "A link will be sent to your email if it is registered.",
    "Enviar": "Send",
    "¡Enlace enviado!": "Link sent!",
    "Revisa tu correo electrónico para continuar.": "Check your email to continue.",
    "Correo no encontrado": "Email not found",
    "ejemplo@correo.com": "example@email.com",
    "Idioma": "Language",
    "Language": "Idioma",
    "El correo ingresado no está registrado.": "The entered email is not registered.",
    //Actualizar contraseña
    "Actualizar": "Update",
    "¿Actualizar contraseña?": "Update password?",
    "¿Deseas cambiar tu contraseña?": "Do you want to change your password?",
    "¡Contraseña actualizada!": "Password updated!",
    "Tu contraseña ha sido cambiada correctamente.": "Your password has been changed successfully.",
    "Token inválido o expirado": "Invalid or expired token",
    "El enlace de recuperación no es válido o ya expiró.": "The recovery link is invalid or has expired.",
    "Nueva contraseña": "New password",
    "NEW PASSWORD": "NEW PASSWORD",
    "Already have an account?": "Already have an account?",
    "Language": "Language",
    "Idioma": "Language",
    "Por favor ingresa tu nueva contraseña.": "Please enter your new password.",
    "Iniciar sesión": "Login"
};

window.translate = function(text) {
    if (!isSpanish && translationsDict[text]) {
        return translationsDict[text];
    }
    return text;
};