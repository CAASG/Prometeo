<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Prometeo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Splide CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/themes/splide-default.min.css">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                html {
                    scroll-behavior: smooth;
                }
                
                @media (prefers-reduced-motion: reduce) {
                    html {
                        scroll-behavior: auto;
                    }
                }
            </style>
        @endif
    </head>
    <body>
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="fixed top-0 left-0 w-full z-50 transition-all duration-300" id="navbar">
                    <div class="container mx-auto px-4 py-3">
                        <div class="flex items-center justify-between">
                            <!-- Logo -->
                            <div class="flex-shrink-0">
                                <a href="#" class="flex items-center">
                                    <!-- Puedes reemplazar esto con tu logo real -->
                                    <div class="h-10 w-10 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xl mr-2">P</div>
                                    <span class="text-lg font-bold text-gray-900">Prometeo</span>
                                </a>
                            </div>
                
                            <!-- Links de navegación - Visible en desktop -->
                            <div class="hidden md:flex items-center space-x-6">
                                <a href="#hero" class="text-gray-700 hover:text-orange-600 font-medium transition-colors duration-300">Inicio</a>
                                <a href="#about" class="text-gray-700 hover:text-orange-600 font-medium transition-colors duration-300">Sobre el Encuentro</a>
                                <a href="#categories" class="text-gray-700 hover:text-orange-600 font-medium transition-colors duration-300">Categorías</a>
                                <a href="#schedule" class="text-gray-700 hover:text-orange-600 font-medium transition-colors duration-300">Cronograma</a>
                            </div>
                
                            <!-- Autenticación -->
                            <div class="flex items-center space-x-4">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-300">
                                            Dashboard
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-orange-600 bg-transparent border border-orange-200 rounded-md hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-300">
                                            Log in
                                        </a>
                
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-300">
                                                Register
                                            </a>
                                        @endif
                                    @endauth
                                @endif
                
                                <!-- Botón de menú móvil -->
                                <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-orange-600 hover:bg-orange-50 focus:outline-none" id="mobile-menu-button">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                
                    <!-- Menú móvil - Oculto por defecto -->
                    <div class="md:hidden hidden bg-white border-t border-gray-200 py-2" id="mobile-menu">
                        <div class="container mx-auto px-4 py-1">
                            <a href="#hero" class="block py-2 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-lg">Inicio</a>
                            <a href="#about" class="block py-2 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-lg">Sobre el Encuentro</a>
                            <a href="#categories" class="block py-2 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-lg">Categorías</a>
                            <a href="#schedule" class="block py-2 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-lg">Cronograma</a>
                        </div>
                    </div>
                </nav>
            @endif
        </header>
        <!-- Sección Hero - Información del Encuentro -->
        <section id="hero">
            <div class="relative overflow-hidden w-full py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Grid container con control de posicionamiento -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center ">
                        <!-- Columna de texto -->
                        <div class="z-10 pb-8 sm:pb-16 md:pb-20 lg:pb-28 xl:pb-32">
                            <div>
                                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                    <span class="block">Encuentro de</span>
                                    <span class="block text-orange-600">Semilleros UNAB</span>
                                </h1>
                                <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg md:mt-5 md:text-xl">
                                    Un espacio para que estudiantes y jóvenes investigadores presenten sus proyectos de investigación, 
                                    compartan conocimientos y establezcan redes de colaboración académica.
                                </p>
                                
                                <!-- Información adicional -->
                                <div class="mt-6 prose prose-orange">
                                    <p class="text-gray-600">
                                        El Encuentro de Semilleros UNAB es un evento anual donde convergen el talento, la creatividad y el conocimiento de nuestra comunidad universitaria. 
                                    </p>
                                    <p class="text-gray-600 mt-3">
                                        Promovemos la cultura de investigación, fomentando la participación de estudiantes en diferentes etapas de sus proyectos, desde ideas innovadoras hasta investigaciones completas.
                                    </p>
                                    <p class="text-gray-600 mt-3">
                                        Esta plataforma ofrece a los participantes la oportunidad de recibir retroalimentación valiosa, establecer contactos académicos y contribuir al avance del conocimiento científico.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Columna del slider -->
                        <div class="h-64 sm:h-72 md:h-80 lg:h-96 bg-orange-600 rounded-lg overflow-hidden shadow-xl">
                            <div class="splide h-full w-full">
                                <div class="splide__track h-full">
                                    <ul class="splide__list h-full">
                                        <li class="splide__slide h-full">
                                            <img class="h-full w-full object-cover" src="https://placehold.co/800x600/FF6B00/FFFFFF.png?text=Semilleros+UNAB" alt="Semilleros UNAB">
                                        </li>
                                        <li class="splide__slide h-full">
                                            <img class="h-full w-full object-cover" src="https://placehold.co/800x600/FF8C40/FFFFFF.png?text=Investigacion" alt="Investigación">
                                        </li>
                                        <li class="splide__slide h-full">
                                            <img class="h-full w-full object-cover" src="https://placehold.co/800x600/FFA773/FFFFFF.png?text=Innovacion" alt="Innovación">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Sección 2: Información Sobre el Encuentro -->
        <section id="about">
            <div class="py-20 bg-gradient-to-br from-orange-500 to-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <span class="inline-block px-3 py-1 text-orange-600 font-semibold tracking-wider text-sm rounded-full bg-orange-100 mb-4">DESCUBRE</span>
                        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                            Sobre el <span class="text-orange-600">Encuentro</span>
                        </h2>
                        <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">
                            El Encuentro de Semilleros está abierto a estudiantes de pregrado y posgrado, jóvenes investigadores 
                            y semilleros de investigación de la UNAB y otras instituciones.
                        </p>
                    </div>

                    <!-- Cards animadas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <!-- Card 1 -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-500 hover:scale-105 hover:shadow-xl">
                            <div class="h-3 bg-orange-500"></div>
                            <div class="p-6">
                                <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Proyectos de Investigación</h3>
                                <p class="text-gray-600 mb-4">Presenta tu proyecto en cualquiera de sus fases: propuesta, en curso o finalizado.</p>
                                <div class="space-y-2">
                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Ciencias Básicas</span>
                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Ciencias de la Salud</span>
                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">Humanidades</span>
                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Económicas</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-500 hover:scale-105 hover:shadow-xl">
                            <div class="h-3 bg-orange-500"></div>
                            <div class="p-6">
                                <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Semilleros Reconocidos</h3>
                                <p class="text-gray-600 mb-4">Los semilleros pueden presentar sus avances y resultados como grupo.</p>
                                <div class="bg-orange-50 rounded-lg p-3">
                                    <p class="text-sm text-gray-700">Participen con respaldo institucional que valide su trayectoria y experiencia en el área específica de investigación.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-500 hover:scale-105 hover:shadow-xl">
                            <div class="h-3 bg-orange-500"></div>
                            <div class="p-6">
                                <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Beneficios</h3>
                                <p class="text-gray-600 mb-4">Recibe retroalimentación y establece contactos académicos valiosos.</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="text-sm text-gray-600">Visibilidad académica</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="text-sm text-gray-600">Desarrollo de habilidades</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="text-sm text-gray-600">Oportunidad de publicación</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-500 hover:scale-105 hover:shadow-xl">
                            <div class="h-3 bg-orange-500"></div>
                            <div class="p-6">
                                <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Modalidades</h3>
                                <p class="text-gray-600 mb-4">Participa mediante diferentes formatos según tu proyecto.</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-indigo-50 rounded-lg p-2 text-center">
                                        <span class="text-sm font-medium text-indigo-800">Presentación Oral</span>
                                    </div>
                                    <div class="bg-pink-50 rounded-lg p-2 text-center">
                                        <span class="text-sm font-medium text-pink-800">Póster Científico</span>
                                    </div>
                                    <div class="bg-teal-50 rounded-lg p-2 text-center col-span-2">
                                        <span class="text-sm font-medium text-teal-800">Demostración Práctica</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Requisitos con estilo moderno y llamativo -->
                    <div class="mt-16 relative">
                        <div class="absolute inset-0 bg-orange-600 transform -skew-y-3 z-0 rounded-3xl"></div>
                        <div class="relative z-10 bg-white rounded-xl shadow-xl p-8 md:p-10 mt-6">
                            <div class="flex flex-col md:flex-row items-center md:items-start mb-8">
                                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-4 md:mb-0 md:mr-6">
                                    <svg class="w-8 h-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Requisitos de participación</h3>
                                    <p class="text-gray-600">Conoce lo que necesitas para ser parte de esta experiencia académica transformadora.</p>
                                </div>
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
                                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Para estudiantes
                                    </h4>
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-sm font-bold text-white bg-blue-500 rounded-full">1</span>
                                            <span class="text-gray-700">Estar matriculado en una institución de educación superior</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-sm font-bold text-white bg-blue-500 rounded-full">2</span>
                                            <span class="text-gray-700">Contar con un proyecto con resultados preliminares o finales</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-sm font-bold text-white bg-blue-500 rounded-full">3</span>
                                            <span class="text-gray-700">Tener un docente tutor que respalde el proyecto</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-sm font-bold text-white bg-blue-500 rounded-full">4</span>
                                            <span class="text-gray-700">Cumplir con los formatos y plazos establecidos</span>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-orange-500">
                                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 text-orange-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Para semilleros
                                    </h4>
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-sm font-bold text-white bg-orange-500 rounded-full">1</span>
                                            <span class="text-gray-700">Estar formalmente constituidos y reconocidos por su institución</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-sm font-bold text-white bg-orange-500 rounded-full">2</span>
                                            <span class="text-gray-700">Presentar proyectos acordes a sus líneas de investigación</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-sm font-bold text-white bg-orange-500 rounded-full">3</span>
                                            <span class="text-gray-700">Designar representantes para las presentaciones</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-sm font-bold text-white bg-orange-500 rounded-full">4</span>
                                            <span class="text-gray-700">Incluir la participación de estudiantes activos</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección de Categorías -->
        <section id="categories" class="py-20 w-full bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <span class="inline-block px-3 py-1 text-orange-600 font-semibold tracking-wider text-sm rounded-full bg-orange-100 mb-4">PARTICIPA</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Categorías de <span class="text-orange-600">Participación</span>
                    </h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                        Selecciona la categoría que mejor se adapte al estado actual de tu proyecto de investigación.
                    </p>
                    <div class="w-24 h-1 bg-orange-500 mx-auto mt-6"></div>
                </div>

                <!-- Tarjetas de categorías -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                    <!-- Categoría: Propuesta -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
                        <div class="relative h-48 overflow-hidden">
                            <div class="absolute top-0 right-0 bg-orange-500 text-white px-4 py-2 rounded-bl-lg font-semibold z-10">
                                Propuesta
                            </div>
                            <img class="w-full h-full object-cover transform transition-transform duration-700 hover:scale-110" 
                                src="https://placehold.co/800x400/FF9F50/FFFFFF.png?text=Propuesta" 
                                alt="Propuesta">
                        </div>
                        <div class="p-6 border-t border-gray-100">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Fase Inicial</h3>
                            </div>
                            <p class="text-gray-600 mb-6">
                                Proyectos en fase inicial con planteamiento del problema, objetivos, metodología y resultados esperados definidos, 
                                pero sin haber comenzado su ejecución.
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-center text-sm text-gray-600">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Recibe retroalimentación temprana
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Fortalece el planteamiento inicial
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Establece contactos y colaboraciones
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Categoría: En Curso -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
                        <div class="relative h-48 overflow-hidden">
                            <div class="absolute top-0 right-0 bg-blue-500 text-white px-4 py-2 rounded-bl-lg font-semibold z-10">
                                En Curso
                            </div>
                            <img class="w-full h-full object-cover transform transition-transform duration-700 hover:scale-110" 
                                src="https://placehold.co/800x400/4A89DC/FFFFFF.png?text=En+Curso" 
                                alt="En Curso">
                        </div>
                        <div class="p-6 border-t border-gray-100">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Desarrollo Activo</h3>
                            </div>
                            <p class="text-gray-600 mb-6">
                                Investigaciones que se encuentran en plena fase de ejecución, con resultados preliminares 
                                y avances significativos que puedan ser presentados.
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-center text-sm text-gray-600">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Comparte metodologías y aprendizajes
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Recibe sugerencias para mejorar
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Valida resultados preliminares
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Categoría: Finalizado -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
                        <div class="relative h-48 overflow-hidden">
                            <div class="absolute top-0 right-0 bg-green-500 text-white px-4 py-2 rounded-bl-lg font-semibold z-10">
                                Finalizado
                            </div>
                            <img class="w-full h-full object-cover transform transition-transform duration-700 hover:scale-110" 
                                src="https://placehold.co/800x400/37BC9B/FFFFFF.png?text=Finalizado" 
                                alt="Finalizado">
                        </div>
                        <div class="p-6 border-t border-gray-100">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Proyecto Completo</h3>
                            </div>
                            <p class="text-gray-600 mb-6">
                                Proyectos completados con resultados finales, conclusiones y recomendaciones. 
                                Ideal para compartir conocimientos y experiencias adquiridas.
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-center text-sm text-gray-600">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Difunde resultados de investigación
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Opta a premios y reconocimientos
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Posibilidad de publicación académica
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Sección de llamada a la acción -->
                <div class="relative">
                    <div class="absolute inset-0 bg-orange-600 transform -skew-y-2 rounded-xl z-0"></div>
                    <div class="relative z-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg overflow-hidden">
                        <div class="p-8 md:p-12">
                            <div class="flex flex-col md:flex-row items-center justify-between">
                                <div class="mb-8 md:mb-0 md:w-2/3">
                                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">¿Listo para participar?</h3>
                                    <p class="text-white text-opacity-90 leading-relaxed">
                                        Independientemente de la fase en que se encuentre tu investigación, el Encuentro de Semilleros UNAB
                                        es la plataforma ideal para dar visibilidad a tu trabajo académico y recibir retroalimentación valiosa.
                                    </p>
                                </div>
                                <div>
                                    <a href="#" class="inline-block bg-white text-orange-600 hover:bg-orange-50 font-bold py-4 px-8 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                                        Registrar mi proyecto
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección de Cronograma -->
        <section id="schedule" class="py-20 w-full bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <span class="inline-block px-3 py-1 text-orange-600 font-semibold tracking-wider text-sm rounded-full bg-orange-100 mb-4">FECHAS IMPORTANTES</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Cronograma del <span class="text-orange-600">Encuentro</span>
                    </h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                        El proceso se divide en tres fases principales. Asegúrate de cumplir con los plazos establecidos.
                    </p>
                    <div class="w-24 h-1 bg-orange-500 mx-auto mt-6"></div>
                </div>

                <!-- Timeline -->
                <div class="relative max-w-5xl mx-auto">
                    <!-- Línea vertical central (visible solo en desktop) -->
                    <div class="absolute hidden md:block left-1/2 transform -translate-x-1/2 h-full w-1 bg-orange-200 z-0"></div>

                    <!-- Fase 1 -->
                    <div class="relative mb-16 md:mb-12">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 md:pr-8 md:text-right order-2 md:order-1">
                                <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-orange-500 transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
                                    <h3 class="text-2xl font-bold text-orange-600 mb-3">Fase 1: Postulación</h3>
                                    <p class="text-gray-700 mb-4">
                                        Período de recepción de proyectos, revisión preliminar y clasificación en categorías.
                                    </p>
                                    <ul class="space-y-3">
                                        <li class="flex md:flex-row-reverse items-center">
                                            <svg class="h-5 w-5 text-orange-500 md:ml-2 mr-2 md:mr-0 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-gray-600"><strong>Inicio de convocatoria:</strong> 1 de abril, 2025</span>
                                        </li>
                                        <li class="flex md:flex-row-reverse items-center">
                                            <svg class="h-5 w-5 text-orange-500 md:ml-2 mr-2 md:mr-0 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-gray-600"><strong>Cierre de recepción:</strong> 30 de abril, 2025</span>
                                        </li>
                                        <li class="flex md:flex-row-reverse items-center">
                                            <svg class="h-5 w-5 text-orange-500 md:ml-2 mr-2 md:mr-0 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-gray-600"><strong>Revisión y clasificación:</strong> 1 al 15 de mayo, 2025</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="z-10 flex items-center justify-center order-1 md:order-2 mb-6 md:mb-0">
                                <div class="h-16 w-16 md:h-24 md:w-24 rounded-full border-4 border-orange-200 bg-orange-100 flex items-center justify-center shadow-md">
                                    <span class="text-2xl md:text-4xl font-bold text-orange-600">1</span>
                                </div>
                            </div>
                            <div class="md:w-1/2 md:pl-8 hidden md:block order-3"></div>
                        </div>
                    </div>

                    <!-- Fase 2 -->
                    <div class="relative mb-16 md:mb-12">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 md:pr-8 hidden md:block order-1"></div>
                            <div class="z-10 flex items-center justify-center order-1 md:order-2 mb-6 md:mb-0">
                                <div class="h-16 w-16 md:h-24 md:w-24 rounded-full border-4 border-orange-200 bg-orange-100 flex items-center justify-center shadow-md">
                                    <span class="text-2xl md:text-4xl font-bold text-orange-600">2</span>
                                </div>
                            </div>
                            <div class="md:w-1/2 md:pl-8 order-2 md:order-3">
                                <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-orange-500 transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
                                    <h3 class="text-2xl font-bold text-orange-600 mb-3">Fase 2: Evaluación</h3>
                                    <p class="text-gray-700 mb-4">
                                        Asignación de evaluadores, calificación del componente escrito y presentaciones presenciales.
                                    </p>
                                    <ul class="space-y-3">
                                        <li class="flex items-center">
                                            <svg class="h-5 w-5 text-orange-500 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-gray-600"><strong>Asignación de evaluadores:</strong> 16 al 20 de mayo, 2025</span>
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="h-5 w-5 text-orange-500 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-gray-600"><strong>Evaluación componente escrito:</strong> 21 al 31 de mayo, 2025</span>
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="h-5 w-5 text-orange-500 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-gray-600"><strong>Presentaciones presenciales:</strong> 5 al 8 de junio, 2025</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fase 3 -->
                    <div class="relative">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 md:pr-8 md:text-right order-2 md:order-1">
                                <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-orange-500 transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
                                    <h3 class="text-2xl font-bold text-orange-600 mb-3">Fase 3: Resultados</h3>
                                    <p class="text-gray-700 mb-4">
                                        Cálculo de notas finales, selección de ganadores y entrega de certificados.
                                    </p>
                                    <ul class="space-y-3">
                                        <li class="flex md:flex-row-reverse items-center">
                                            <svg class="h-5 w-5 text-orange-500 md:ml-2 mr-2 md:mr-0 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-gray-600"><strong>Cálculo de notas finales:</strong> 9 al 15 de junio, 2025</span>
                                        </li>
                                        <li class="flex md:flex-row-reverse items-center">
                                            <svg class="h-5 w-5 text-orange-500 md:ml-2 mr-2 md:mr-0 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-gray-600"><strong>Anuncio de ganadores:</strong> 20 de junio, 2025</span>
                                        </li>
                                        <li class="flex md:flex-row-reverse items-center">
                                            <svg class="h-5 w-5 text-orange-500 md:ml-2 mr-2 md:mr-0 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-gray-600"><strong>Ceremonia de clausura:</strong> 30 de junio, 2025</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="z-10 flex items-center justify-center order-1 md:order-2 mb-6 md:mb-0">
                                <div class="h-16 w-16 md:h-24 md:w-24 rounded-full border-4 border-orange-200 bg-orange-100 flex items-center justify-center shadow-md">
                                    <span class="text-2xl md:text-4xl font-bold text-orange-600">3</span>
                                </div>
                            </div>
                            <div class="md:w-1/2 md:pl-8 hidden md:block order-3"></div>
                        </div>
                    </div>
                </div>

                <!-- Banner resumen -->
                <div class="mt-20 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-xl overflow-hidden">
                    <div class="p-8 md:p-10">
                        <div class="flex flex-col md:flex-row items-center justify-between">
                            <div class="mb-6 md:mb-0 md:w-3/5">
                                <h3 class="text-2xl font-bold text-white mb-3">¡No te pierdas ninguna fecha importante!</h3>
                                <p class="text-white text-opacity-90">
                                    Recuerda que cada fase del proceso tiene plazos específicos. Te recomendamos agendar estas fechas 
                                    y preparar tu participación con anticipación.
                                </p>
                            </div>
                            <div class="w-full md:w-auto">
                                <a href="#" class="block text-center w-full md:w-auto bg-white text-orange-600 hover:bg-orange-50 font-bold py-3 px-8 rounded-lg shadow transition duration-300">
                                    Descargar calendario
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-gray-900 text-white pt-16 pb-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    <!-- Columna 1: Logo e información -->
                    <div>
                        <div class="flex items-center mb-6">
                            <!-- Puedes reemplazar esto con tu logo real -->
                            <div class="h-10 w-10 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xl mr-2">U</div>
                            <span class="text-lg font-bold text-white">UNAB Semilleros</span>
                        </div>
                        <p class="text-gray-400 mb-6">
                            Un espacio para que estudiantes y jóvenes investigadores presenten sus proyectos y establezcan redes de colaboración académica.
                        </p>
                        <div class="flex space-x-4">
                            <!-- Redes sociales -->
                            <a href="https://facebook.com/TuPaginaUNAB" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-orange-600 flex items-center justify-center transition-colors duration-300">
                                <i class="fab fa-facebook-f text-white"></i>
                            </a>
                            <a href="https://instagram.com/TuCuentaUNAB" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-orange-600 flex items-center justify-center transition-colors duration-300">
                                <i class="fab fa-instagram text-white"></i>
                            </a>
                            <a href="https://twitter.com/TuCuentaUNAB" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-orange-600 flex items-center justify-center transition-colors duration-300">
                                <i class="fab fa-twitter text-white"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Columna 2: Enlaces rápidos -->
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-6">Enlaces rápidos</h3>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-orange-400 transition-colors duration-300"><i class="fas fa-home mr-2 text-orange-500"></i>Inicio</a></li>
                            <li><a href="#about" class="text-gray-400 hover:text-orange-400 transition-colors duration-300"><i class="fas fa-info-circle mr-2 text-orange-500"></i>Sobre el Encuentro</a></li>
                            <li><a href="#categories" class="text-gray-400 hover:text-orange-400 transition-colors duration-300"><i class="fas fa-tags mr-2 text-orange-500"></i>Categorías</a></li>
                            <li><a href="#schedule" class="text-gray-400 hover:text-orange-400 transition-colors duration-300"><i class="fas fa-calendar-alt mr-2 text-orange-500"></i>Cronograma</a></li>
                            <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-orange-400 transition-colors duration-300"><i class="fas fa-sign-in-alt mr-2 text-orange-500"></i>Iniciar sesión</a></li>
                        </ul>
                    </div>
                    
                    <!-- Columna 3: Contacto -->
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-6">Contacto</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-map-marker-alt text-orange-500 mt-1 mr-3 w-5 text-center"></i>
                                <span class="text-gray-400">Calle 42 # 48-11, Bucaramanga, Colombia</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-envelope text-orange-500 mt-1 mr-3 w-5 text-center"></i>
                                <span class="text-gray-400">semilleros@unab.edu.co</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-phone text-orange-500 mt-1 mr-3 w-5 text-center"></i>
                                <span class="text-gray-400">+57 (7) 643-6111</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-clock text-orange-500 mt-1 mr-3 w-5 text-center"></i>
                                <span class="text-gray-400">Lunes a Viernes: 8:00 AM - 6:00 PM</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Columna 4: Boletín informativo -->
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-6">Mantente informado</h3>
                        <p class="text-gray-400 mb-4">Suscríbete para recibir actualizaciones sobre el encuentro de semilleros.</p>
                        <form action="#" method="POST" class="space-y-2">
                            <div class="relative">
                                <input type="email" placeholder="Tu correo electrónico" class="w-full px-4 py-2 pl-10 rounded-md bg-gray-800 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 text-gray-200">
                                <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                            </div>
                            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i> Suscribirse
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Línea divisoria -->
                <div class="border-t border-gray-800 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-gray-400 text-sm">© {{ date('Y') }} Universidad Autónoma de Bucaramanga. Todos los derechos reservados.</p>
                        <div class="mt-4 md:mt-0">
                            <ul class="flex space-x-6">
                                <li><a href="#" class="text-gray-400 hover:text-orange-400 text-sm">Política de privacidad</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-orange-400 text-sm">Términos de servicio</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-orange-400 text-sm">Mapa del sitio</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif

        <!-- Splide JS -->
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Splide('.splide', {
                    type: 'loop',
                    perPage: 1,
                    autoplay: true,
                    interval: 5000,
                    pauseOnHover: false,
                    arrows: false,
                    pagination: true,
                }).mount();
            });
        </script>

        <!-- Script para navbar sticky con efecto de fondo al hacer scroll -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const navbar = document.getElementById('navbar');
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');

                // Función para controlar la apariencia de la navbar al hacer scroll
                function updateNavbar() {
                    if (window.scrollY > 50) {
                        navbar.classList.add('bg-white', 'shadow-md');
                        navbar.classList.remove('bg-transparent');
                    } else {
                        navbar.classList.remove('bg-white', 'shadow-md');
                        navbar.classList.add('bg-transparent');
                    }
                }

                // Inicialización
                updateNavbar();
                window.addEventListener('scroll', updateNavbar);

                // Toggle para el menú móvil
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });

                // Cerrar el menú móvil al hacer clic en un enlace
                const mobileLinks = mobileMenu.querySelectorAll('a');
                mobileLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.add('hidden');
                    });
                });

                // Scroll suave para los enlaces de navegación
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        
                        if (targetId === '#') {
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                        } else {
                            const target = document.querySelector(targetId);
                            if (target) {
                                const navbarHeight = navbar.offsetHeight;
                                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
                                
                                window.scrollTo({
                                    top: targetPosition,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    });
                });
            });
        </script>
        <!-- Script para smooth scrolling mejorado -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Selecciona todos los enlaces internos (los que comienzan con #)
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        
                        // Si es solo # (enlace a inicio), desplazar al inicio
                        if (targetId === '#') {
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                            return;
                        }
                        
                        // Buscar el elemento de destino
                        const target = document.querySelector(targetId);
                        if (target) {
                            // Obtener la altura de la navbar para compensar la posición de scroll
                            const navbar = document.getElementById('navbar');
                            const navbarHeight = navbar ? navbar.offsetHeight : 0;
                            
                            // Calcular la posición ajustada
                            const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
                            
                            // Realizar el desplazamiento suave
                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth'
                            });
                            
                            // Anteriormente actualizábamos la URL con:
                            // history.pushState(null, null, targetId);
                            // Ahora NO actualizamos la URL para mantenerla limpia
                        }
                    });
                });
            });
        </script>
    </body>
</html>
