@extends("layout")
@section("title","Test")

@section("content")
    <div class="bg-background min-h-screen p-8">
        <div class="max-w-4xl mx-auto space-y-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-foreground mb-4">Test de Componentes</h1>
                <p class="text-foreground-muted text-lg">Pruebas de botones, colores y estados hover</p>
            </div>

            <!-- Botones de diferentes tamaños -->
            <section class="bg-surface rounded-lg p-6 border border-border">
                <h2 class="text-2xl font-bold text-foreground mb-6">Botones Principales</h2>
                
                <!-- Botones grandes -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-foreground mb-4">Botones Grandes</h3>
                    <div class="flex flex-wrap gap-4">
                        <button class="bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-md font-medium transition-colors shadow-sm">
                            Primary Button
                        </button>
                        <button class="bg-success hover:bg-success-hover text-white px-6 py-3 rounded-md font-medium transition-colors shadow-sm">
                            Success Button
                        </button>
                        <button class="bg-warning hover:bg-warning-hover text-white px-6 py-3 rounded-md font-medium transition-colors shadow-sm">
                            Warning Button
                        </button>
                        <button class="bg-danger hover:bg-danger-hover text-white px-6 py-3 rounded-md font-medium transition-colors shadow-sm">
                            Danger Button
                        </button>
                    </div>
                </div>

                <!-- Botones medianos -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-foreground mb-4">Botones Medianos</h3>
                    <div class="flex flex-wrap gap-3">
                        <button class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-md font-medium transition-colors text-sm">
                            Primary
                        </button>
                        <button class="bg-success hover:bg-success-hover text-white px-4 py-2 rounded-md font-medium transition-colors text-sm">
                            Success
                        </button>
                        <button class="bg-warning hover:bg-warning-hover text-white px-4 py-2 rounded-md font-medium transition-colors text-sm">
                            Warning
                        </button>
                        <button class="bg-danger hover:bg-danger-hover text-white px-4 py-2 rounded-md font-medium transition-colors text-sm">
                            Danger
                        </button>
                    </div>
                </div>

                <!-- Botones outline -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-foreground mb-4">Botones Outline</h3>
                    <div class="flex flex-wrap gap-4">
                        <button class="border-2 border-primary text-primary hover:bg-primary hover:text-white px-6 py-3 rounded-md font-medium transition-colors">
                            Primary Outline
                        </button>
                        <button class="border-2 border-success text-success hover:bg-success hover:text-white px-6 py-3 rounded-md font-medium transition-colors">
                            Success Outline
                        </button>
                        <button class="border-2 border-warning text-warning hover:bg-warning hover:text-white px-6 py-3 rounded-md font-medium transition-colors">
                            Warning Outline
                        </button>
                        <button class="border-2 border-danger text-danger hover:bg-danger hover:text-white px-6 py-3 rounded-md font-medium transition-colors">
                            Danger Outline
                        </button>
                    </div>
                </div>
            </section>

            <!-- Textos con diferentes estilos -->
            <section class="bg-surface rounded-lg p-6 border border-border">
                <h2 class="text-2xl font-bold text-foreground mb-6">Textos y Enlaces</h2>
                
                <div class="space-y-6">
                    <!-- Textos normales -->
                    <div>
                        <h3 class="text-lg font-medium text-foreground mb-4">Textos con Colores</h3>
                        <div class="space-y-2">
                            <p class="text-foreground">Este es un texto con color foreground principal</p>
                            <p class="text-foreground-muted">Este es un texto con color foreground muted (secundario)</p>
                            <p class="text-primary hover:text-primary-hover transition-colors cursor-pointer">Texto primary con hover</p>
                            <p class="text-success hover:text-success-hover transition-colors cursor-pointer">Texto success con hover</p>
                            <p class="text-warning hover:text-warning-hover transition-colors cursor-pointer">Texto warning con hover</p>
                            <p class="text-danger hover:text-danger-hover transition-colors cursor-pointer">Texto danger con hover</p>
                        </div>
                    </div>

                    <!-- Enlaces -->
                    <div>
                        <h3 class="text-lg font-medium text-foreground mb-4">Enlaces con Hover</h3>
                        <div class="space-y-2">
                            <div><a href="#" class="text-primary hover:text-primary-hover hover:underline transition-colors font-medium">Enlace Primary</a></div>
                            <div><a href="#" class="text-success hover:text-success-hover hover:underline transition-colors font-medium">Enlace Success</a></div>
                            <div><a href="#" class="text-warning hover:text-warning-hover hover:underline transition-colors font-medium">Enlace Warning</a></div>
                            <div><a href="#" class="text-danger hover:text-danger-hover hover:underline transition-colors font-medium">Enlace Danger</a></div>
                            <div><a href="#" class="text-foreground hover:text-foreground-muted hover:underline transition-colors font-medium">Enlace Foreground</a></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tarjetas con colores de fondo -->
            <section class="bg-surface rounded-lg p-6 border border-border">
                <h2 class="text-2xl font-bold text-foreground mb-6">Tarjetas con Fondos</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Tarjeta Success -->
                    <x-card tipo="success" titulo="Success" accionTexto="Acción">
                        <p class="text-foreground-muted text-sm">Esta es una tarjeta de éxito con fondo claro</p>
                    </x-card>

                    <!-- Tarjeta Warning -->
                    <x-card tipo="warning" titulo="Warning" accionTexto="Acción">
                        <p class="text-foreground-muted text-sm">Esta es una tarjeta de advertencia con fondo claro</p>
                    </x-card>

                    <!-- Tarjeta Danger -->
                    <x-card tipo="danger" titulo="Danger" accionTexto="Acción">
                        <p class="text-foreground-muted text-sm">Esta es una tarjeta de peligro con fondo claro</p>
                    </x-card>

                    <!-- Tarjeta Surface -->
                    <x-card tipo="primary" titulo="Surface" accionTexto="Acción">
                        <p class="text-foreground-muted text-sm">Esta es una tarjeta con fondo surface secundario</p>
                    </x-card>
                </div>
            </section>

            <!-- Botones especiales -->
            <section class="bg-surface rounded-lg p-6 border border-border">
                <h2 class="text-2xl font-bold text-foreground mb-6">Botones Especiales</h2>
                
                <div class="flex flex-wrap gap-4">
                    <!-- Botón con icono -->
                    <button class="bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-md font-medium transition-colors shadow-sm flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Agregar
                    </button>

                    <!-- Botón deshabilitado -->
                    <button class="bg-foreground-muted text-white px-6 py-3 rounded-md font-medium cursor-not-allowed opacity-50" disabled>
                        Deshabilitado
                    </button>

                    <!-- Botón loading -->
                    <button class="bg-success hover:bg-success-hover text-white px-6 py-3 rounded-md font-medium transition-colors shadow-sm flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Cargando...
                    </button>
                </div>
            </section>
        </div>
    </div>
@endsection