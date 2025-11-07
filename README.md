# DENTIDESK Code Challenge – Mantenedor de Finanzas

Este proyecto implementa un administrador de finanzas simple (ingresos y egresos) desarrollado como parte del desafío técnico de DENTIDESK.

La aplicación se compone de:
- Backend: API REST desarrollada en PHP (sin frameworks).
- Frontend: Interfaz web construida con HTML, JavaScript y Bootstrap.
- Base de Datos: MySQL 8.
- Contenedores Docker para ejecución uniforme y despliegue rápido.

------------------------------------------------------------

## Ejecución con Docker

### Prerrequisitos
- Tener Docker Desktop instalado y en ejecución.

### Despliegue

1. Clonar este repositorio:

   git clone https://github.com/Sebastian1412/finanzas-dentidesk.git
   cd finanzas-dentidesk

2. Levantar los servicios:

   docker-compose up -d

   La primera ejecución descargará las imágenes base de PHP y MySQL. 
   Luego ejecutará init.sql para crear el esquema y datos iniciales automáticamente.

3. Una vez completado, la aplicación estará disponible en:

   - Frontend: http://localhost:8080/proyectos/finanzas-dentidesk/frontend/public/view/home.php
   - Base de datos: localhost:3307 (puede conectarse con DBeaver o TablePlus).

### Detener servicios

   docker-compose down

------------------------------------------------------------

## Arquitectura y Tecnologías

| Componente | Tecnología / Herramienta |
|-------------|---------------------------|
| Backend | PHP 8.2 (puro), API RESTful, PDO |
| Frontend | HTML5, JavaScript (ES6+), Bootstrap 5 |
| Base de Datos | MySQL 8.0 |
| DevOps / Infraestructura | Docker, Docker Compose |

------------------------------------------------------------

## Cobertura de Requisitos

### Backend
- Almacenamiento: MySQL con tablas usuarios, transacciones, tokens_api.
- Endpoints REST: API CRUD para gestión de transacciones.
- Autenticación: Middleware auth.php con tokens Bearer.
- Cálculos por mes: Endpoint GET con parámetro ?totales=1.

### Frontend
- Interfaz simple y limpia con Bootstrap 5.
- Dashboard con resumen de ingresos, egresos y ganancia neta.
- Formulario funcional para agregar transacciones.
- Diseño adaptable y minimalista.

### DevOps
- Dockerfile para aplicación PHP/Apache.
- docker-compose.yml que orquesta los servicios app y db.

------------------------------------------------------------

## Pruebas

- Los endpoints del backend pueden probarse fácilmente mediante Postman o curl.
- Archivo de prueba: test_transaccion.php permite validar inserciones y consultas básicas.

------------------------------------------------------------

## Estructura del Proyecto

finanzas-dentidesk/
├── backend/
│   ├── core/
│   ├── controllers/
│   ├── models/
│   ├── middlewares/
│   ├── database/
│   └── test_transaccion.php
├── frontend/
│   ├── public/
│   └── assets/
├── docker-compose.yml
├── Dockerfile
└── README.md

------------------------------------------------------------

## Autor

Sebastián Mella  
Desarrollador Full Stack – Desafío Técnico DENTIDESK

------------------------------------------------------------

## Licencia

Este proyecto fue desarrollado exclusivamente como prueba técnica.  
No está destinado a producción ni distribución comercial.