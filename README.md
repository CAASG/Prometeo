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
