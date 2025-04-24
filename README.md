# <img src="https://img.icons8.com/color/48/000000/fire-element--v1.png" width="36" height="36"/> Prometeo - Plataforma de Gestión de Encuentros de Semilleros

<p align="center">
  <img src="https://via.placeholder.com/800x400/FF7F50/FFFFFF?text=Prometeo" alt="Prometeo Banner" width="800"/>
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/version-1.0.0-blue.svg?style=flat-square" alt="Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/license-MIT-green.svg?style=flat-square" alt="License"></a>
  <a href="#"><img src="https://img.shields.io/badge/PHP-8.2-777BB4.svg?style=flat-square&logo=php&logoColor=white" alt="PHP"></a>
  <a href="#"><img src="https://img.shields.io/badge/Laravel-12.x-FF2D20.svg?style=flat-square&logo=laravel&logoColor=white" alt="Laravel"></a>
</p>

Prometeo es una plataforma web desarrollada para gestionar encuentros académicos y proyectos de investigación. La aplicación permite a los usuarios registrar proyectos de investigación en diferentes categorías, realizar evaluaciones, y administrar todo el proceso desde la postulación hasta la presentación final.

## ✨ Tecnologías Utilizadas

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo">
  </a>&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="https://livewire.laravel.com" target="_blank">
    <img src="https://github.com/livewire/livewire/raw/main/art/banner.png" width="200" alt="Livewire Logo">
  </a>
</p>

<p align="center">
  <a href="https://filamentphp.com" target="_blank">
    <img src="https://avatars.githubusercontent.com/u/77367590?s=200&v=4" width="70" alt="Filament Logo">
  </a>&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="https://jetstream.laravel.com" target="_blank">
    <img src="https://repository-images.githubusercontent.com/289351063/2b0ab080-7e11-11eb-9402-6b82ad5a560c" width="130" alt="Jetstream Logo">
  </a>&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="https://tailwindcss.com" target="_blank">
    <img src="https://tailwindcss.com/_next/static/media/tailwindcss-mark.3c5441fc7a190fb1800d4a5c7f07ba4b1345a9c8.svg" width="70" alt="TailwindCSS Logo">
  </a>&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="https://alpinejs.dev" target="_blank">
    <img src="https://alpinejs.dev/alpine_long.svg" width="130" alt="Alpine.js Logo">
  </a>&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="https://www.mysql.com" target="_blank">
    <img src="https://www.mysql.com/common/logos/logo-mysql-170x115.png" width="100" alt="MySQL Logo">
  </a>
</p>

- **Laravel 12.x** - Framework PHP moderno y elegante 
- **Livewire 3.x** - Para interfaces dinámicas y reactivas
- **Filament 3.3** - Panel de administración potente y flexible
- **Jetstream** - Sistema de autenticación y gestión de equipos
- **TailwindCSS** - Framework CSS para diseños personalizados
- **Alpine.js** - Framework JavaScript minimalista
- **MySQL/MariaDB** - Sistema de gestión de bases de datos relacional

## 🚀 Funcionalidades Principales

<p align="center">
  <img src="https://via.placeholder.com/700x300/4169E1/FFFFFF?text=Dashboard+Prometeo" alt="Dashboard Preview" width="700"/>
</p>

- 👥 Registro y gestión de usuarios (estudiantes, evaluadores, administradores)
- 📝 Postulación y seguimiento de proyectos de investigación
- 🔖 Categorización de proyectos (Fase Inicial, En Desarrollo, Finalizado)
- ⭐ Sistema de evaluación y retroalimentación
- 📅 Gestión de cronograma de actividades
- 📊 Dashboard administrativo
- 🏆 Generación de certificados

## 📋 Requisitos del Sistema

<table>
  <tr>
    <td>
      <img src="https://www.php.net/images/logos/new-php-logo.svg" width="40" alt="PHP Logo">
    </td>
    <td>PHP 8.2 o superior</td>
  </tr>
  <tr>
    <td>
      <img src="https://getcomposer.org/img/logo-composer-transparent.png" width="40" alt="Composer Logo">
    </td>
    <td>Composer</td>
  </tr>
  <tr>
    <td>
      <img src="https://nodejs.org/static/images/logo.svg" width="40" alt="Node.js Logo">
    </td>
    <td>Node.js y NPM</td>
  </tr>
  <tr>
    <td>
      <img src="https://www.mysql.com/common/logos/logo-mysql-170x115.png" width="40" alt="MySQL Logo">
    </td>
    <td>MySQL 8.0 o MariaDB 10.5+</td>
  </tr>
</table>

### Extensiones PHP requeridas:

- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML

## 💻 Instalación

Sigue estos pasos para configurar el proyecto en tu entorno local:

### 1. Clonar el repositorio

```bash
git clone https://github.com/your-username/prometeo.git
cd prometeo
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de JavaScript

```bash
npm install
```

### 4. Configurar variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurar la base de datos en el archivo .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prometeo
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

### 7. Compilar assets

```bash
npm run build
```

### 8. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

## 🛠️ Desarrollo

Para trabajar en el desarrollo del proyecto, puedes usar el siguiente comando que inicia todos los servicios necesarios (servidor web, colas, logs y vite):

```bash
composer dev
```

## 👥 Contribución

Si deseas contribuir al proyecto, por favor:

1. Crea un fork del repositorio
2. Crea una rama para tu funcionalidad (`git checkout -b feature/amazing-feature`)
3. Realiza tus cambios y haz commit (`git commit -m 'Add some amazing feature'`)
4. Sube los cambios a tu fork (`git push origin feature/amazing-feature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está licenciado bajo [MIT License](LICENSE).
