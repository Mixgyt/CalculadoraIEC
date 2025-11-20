@extends('layout')

@section('title', 'Historial de Cálculos')

@section('content')
<div class="py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-foreground">Historial de Cálculos</h1>
        <a href="{{ route('inicio') }}" class="text-sm text-primary hover:underline">Volver a la calculadora</a>
    </div>

    @if($history->isEmpty())
        <div class="bg-surface rounded-lg shadow p-8 text-center border border-border">
            <div class="text-foreground-muted mb-4">
                <i class="fas fa-history text-4xl"></i>
            </div>
            <h3 class="text-lg font-medium text-foreground">No hay historial disponible</h3>
            <p class="text-foreground-muted mt-2">Realiza tu primer cálculo para verlo aquí.</p>
            <a href="{{ route('inicio') }}" class="mt-4 inline-block bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90">
                Ir a Calcular
            </a>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($history as $item)
                <div class="bg-surface rounded-lg shadow border border-border overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-4 border-b border-border bg-surface-secondary/50 flex justify-between items-center">
                        <span class="font-semibold text-foreground capitalize">
                            {{ str_replace('_', ' ', $item->type) }}
                        </span>
                        <span class="text-xs text-foreground-muted">
                            {{ $item->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    <div class="p-4">
                        <div class="mb-3">
                            <span class="text-xs font-bold text-primary uppercase tracking-wider">
                                {{ ucfirst($item->calculation_type) }}
                            </span>
                        </div>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-foreground-muted">Resultado:</span>
                                <span class="font-bold text-foreground">
                                    @if(isset($item->result_data['renta']))
                                        ${{ number_format($item->result_data['renta'], 2) }}
                                    @elseif(isset($item->result_data['valor_calculado']))
                                        ${{ number_format($item->result_data['valor_calculado'], 2) }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            
                            <div class="border-t border-border my-2 pt-2">
                                <p class="text-xs font-semibold text-foreground-muted mb-1">Datos de entrada:</p>
                                @if($item->type == 'anualidad_anticipada')
                                    @if(isset($item->input_data['valor_presente']))
                                        <div class="flex justify-between text-xs">
                                            <span class="text-foreground-muted">Capital:</span>
                                            <span>${{ number_format($item->input_data['valor_presente'], 2) }}</span>
                                        </div>
                                    @endif
                                    @if(isset($item->input_data['monto']))
                                        <div class="flex justify-between text-xs">
                                            <span class="text-foreground-muted">Monto:</span>
                                            <span>${{ number_format($item->input_data['monto'], 2) }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between text-xs">
                                        <span class="text-foreground-muted">Tasa:</span>
                                        <span>{{ $item->input_data['tasa_interes'] }}% {{ $item->input_data['periodo_tasa'] }}</span>
                                    </div>
                                @elseif($item->type == 'anualidad_diferida')
                                    <div class="flex justify-between text-xs">
                                        <span class="text-foreground-muted">Capital:</span>
                                        <span>${{ number_format($item->input_data['capital'], 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-foreground-muted">Diferimiento:</span>
                                        <span>{{ $item->input_data['periodos_diferimiento'] }} periodos</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
