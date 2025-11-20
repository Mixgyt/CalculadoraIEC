@extends('layout')

@section('title', 'Acerca de Nosotros')

@section('content')
<div class="bg-background min-h-screen">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-surface py-16 sm:py-24">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')] bg-cover bg-center opacity-5"></div>
        <div class="relative mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-foreground sm:text-6xl mb-6">
                Calculadora de <span class="text-primary">Anualidades</span>
            </h1>
            <p class="mt-6 text-lg leading-8 text-foreground-muted max-w-2xl mx-auto">
                Una herramienta poderosa diseñada para simplificar cálculos financieros complejos. 
                Especializada en anualidades anticipadas y diferidas, ayudando a estudiantes y profesionales 
                a tomar decisiones financieras informadas con precisión y rapidez.
            </p>
        </div>
    </div>

    <!-- Team Section -->
    <div class="py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl">Nuestro Equipo</h2>
                <p class="mt-4 text-lg leading-8 text-foreground-muted">
                    Conoce a las mentes brillantes detrás de este proyecto. Estudiantes apasionados por el desarrollo y las finanzas.
                </p>
            </div>
            
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                <!-- Team Member 1 -->
                <div class="group relative bg-surface rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-border">
                    <div class="aspect-square overflow-hidden rounded-xl bg-surface-secondary mb-4">
                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-github="JuanSPcode" alt="Juan Antonio Sandoval Paiz" loading="lazy" class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <h3 class="text-lg font-semibold leading-8 tracking-tight text-foreground">Juan Antonio Sandoval Paiz</h3>
                    <p class="text-sm font-medium text-primary mb-4">sp23002</p>
                    <a href="https://github.com/JuanSPcode" target="_blank" class="inline-flex items-center text-sm font-medium text-foreground-muted hover:text-primary transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                        GitHub Profile
                    </a>
                </div>

                <!-- Team Member 2 -->
                <div class="group relative bg-surface rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-border">
                    <div class="aspect-square overflow-hidden rounded-xl bg-surface-secondary mb-4">
                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-github="Mixgyt" alt="César Enoc Aparicio Reyes" loading="lazy" class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <h3 class="text-lg font-semibold leading-8 tracking-tight text-foreground">César Enoc Aparicio Reyes</h3>
                    <p class="text-sm font-medium text-primary mb-4">aa23026</p>
                    <a href="https://github.com/Mixgyt" target="_blank" class="inline-flex items-center text-sm font-medium text-foreground-muted hover:text-primary transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                        GitHub Profile
                    </a>
                </div>

                <!-- Team Member 3 -->
                <div class="group relative bg-surface rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-border">
                    <div class="aspect-square overflow-hidden rounded-xl bg-surface-secondary mb-4">
                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-github="CesarG503" alt="César Alexander Garay Ortez" loading="lazy" class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <h3 class="text-lg font-semibold leading-8 tracking-tight text-foreground">César Alexander Garay Ortez</h3>
                    <p class="text-sm font-medium text-primary mb-4">go22007</p>
                    <a href="https://github.com/CesarG503" target="_blank" class="inline-flex items-center text-sm font-medium text-foreground-muted hover:text-primary transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                        GitHub Profile
                    </a>
                </div>

                <!-- Team Member 4 -->
                <div class="group relative bg-surface rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-border">
                    <div class="aspect-square overflow-hidden rounded-xl bg-surface-secondary mb-4">
                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-github="Rebecamo" alt="Dayna Rebeca Moreno Santiago" loading="lazy" class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <h3 class="text-lg font-semibold leading-8 tracking-tight text-foreground">Dayna Rebeca Moreno Santiago</h3>
                    <p class="text-sm font-medium text-primary mb-4">ms21017</p>
                    <a href="https://github.com/Rebecamo" target="_blank" class="inline-flex items-center text-sm font-medium text-foreground-muted hover:text-primary transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                        GitHub Profile
                    </a>
                </div>

                <!-- Team Member 5 -->
                <div class="group relative bg-surface rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-border">
                    <div class="aspect-square overflow-hidden rounded-xl bg-surface-secondary mb-4">
                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-github="YANA021" alt="Yahir Ariel Nieto Amaya" loading="lazy" class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <h3 class="text-lg font-semibold leading-8 tracking-tight text-foreground">Yahir Ariel Nieto Amaya</h3>
                    <p class="text-sm font-medium text-primary mb-4">na21011</p>
                    <a href="https://github.com/YANA021" target="_blank" class="inline-flex items-center text-sm font-medium text-foreground-muted hover:text-primary transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                        GitHub Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imgs = document.querySelectorAll('img[data-github]');
            imgs.forEach(img => {
                const username = img.dataset.github;
                if (!username) return;
                // Try GitHub API first (returns avatar_url). If it fails, fallback to github.com/{username}.png
                fetch(`https://api.github.com/users/${username}`)
                    .then(res => {
                        if (res.ok) return res.json();
                        throw new Error('GitHub API error');
                    })
                    .then(data => {
                        if (data && data.avatar_url) {
                            // use avatar from API
                            img.src = data.avatar_url + (data.avatar_url.includes('?') ? '&' : '?') + 's=200';
                        } else {
                            img.src = `https://github.com/${username}.png`;
                        }
                    })
                    .catch(() => {
                        img.src = `https://github.com/${username}.png`;
                    });
            });
        });
    </script>

</div>
@endsection
