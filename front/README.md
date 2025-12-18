# Frontend - Login App

Esta carpeta contiene los archivos del frontend que ahora se ejecutan fuera del contenedor Docker o del servidor Apache en su caso.

## Estructura

- `index.html` - Página principal
- `app.js` - Lógica de la aplicación
- `styles.css` - Estilos
- `config.js` - Configuración de la URL del backend

## Configuración

Edita `config.js` para cambiar la URL del backend si es necesario:

```javascript
const API_BASE_URL = "http://localhost/login-app";
```

## Ejecución

Puedes servir estos archivos con cualquier servidor HTTP local:

### Con Python:

```bash
python3 -m http.server 3000
```

### Con Node.js (http-server):

```bash
npx http-server -p 3000
```

### Con PHP:

```bash
php -S localhost:3000
```

Luego abre `http://localhost:3000` en tu navegador.

## Notas

- El backend debe estar ejecutándose en `http://localhost/login-app`
- Las cookies de sesión funcionarán correctamente gracias a la configuración CORS
- Asegúrate de que el puerto en `config.js` coincida con el puerto donde sirves el frontend
