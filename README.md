# XAMPP Docker Setup

Este proyecto simula un entorno XAMPP usando Docker con Apache, PHP y MySQL.

## Servicios Incluidos

- **Apache + PHP 8.2**: Servidor web con PHP (Puerto 80)
- **MySQL 8.0**: Base de datos (Puerto 3306)
- **phpMyAdmin**: Interfaz web para MySQL (Puerto 8888)

## Credenciales MySQL

- **Usuario root**: `root`
- **Contraseña root**: `root`
- **Usuario**: `usuario`
- **Contraseña**: `password`
- **Base de datos**: `testdb`

## Uso

### Iniciar los servicios

```bash
docker-compose up -d
```

### Detener los servicios

```bash
docker-compose down
```

### Ver logs

```bash
docker-compose logs -f
```

### Acceder a los servicios

- **Aplicación web**: http://localhost
- **phpMyAdmin**: http://localhost:8888
- **MySQL**: localhost:3306

## Estructura de Carpetas

- `www/`: Coloca aquí tus archivos PHP/HTML
- `php.ini`: Configuración personalizada de PHP
- `docker-compose.yml`: Configuración de Docker

## Notas

- Los archivos en `www/` se sincronizan automáticamente con el contenedor
- Los datos de MySQL se persisten en un volumen Docker
- Para reiniciar desde cero, usa: `docker-compose down -v`
# blind_chat
