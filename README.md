# Gestión de Horarios

## Requisitos
- Docker
- Docker Compose

## Arranque del proyecto
```bash
git clone https://github.com/rosorillo/gestion_horarios.git
cd gestion_horario
cp backend/.env.example backend/.env
docker compose up --build
# Descargar dependencias Laravel (vendor)
docker compose run --rm backend composer install
```

## DNS
Añadir en /etc/hosts:
```bash
127.0.0.1 gestion-profes.es www.gestion-profes.es
```

## URLs
- Frontend: http://localhost:4200 / https://www.gestion-profes.es
- Backend: http://localhost:8000 / https://www.gestion-profes.es/api
- phpMyAdmin: http://localhost:8080 / https://www.gestion-profes.es/phpmyadmin
