@props(['tipo' => 'primary', 'titulo' => 'Titulo', 'accionTexto' => ''])

<div class="bg-{{ $tipo }}-light border border-border rounded-lg p-4 hover:shadow-md transition-all">
    <div class="flex items-center mb-2">
        <div class="w-3 h-3 bg-{{ $tipo }} rounded-full mr-2"></div>
        <h3 class="text-{{ $tipo }} font-bold">{{ $titulo }}</h3>
    </div>
    {{ $slot }}
    @if ($accionTexto)
        <button class="mt-3 bg-{{ $tipo }} hover:bg-{{ $tipo }}-hover text-white px-3 py-1 rounded text-sm transition-colors">
            {{ $accionTexto }}
        </button>
    @endif
</div>