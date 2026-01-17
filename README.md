# Blind chat project

## This proyect tries to bring easily and private communication about personal problems with complete privacy for the user

## Up & Run services

### With docker

- Backend:

```bash
docker-compose up -d
```

- When running `docker compose up`, the entire structure is started and, the first time, the database migration is executed.

- Frontend:
  You can serve these files with any local HTTP server:

```bash
  python3 -m http.server 3000 ||
  npx hptt-server -p 3000 ||
  php -S localhost:3000
```

### Access services

- **[http://localhost:3000](http://localhost:3000)** in your browser. If the port is in use, npx will indicate its use on another port.
- **phpMyAdmin**: [http://localhost:8888](http://localhost:8888)
- **MySQL**: [localhost:3306](mysql://localhost:3306)

## Included services

- **Apache + PHP 8.2**: Web server in PHP (Puerto 80)
- **MySQL 8.0**: Database (Puerto 3306)
- **phpMyAdmin**: MySQL interface (Puerto 8888)

## MySQL credentials

- **User root**: `root`
- **Password root**: `root`
- **User**: `usuario`
- **Password**: `password`
- **DB name**: `testdb`

## Structure

### Backend and Frontend Separation

- Backend:
  -- www
- Frontend:
  -- `front/index.html` - Main user page
  -- `front/backoffice.html` - Backoffice page
  -- `app.js` - Application logic
  -- `styles.css` - Styles
  -- `config.js` - Backend URL configuration
- Root:
  -- files needed for configuration and execution

## Configuration

Edit `config.js` to change the backend URL if needed:

```javascript
const API_BASE_URL = "http://localhost/login-app";
```

## Notes

- Los archivos en `www/` se sincronizan automáticamente con el contenedor
- Los datos de MySQL se persisten en un volumen Docker
- Para reiniciar desde cero, usa: `docker-compose down -v`
- The backend must be running at `http://localhost/login-app`
- Session cookies will work correctly thanks to CORS configuration
- Make sure the port in `config.js` matches the port where you serve the frontend
