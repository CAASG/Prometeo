# Prometeo - Plataforma de Gestión de Encuentros de Semilleros

Prometeo es una plataforma web desarrollada para gestionar encuentros académicos y proyectos de investigación. La aplicación permite a los usuarios registrar proyectos de investigación en diferentes categorías, realizar evaluaciones, y administrar todo el proceso desde la postulación hasta la presentación final.

## ✨ Tecnologías Utilizadas

- **Laravel 12.x** - Framework PHP moderno y elegante 
- **Livewire 3.x** - Para interfaces dinámicas y reactivas
- **Filament 3.3** - Panel de administración potente y flexible
- **Jetstream** - Sistema de autenticación y gestión de equipos
- **TailwindCSS** - Framework CSS para diseños personalizados
- **Alpine.js** - Framework JavaScript minimalista
- **PostgreSQL** - Sistema de gestión de bases de datos relacional

## 🚀 Funcionalidades Principales

- 👥 Registro y gestión de usuarios (estudiantes, evaluadores, administradores)
- 📝 Postulación y seguimiento de proyectos de investigación
- 🔖 Categorización de proyectos (Fase Inicial, En Desarrollo, Finalizado)
- ⭐ Sistema de evaluación y retroalimentación
- 📅 Gestión de cronograma de actividades
- 📊 Dashboard administrativo
- 🏆 Generación de certificados

## 📂 Estructura del Proyecto

```
.
├── app/
│   ├── Actions/        # Acciones de Fortify/Jetstream
│   ├── Filament/       # Recursos, Páginas y Widgets de Filament
│   ├── Helpers/        # Clases de ayuda personalizadas
│   ├── Http/
│   │   └── Controllers/ # Controladores HTTP
│   ├── Livewire/       # Componentes de Livewire
│   ├── Models/         # Modelos Eloquent
│   ├── Observers/      # Observadores de Modelos
│   ├── Policies/       # Políticas de Autorización
│   ├── Providers/      # Proveedores de Servicios (AuthServiceProvider, RouteServiceProvider, etc.)
│   └── View/           # View Composers, Components
├── bootstrap/
│   └── cache/          # Archivos de caché generados por el framework
├── config/             # Archivos de configuración (app, auth, database, etc.)
├── database/
│   ├── factories/      # Factorías de modelos para testing y seeding
│   ├── migrations/     # Migraciones de base deatos
│   └── seeders/        # Seeders de base de datos
├── public/             # Directorio raíz público (assets compilados, index.php)
│   ├── build/          # Assets compilados por Vite
│   ├── css/
│   ├── images/
│   ├── js/
│   └── storage/        # Enlace simbólico a storage/app/public
├── resources/
│   ├── css/            # Archivos CSS fuente (app.css)
│   ├── js/             # Archivos JavaScript fuente (app.js)
│   ├── markdown/       # Vistas de correo en Markdown
│   └── views/          # Vistas Blade
│       ├── auth/         # Vistas de autenticación (login, register, etc.)
│       ├── components/   # Componentes Blade anónimos
│       ├── emails/       # Plantillas de correo electrónico
│       ├── filament/     # Vistas personalizadas para Filament
│       ├── layouts/      # Plantillas de layout (app.blade.php, guest.blade.php)
│       ├── livewire/     # Vistas para componentes Livewire
│       ├── profile/      # Vistas de perfil de usuario de Jetstream
│       └── projects/     # Vistas relacionadas con proyectos
├── routes/             # Definiciones de rutas (web.php, api.php, console.php)
├── storage/            # Almacenamiento (logs, uploads, cache, etc.)
│   ├── app/
│   │   └── public/     # Archivos accesibles públicamente (enlazados desde public/storage)
│   ├── framework/
│   └── logs/
├── tests/              # Pruebas automatizadas
│   ├── Feature/        # Pruebas de funcionalidad
│   └── Unit/           # Pruebas unitarias
├── vendor/             # Dependencias de Composer
├── .editorconfig       # Configuración del editor
├── .env.example        # Ejemplo de variables de entorno
├── .gitattributes      # Atributos de Git
├── .gitignore          # Archivos/directorios ignorados por Git
├── artisan             # Script de línea de comandos Artisan
├── composer.json       # Dependencias PHP (Composer)
├── composer.lock       # Versiones exactas de dependencias PHP
├── package.json        # Dependencias JavaScript (npm/yarn)
├── package-lock.json   # Versiones exactas de dependencias JavaScript
├── phpunit.xml         # Configuración de PHPUnit
├── postcss.config.js   # Configuración de PostCSS
├── README.md           # Este archivo
├── tailwind.config.js  # Configuración de TailwindCSS
└── vite.config.js      # Configuración de Vite
```

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
      <img src="https://www.postgresql.org/media/img/about/press/elephant.png" width="40" alt="PostgreSQL Logo">
    </td>
    <td>PostgreSQL 12+ </td>
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
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=prometeo
DB_USERNAME=postgres
DB_PASSWORD=password
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
