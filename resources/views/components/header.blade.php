<nav class="sticky top-0 z-50 bg-surface border-b border-border shadow-sm">
    <div class="w-full px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Mobile menu button -->
            <div class="absolute inset-y-0 left-2 sm:left-0 flex items-center sm:hidden">
                <button type="button" id="mobile-menu-button" class="relative inline-flex items-center justify-center rounded-md p-2 text-foreground-muted hover:bg-background hover:text-foreground focus:outline-2 focus:-outline-offset-1 focus:outline-primary">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Abrir menú principal</span>
                    <!-- Hamburger icon -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6" id="menu-open-icon">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <!-- Close icon -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6 hidden" id="menu-close-icon">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <!-- Logo and Desktop Navigation -->
            <div class="flex flex-1 items-center sm:items-stretch sm:justify-start pl-12 sm:pl-0">
                <!-- Logo -->
                <div class="flex shrink-0 items-center sm:pl-0">
                    <a href="{{ route("inicio") }}" class="text-foreground text-xl font-bold hover:text-foreground-muted transition-colors sm:ms-0 ms-2">
                        Anualidades anticipadas
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-2 md:space-x-4">
                        <a href="{{ route("inicio") }}" class="{{ (isset($page) && $page === "calculadora" ) ? 'bg-surface-secondary text-foreground' : 'text-foreground-muted hover:bg-surface-secondary hover:text-foreground' }} rounded-md px-2 md:px-3 py-2 text-sm font-medium transition-colors">
                            Anticipadas
                        </a>
                        <a href="{{ route("calculadora_diferida") }}" class="{{ (isset($page) && $page === "calculadoraD" ) ? 'bg-surface-secondary text-foreground' : 'text-foreground-muted hover:bg-surface-secondary hover:text-foreground' }} rounded px-2 md:px-3 py-2 text-sm font-medium transition-colors">
                            Diferida (Test)
                        </a>
                        <!-- Added About link to desktop menu -->
                        <a href="{{ route("about") }}" class="{{ (request()->routeIs('about')) ? 'bg-surface-secondary text-foreground' : 'text-foreground-muted hover:bg-surface-secondary hover:text-foreground' }} rounded px-2 md:px-3 py-2 text-sm font-medium transition-colors">
                            Acerca de
                        </a>
                        <!-- Added History Link -->
                        @auth
                        <a href="{{ route("historial") }}" class="{{ (request()->routeIs('historial')) ? 'bg-surface-secondary text-foreground' : 'text-foreground-muted hover:bg-surface-secondary hover:text-foreground' }} rounded px-2 md:px-3 py-2 text-sm font-medium transition-colors">
                            Historial
                        </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Added Auth Buttons -->
            <div class="flex items-center gap-2">
                @auth
                    <div class="hidden sm:flex items-center gap-4 mr-4">
                        <span class="text-sm text-foreground-muted">Hola, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-500 hover:text-red-600 font-medium">
                                Salir
                            </button>
                        </form>
                    </div>
                @else
                    <div class="hidden sm:flex items-center gap-2 mr-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-foreground-muted hover:text-foreground">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-medium bg-primary text-white px-3 py-1.5 rounded-md hover:bg-primary/90">
                            Registrarse
                        </a>
                    </div>
                @endauth

                <!-- Theme Toggle Button -->
                <button type="button" id="theme-toggle" class="rounded-md p-2 text-foreground-muted hover:bg-background hover:text-foreground focus:outline-2 focus:-outline-offset-1 focus:outline-primary transition-colors" title="Cambiar tema">
                    <span class="sr-only">Cambiar tema</span>
                    <!-- Sun icon (light mode) -->
                    <i class="fas fa-sun text-lg" id="theme-light-icon" hidden></i>
                    <!-- Moon icon (dark mode) -->
                    <i class="fas fa-moon text-lg" id="theme-dark-icon"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden sm:hidden bg-surface border-t border-border">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <a href="{{ route('inicio') }}" class="block rounded-md px-3 py-2 text-base font-medium transition-colors">
                Calculadora
            </a>
            <a href="{{ route('calculadora_diferida') }}" class="block rounded-md px-3 py-2 text-base font-medium transition-colors">
                Diferida
            </a>
            <!-- Added About link to mobile menu -->
            <a href="{{ route('about') }}" class="block rounded-md px-3 py-2 text-base font-medium transition-colors">
                Acerca de
            </a>
            <!-- Added Mobile Auth Links -->
            @auth
                <a href="{{ route('historial') }}" class="block rounded-md px-3 py-2 text-base font-medium transition-colors">
                    Historial
                </a>
                <div class="border-t border-border my-2 pt-2">
                    <div class="px-3 py-2 text-sm text-foreground-muted">Hola, {{ Auth::user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-red-500 hover:bg-surface-secondary">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-border my-2 pt-2">
                    <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 text-base font-medium transition-colors">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="block rounded-md px-3 py-2 text-base font-medium transition-colors text-primary">
                        Registrarse
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu elements
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuOpenIcon = document.getElementById('menu-open-icon');
        const menuCloseIcon = document.getElementById('menu-close-icon');
        
        // Mobile menu toggle
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                const isHidden = mobileMenu.classList.contains('hidden');
                
                if (isHidden) {
                    // Show mobile menu
                    mobileMenu.classList.remove('hidden');
                    menuOpenIcon?.classList.add('hidden');
                    menuCloseIcon?.classList.remove('hidden');
                } else {
                    // Hide mobile menu
                    mobileMenu.classList.add('hidden');
                    menuOpenIcon?.classList.remove('hidden');
                    menuCloseIcon?.classList.add('hidden');
                }
            });
        }
        
        // Close mobile menu when clicking on a navigation link
        const mobileLinks = mobileMenu?.querySelectorAll('a[href^="/"]');
        if (mobileLinks) {
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    menuOpenIcon?.classList.remove('hidden');
                    menuCloseIcon?.classList.add('hidden');
                });
            });
        }
        
        // Close mobile menu on window resize (responsive behavior)
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 640 && mobileMenu) { // 640px is 'sm' breakpoint
                mobileMenu.classList.add('hidden');
                menuOpenIcon?.classList.remove('hidden');
                menuCloseIcon?.classList.add('hidden');
            }
        });

        document.getElementById('theme-toggle')?.addEventListener('click', function() {
            if(!localStorage.getItem('theme')){
                localStorage.setItem('theme', 'light');
            }

            const htmlElement = document.documentElement;
            const isDarkMode = localStorage.getItem('theme') === 'dark';
            const themeLightIcon = document.getElementById('theme-light-icon');
            const themeDarkIcon = document.getElementById('theme-dark-icon');

            if (isDarkMode) {
                htmlElement.classList.remove('dark');
                themeLightIcon?.removeAttribute('hidden');
                themeDarkIcon?.setAttribute('hidden','');
                localStorage.setItem('theme', 'light');
            } else {
                htmlElement.classList.add('dark');
                themeLightIcon?.setAttribute('hidden','');
                themeDarkIcon?.removeAttribute('hidden');
                localStorage.setItem('theme', 'dark');
            }
        });
    });
</script>