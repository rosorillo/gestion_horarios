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
Para que funcione el redireccionamiento de Nginx y el DNS, hay que modificar el archivo /etc/resolv.conf:
```bash
nameserver 172.20.0.53
```

## URLs
- Frontend: http://localhost:4200 / https://www.gestion-profes.es
- Backend: http://localhost:8000 / https://www.gestion-profes.es/api
- phpMyAdmin: http://localhost:8080 / https://www.gestion-profes.es/phpmyadmin
