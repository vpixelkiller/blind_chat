<?php

// --- Parte 1: Simulación de Registro / Almacenamiento de Contraseña ---
echo "## 📝 Paso 1: Generar y Almacenar el Hash\n";

// 1. La contraseña que el usuario introduce al registrarse.
$contrasena_texto_plano = "MiContrasenaSuperSegura123";

// 2. Usamos password_hash() para cifrar la contraseña.
//    PASSWORD_DEFAULT selecciona el mejor algoritmo disponible (actualmente Argon2i o Bcrypt).
//    ¡El hash generado es la única cosa que deberías almacenar en tu base de datos!
$hash_almacenado = password_hash($contrasena_texto_plano, PASSWORD_DEFAULT);

echo "Contraseña de Texto Plano: " . $contrasena_texto_plano . "\n";
echo "Hash Generado y Almacenado: " . $hash_almacenado . "\n";
echo "--- \n";


// --- Parte 2: Simulación de Inicio de Sesión / Verificación de Contraseña ---
echo "## 🔍 Paso 2: Verificar la Contraseña al Iniciar Sesión\n";

// 3. Contraseña introducida por el usuario al iniciar sesión (EXITOSA).
$intento_exitoso = "MiContrasenaSuperSegura123";

// 4. Usamos password_verify() para comparar el intento con el hash almacenado.
//    Nunca se descifra el hash; en su lugar, se hashea el intento con la misma
//    información contenida en el hash y se comparan los resultados.
if (password_verify($intento_exitoso, $hash_almacenado)) {
    echo "Intento 1 (Éxito): '" . $intento_exitoso . "'\n";
    echo "**¡Verificación EXITOSA!** El usuario puede iniciar sesión.\n";
} else {
    echo "**¡Verificación FALLIDA!** Contraseña incorrecta.\n";
}

echo "--- \n";

// 5. Contraseña introducida por el usuario al iniciar sesión (FALLIDA).
$intento_fallido = "ContrasenaIncorrecta456";

if (password_verify($intento_fallido, $hash_almacenado)) {
    echo "**¡Verificación EXITOSA!** El usuario puede iniciar sesión.\n";
} else {
    echo "Intento 2 (Fallo): '" . $intento_fallido . "'\n";
    echo "**¡Verificación FALLIDA!** Contraseña incorrecta.\n";
}

?>