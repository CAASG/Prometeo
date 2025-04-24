# <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/fire.svg" width="36" height="36"/> Prometeo - Plataforma de Gestión de Encuentros de Semilleros

<p align="center">
  <img src="https://via.placeholder.com/800x400/FF7F50/FFFFFF?text=Prometeo" alt="Prometeo Banner" width="800"/>
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/version-1.0.0-blue.svg?style=flat-square" alt="Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/license-MIT-green.svg?style=flat-square" alt="License"></a>
  <a href="#"><img src="https://img.shields.io/badge/PHP-8.2-777BB4.svg?style=flat-square&logo=php&logoColor=white" alt="PHP"></a>
  <a href="#"><img src="https://img.shields.io/badge/Laravel-12.x-FF2D20.svg?style=flat-square&logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="#"><img src="https://img.shields.io/badge/PostgreSQL-14+-336791.svg?style=flat-square&logo=postgresql&logoColor=white" alt="PostgreSQL"></a>
</p>

Prometeo es una plataforma web desarrollada para gestionar encuentros académicos y proyectos de investigación. La aplicación permite a los usuarios registrar proyectos de investigación en diferentes categorías, realizar evaluaciones, y administrar todo el proceso desde la postulación hasta la presentación final.

## ✨ Tecnologías Utilizadas

<p align="center">
  <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/laravel.svg" width="70" alt="Laravel">&nbsp;&nbsp;&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/livewire.svg" width="70" alt="Livewire">&nbsp;&nbsp;&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/symfony.svg" width="70" alt="Filament">&nbsp;&nbsp;&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/tailwindcss.svg" width="70" alt="TailwindCSS">&nbsp;&nbsp;&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/alpinejs.svg" width="70" alt="AlpineJS">&nbsp;&nbsp;&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/postgresql.svg" width="70" alt="PostgreSQL">
</p>

- **Laravel 12.x** - Framework PHP moderno y elegante 
- **Livewire 3.x** - Para interfaces dinámicas y reactivas
- **Filament 3.3** - Panel de administración potente y flexible
- **Jetstream** - Sistema de autenticación y gestión de equipos
- **TailwindCSS** - Framework CSS para diseños personalizados
- **Alpine.js** - Framework JavaScript minimalista
- **PostgreSQL** - Sistema de gestión de bases de datos relacional

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
    <td align="center" width="80">
      <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/php.svg" width="40" alt="PHP">
    </td>
    <td>PHP 8.2 o superior</td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/composer.svg" width="40" alt="Composer">
    </td>
    <td>Composer</td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/nodejs.svg" width="40" alt="NodeJS">
    </td>
    <td>Node.js y NPM</td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/postgresql.svg" width="40" alt="PostgreSQL">
    </td>
    <td>PostgreSQL 14.0+</td>
  </tr>
</table>

### Extensiones PHP requeridas:

<p>
  <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/json.svg" width="25" alt="JSON">&nbsp;JSON&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/xml.svg" width="25" alt="XML">&nbsp;XML&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@master/public/logos/curl.svg" width="25" alt="cURL">&nbsp;cURL&nbsp;&nbsp;
  BCMath, Ctype, DOM, Fileinfo, Mbstring, OpenSSL, PDO, Tokenizer
</p>

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

```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=prometeo
DB_USERNAME=postgres
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

<!-- CDN for the coloured icons -->
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/gh/dheereshagrwal/coloured-icons@1.9.0/src/app/ci.min.css"
/>
