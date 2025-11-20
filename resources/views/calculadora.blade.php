@extends("layout")
@section("title", "Calculadora Anualidades Anticipadas")

@section("content")
    <div class="bg-background min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="container max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12 px-4">
                <h1 class="text-4xl font-bold text-foreground mb-6">Calculadora de Anualidades Anticipadas</h1>
                <p class="text-foreground-muted text-lg max-w-3xl mx-auto">Calcula Renta, Capital, Monto o Períodos con conversión automática de tasas</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Formulario -->
                <div class="bg-surface border border-border rounded-lg shadow-sm">
                    <div class="px-6 lg:px-8 py-6 border-b border-border">
                        <h2 class="text-xl font-bold text-foreground">Parámetros de Cálculo</h2>
                        <p class="text-sm text-foreground-muted mt-1">Completa los datos necesarios</p>
                    </div>
                    
                    <div class="px-6 lg:px-8 py-6">
                        <form method="POST" action="{{ route('inicio') }}" id="calculadora-form" class="space-y-6">
                            @csrf
                            
                            <!-- Tipo de Cálculo -->

                            <div>
                                <label for="tipo_calculo" class="block text-sm font-medium text-foreground mb-2">
                                    ¿Qué deseas calcular? <span class="text-danger">*</span>
                                </label>
                                <div class="flex flex-wrap gap-1">
                                    <button onclick="seleccionarTipoCalculo('tiporenta')" type="button" id="tiporenta" class="flex items-center gap-2 px-3 py-3 rounded-lg transition-all duration-300 ease-in-out border-2 border-border hover:border-primary hover:scale-105 transform">
                                        <span class="text-xl"><i class="fa fa-coins"></i></span><span class="font-medium text-sm lg:text-md xl:text-sm">Renta</span>
                                    </button>
                                    <button onclick="seleccionarTipoCalculo('tipovalor_presente')" type="button" id="tipovalor_presente" class="flex items-center gap-2 px-3 py-3 rounded-lg transition-all duration-300 ease-in-out border-2 border-border hover:border-primary hover:scale-105 transform">
                                        <span class="text-xl"><i class="fa fa-money-bill"></i></span><span class="font-medium text-sm lg:text-md xl:text-sm">Capital</span>
                                    </button>
                                    <button onclick="seleccionarTipoCalculo('tipomonto')" type="button" id="tipomonto" class="flex items-center gap-2 px-3 py-3 rounded-lg transition-all duration-300 ease-in-out border-2 border-border hover:border-primary hover:scale-105 transform">
                                        <span class="text-xl"><i class="fa fa-money-bill-trend-up"></i></span><span class="font-medium text-sm lg:text-md xl:text-sm">Monto</span>
                                    </button>
                                    <button onclick="seleccionarTipoCalculo('tipoperiodos')" type="button" id="tipoperiodos" class="flex items-center gap-2 px-3 py-3 rounded-lg transition-all duration-300 ease-in-out border-2 border-border hover:border-primary hover:scale-105 transform">
                                        <span class="text-xl"><i class="fa fa-calendar"></i></span><span class="font-medium text-sm lg:text-md xl:text-sm">Periodo</span>
                                    </button>
                                </div>
                            </div>
                            <div class="hidden">
                                <label for="tipo_calculo" class="block text-sm font-medium text-foreground mb-2">
                                    ¿Qué deseas calcular? <span class="text-danger">*</span>
                                </label>
                                <select id="tipo_calculo" 
                                        name="tipo_calculo" 
                                        class="w-full px-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                        required>
                                    <option value="">Seleccionar...</option>
                                    <option value="renta" {{ old('tipo_calculo', $prefillData['tipo_calculo'] ?? '') == 'renta' ? 'selected' : '' }}>Renta (R) - Pago periódico</option>
                                    <option value="valor_presente" {{ old('tipo_calculo', $prefillData['tipo_calculo'] ?? '') == 'valor_presente' ? 'selected' : '' }}>Capital (C) - Valor presente</option>
                                    <option value="monto" {{ old('tipo_calculo', $prefillData['tipo_calculo'] ?? '') == 'monto' ? 'selected' : '' }}>Monto (M) - Valor futuro</option>
                                    <option value="periodos" {{ old('tipo_calculo', $prefillData['tipo_calculo'] ?? '') == 'periodos' ? 'selected' : '' }}>Períodos (n) - Número de pagos</option>
                                </select>
                            </div>

                            <!-- Capital (C) -->
                            <div id="campo_capital" style="display: none;">
                                <label for="valor_presente" class="block text-sm font-medium text-foreground mb-2">
                                    Capital (C) <span class="text-danger">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-foreground-muted">$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           id="valor_presente" 
                                           name="valor_presente" 
                                           class="w-full pl-8 pr-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                           placeholder="100000.00"
                                           value="{{ old('valor_presente', $prefillData['valor_presente'] ?? '') }}">
                                </div>
                                <p class="text-xs text-foreground-muted mt-1">Valor presente o inicial</p>
                            </div>

                            <!-- Renta (R) -->
                            <div id="campo_renta" style="display: none;">
                                <label for="renta" class="block text-sm font-medium text-foreground mb-2">
                                    Renta (R) <span class="text-danger">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-foreground-muted">$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           id="renta" 
                                           name="renta" 
                                           class="w-full pl-8 pr-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                           placeholder="5000.00"
                                           value="{{ old('renta', $prefillData['renta'] ?? '') }}">
                                </div>
                                <p class="text-xs text-foreground-muted mt-1">Pago o depósito periódico</p>
                            </div>

                            <!-- Monto (M) -->
                            <div id="campo_monto" style="display: none;">
                                <label for="monto" class="block text-sm font-medium text-foreground mb-2">
                                    Monto (M) <span class="text-danger">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-foreground-muted">$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           id="monto" 
                                           name="monto" 
                                           class="w-full pl-8 pr-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                           placeholder="150000.00"
                                           value="{{ old('monto', $prefillData['monto'] ?? '') }}">
                                </div>
                                <p class="text-xs text-foreground-muted mt-1">Valor futuro o final</p>
                            </div>

                            <!-- Número de Períodos (n) -->
                            <div id="campo_periodos" style="display: none;">
                                <label for="numero_periodos" class="block text-sm font-medium text-foreground mb-2">
                                    Número de Períodos (n) <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       id="numero_periodos" 
                                       name="numero_periodos" 
                                       min="1"
                                       class="w-full px-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                       placeholder="24"
                                       value="{{ old('numero_periodos', $prefillData['numero_periodos'] ?? '') }}">
                                <p class="text-xs text-foreground-muted mt-1">Cantidad de pagos o depósitos</p>
                            </div>

                            <!-- Tasa de Interés -->
                            <div>
                                <label for="tasa_interes" class="block text-sm font-medium text-foreground mb-2">
                                    Tasa de Interés (%) <span class="text-danger">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           step="0.001" 
                                           id="tasa_interes" 
                                           name="tasa_interes" 
                                           class="w-full px-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                           placeholder="12.00"
                                           value="{{ old('tasa_interes', $prefillData['tasa_interes'] ?? '') }}"
                                           required>
                                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-foreground-muted">%</span>
                                </div>
                                <p class="text-xs text-foreground-muted mt-1">Tasa de interés</p>
                            </div>

                            <!-- Período de la Tasa -->
                            <div>
                                <label for="periodo_tasa" class="block text-sm font-medium text-foreground mb-2">
                                    Período de la Tasa <span class="text-danger">*</span>
                                </label>
                                <select id="periodo_tasa" 
                                        name="periodo_tasa" 
                                        class="w-full px-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                        required>
                                    <option value="">Seleccionar...</option>
                                    <option value="anual" {{ old('periodo_tasa', $prefillData['periodo_tasa'] ?? '') == 'anual' ? 'selected' : '' }}>Anual</option>
                                    <option value="semestral" {{ old('periodo_tasa', $prefillData['periodo_tasa'] ?? '') == 'semestral' ? 'selected' : '' }}>Semestral</option>
                                    <option value="trimestral" {{ old('periodo_tasa', $prefillData['periodo_tasa'] ?? '') == 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                                    <option value="bimestral" {{ old('periodo_tasa', $prefillData['periodo_tasa'] ?? '') == 'bimestral' ? 'selected' : '' }}>Bimestral</option>
                                    <option value="mensual" {{ old('periodo_tasa', $prefillData['periodo_tasa'] ?? '') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                                </select>
                                <p class="text-xs text-foreground-muted mt-1">A qué período corresponde la tasa</p>
                            </div>

                            <!-- Período de Capitalización -->
                            <div>
                                <label for="periodo_capitalizacion" class="block text-sm font-medium text-foreground mb-2">
                                    Período de Capitalización
                                </label>
                                <select id="periodo_capitalizacion" 
                                        name="periodo_capitalizacion" 
                                        class="w-full px-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground">
                                    <option value="">Igual al período de la tasa</option>
                                    <option value="anual" {{ old('periodo_capitalizacion', $prefillData['periodo_capitalizacion'] ?? '') == 'anual' ? 'selected' : '' }}>Anual</option>
                                    <option value="semestral" {{ old('periodo_capitalizacion', $prefillData['periodo_capitalizacion'] ?? '') == 'semestral' ? 'selected' : '' }}>Semestral</option>
                                    <option value="trimestral" {{ old('periodo_capitalizacion', $prefillData['periodo_capitalizacion'] ?? '') == 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                                    <option value="bimestral" {{ old('periodo_capitalizacion', $prefillData['periodo_capitalizacion'] ?? '') == 'bimestral' ? 'selected' : '' }}>Bimestral</option>
                                    <option value="mensual" {{ old('periodo_capitalizacion', $prefillData['periodo_capitalizacion'] ?? '') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                                    <option value="diario" {{ old('periodo_capitalizacion', $prefillData['periodo_capitalizacion'] ?? '') == 'diario' ? 'selected' : '' }}>Diario</option>
                                    <option value="continuo" {{ old('periodo_capitalizacion', $prefillData['periodo_capitalizacion'] ?? '') == 'continuo' ? 'selected' : '' }}>Continuo</option>
                                </select>
                                <p class="text-xs text-foreground-muted mt-1">Frecuencia de capitalización del interés (opcional)</p>
                            </div>

                            <!-- Frecuencia de Pagos -->
                            <div>
                                <label for="periodo_pagos" class="block text-sm font-medium text-foreground mb-2">
                                    Frecuencia de Pagos <span class="text-danger">*</span>
                                </label>
                                <select id="periodo_pagos" 
                                        name="periodo_pagos" 
                                        class="w-full px-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                        required>
                                    <option value="">Seleccionar...</option>
                                    <option value="anual" {{ old('periodo_pagos', $prefillData['periodo_pagos'] ?? '') == 'anual' ? 'selected' : '' }}>Anual</option>
                                    <option value="semestral" {{ old('periodo_pagos', $prefillData['periodo_pagos'] ?? '') == 'semestral' ? 'selected' : '' }}>Semestral</option>
                                    <option value="trimestral" {{ old('periodo_pagos', $prefillData['periodo_pagos'] ?? '') == 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                                    <option value="bimestral" {{ old('periodo_pagos', $prefillData['periodo_pagos'] ?? '') == 'bimestral' ? 'selected' : '' }}>Bimestral</option>
                                    <option value="mensual" {{ old('periodo_pagos', $prefillData['periodo_pagos'] ?? '') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                                </select>
                                <p class="text-xs text-foreground-muted mt-1">Cada cuándo se paga/deposita</p>
                            </div>

                            <!-- Mensaje de ayuda dinámico -->
                            <div id="mensaje_ayuda" class="bg-primary/10 border border-primary/20 rounded-md p-4" style="display: none;">
                                <p class="text-sm text-foreground-muted" id="texto_ayuda"></p>
                            </div>

                            <!-- Botones -->
                            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                <button type="submit" 
                                        class="bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-md font-medium transition-colors shadow-sm flex-1">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    Calcular
                                </button>
                                <button type="button" 
                                        onclick="limpiarFormulario()"
                                        class="bg-surface border border-border hover:bg-surface-secondary text-foreground px-6 py-3 rounded-md font-medium transition-colors">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Limpiar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Resultados -->
                <div class="space-y-6">
                    @if(isset($resultado))
                        <!-- Resultado Principal -->
                        <div class="bg-success-light border border-success/20 rounded-lg shadow-md">
                            <div class="px-6 py-3 lg:px-8 lg:py:2">
                                <div class="flex items-center mb-4">
                                    <svg class="w-6 h-6 text-success mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-xl font-bold text-success">{{ $resultado['nombre_calculado'] }}</h3>
                                </div>
                                
                                <div class="bg-surface p-6 rounded-lg border border-success/20 mb-4">
                                    <div class="text-center">
                                        <p class="text-sm text-foreground-muted mb-1">{{$resultado['descripcion']}}</p>
                                        <p class="text-5xl font-bold text-success mb-2">
                                            @if($resultado['tipo_calculo'] == 'periodos')
                                                {{ number_format($resultado['valor_calculado'], 0) }}
                                            @else
                                                ${{ number_format($resultado['valor_calculado'], 2) }}
                                            @endif
                                        </p>
                                        @if($resultado['tipo_calculo'] == 'periodos' && isset($resultado['periodos_exactos']))
                                            <p class="text-xs text-foreground-muted">
                                                ({{ number_format($resultado['periodos_exactos'], 2) }} períodos exactos)
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                


                            </div>
                        </div>


                        <!-- Fórmula Utilizada -->
                        @if(isset($resultado['tipo_formula']))
                        <div class="bg-surface border border-primary/20 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-primary/20 bg-primary/5">
                                <h3 class="text-lg font-bold text-primary">Fórmula Utilizada</h3>
                            </div>
                            <div class="px-6 py-4">
                                @if($resultado['tipo_formula'] == 'monto')
                                    <div class="bg-surface p-4 rounded-lg border border-primary/20 mb-3">
                                        <p class="text-center text-base text-foreground mb-3">
                                            <strong>Monto (M):</strong>
                                        </p>
                                        <div class="text-center text-foreground text-lg">
                                            $$M = R \times \left[\frac{(1+i)^n - 1}{i}\right] \times (1+i)$$
                                        </div>
                                    </div>
                                    <div class="text-sm text-foreground space-y-2 bg-primary/5 p-3 rounded mb-3">
                                        <p class="font-semibold text-primary mb-2">Datos del cálculo:</p>
                                        <p><strong>R (Renta periódica):</strong> ${{ number_format($resultado['renta'], 2) }}</p>
                                        <p><strong>i (Tasa efectiva {{ $resultado['periodo_pagos'] }}):</strong> {{ number_format($resultado['tasa_convertida'] * 100, 4) }}%</p>
                                        <p><strong>n (Número de períodos):</strong> {{ $resultado['numero_periodos'] }}</p>
                                        <p class="pt-2 border-t border-primary/20"><strong>M:</strong> Monto o valor futuro</p>
                                    </div>
                                    <div class="bg-surface p-4 rounded-lg border border-success/20">
                                        <p class="text-center text-sm text-foreground-muted mb-2">Sustituyendo valores:</p>
                                        @php
                                            $r_val = $resultado['renta'];
                                            $i_val = $resultado['tasa_convertida'];
                                            $n_val = $resultado['numero_periodos'];
                                        @endphp
                                        <div class="text-center text-foreground">
                                            $$M = {{ $r_val }} \times \left[\frac{(1+{{ $i_val }})^{ {{ $n_val }} } - 1}{ {{ $i_val }} }\right] \times (1+{{ $i_val }})$$
                                        </div>
                                    </div>
                                
                                @elseif($resultado['tipo_formula'] == 'capital')
                                    <div class="bg-surface p-4 rounded-lg border border-primary/20 mb-3">
                                        <p class="text-center text-base text-foreground mb-3">
                                            <strong>Capital (C):</strong>
                                        </p>
                                        <div class="text-center text-foreground text-lg">
                                            $$C = R \times \left[\frac{1 - (1+i)^{-n}}{i}\right] \times (1+i)$$
                                        </div>
                                    </div>
                                    <div class="text-sm text-foreground space-y-2 bg-primary/5 p-3 rounded mb-3">
                                        <p class="font-semibold text-primary mb-2">Datos del cálculo:</p>
                                        <p><strong>R (Renta periódica):</strong> ${{ number_format($resultado['renta'], 2) }}</p>
                                        <p><strong>i (Tasa efectiva {{ $resultado['periodo_pagos'] }}):</strong> {{ number_format($resultado['tasa_convertida'] * 100, 4) }}%</p>
                                        <p><strong>n (Número de períodos):</strong> {{ $resultado['numero_periodos'] }}</p>
                                        <p class="pt-2 border-t border-primary/20"><strong>C:</strong> Capital o valor presente</p>
                                    </div>
                                    <div class="bg-surface p-4 rounded-lg border border-success/20">
                                        <p class="text-center text-sm text-foreground-muted mb-2">Sustituyendo valores:</p>
                                        @php
                                            $r_val = $resultado['renta'];
                                            $i_val = $resultado['tasa_convertida'];
                                            $n_val = $resultado['numero_periodos'];
                                        @endphp
                                        <div class="text-center text-foreground">
                                            $$C = {{ $r_val }} \times \left[\frac{1 - (1+{{ $i_val }})^{-{{ $n_val }}}}{{{ $i_val }}}\right] \times (1+{{ $i_val }})$$
                                        </div>
                                    </div>
                                
                                @elseif($resultado['tipo_formula'] == 'renta_desde_monto')
                                    <div class="bg-surface p-4 rounded-lg border border-primary/20 mb-3">
                                        <p class="text-center text-base text-foreground mb-3">
                                            <strong>Pago R a partir de M:</strong>
                                        </p>
                                        <div class="text-center text-foreground text-lg">
                                            $$R = \frac{M}{\left[\frac{(1+i)^n - 1}{i}\right] \times (1+i)}$$
                                        </div>
                                    </div>
                                    <div class="text-sm text-foreground space-y-2 bg-primary/5 p-3 rounded mb-3">
                                        <p class="font-semibold text-primary mb-2">Datos del cálculo:</p>
                                        <p><strong>M (Monto futuro deseado):</strong> ${{ number_format($resultado['monto'], 2) }}</p>
                                        <p><strong>i (Tasa efectiva {{ $resultado['periodo_pagos'] }}):</strong> {{ number_format($resultado['tasa_convertida'] * 100, 4) }}%</p>
                                        <p><strong>n (Número de períodos):</strong> {{ $resultado['numero_periodos'] }}</p>
                                        <p class="pt-2 border-t border-primary/20"><strong>R:</strong> Renta o pago periódico</p>
                                    </div>
                                    <div class="bg-surface p-4 rounded-lg border border-success/20">
                                        <p class="text-center text-sm text-foreground-muted mb-2">Sustituyendo valores:</p>
                                        @php
                                            $m_val = $resultado['monto'];
                                            $i_val = $resultado['tasa_convertida'];
                                            $n_val = $resultado['numero_periodos'];
                                        @endphp
                                        <div class="text-center text-foreground">
                                            $$R = \frac{ {{ $m_val }} }{\left[\frac{(1+{{ $i_val }})^{ {{ $n_val }} } - 1}{ {{ $i_val }} }\right] \times (1+{{ $i_val }})}$$
                                        </div>
                                    </div>
                                
                                @elseif($resultado['tipo_formula'] == 'renta_desde_capital')
                                    <div class="bg-surface p-4 rounded-lg border border-primary/20 mb-3">
                                        <p class="text-center text-base text-foreground mb-3">
                                            <strong>Pago R a partir de C:</strong>
                                        </p>
                                        <div class="text-center text-foreground text-lg">
                                            $$R = \frac{C}{\left[\frac{1 - (1+i)^{-n}}{i}\right] \times (1+i)}$$
                                        </div>
                                    </div>
                                    <div class="text-sm text-foreground space-y-2 bg-primary/5 p-3 rounded mb-3">
                                        <p class="font-semibold text-primary mb-2">Datos del cálculo:</p>
                                        <p><strong>C (Capital presente):</strong> ${{ number_format($resultado['valor_presente'], 2) }}</p>
                                        <p><strong>i (Tasa efectiva {{ $resultado['periodo_pagos'] }}):</strong> {{ number_format($resultado['tasa_convertida'] * 100, 4) }}%</p>
                                        <p><strong>n (Número de períodos):</strong> {{ $resultado['numero_periodos'] }}</p>
                                        <p class="pt-2 border-t border-primary/20"><strong>R:</strong> Renta o pago periódico</p>
                                    </div>
                                    <div class="bg-surface p-4 rounded-lg border border-success/20">
                                        <p class="text-center text-sm text-foreground-muted mb-2">Sustituyendo valores:</p>
                                        @php
                                            $c_val = $resultado['valor_presente'];
                                            $i_val = $resultado['tasa_convertida'];
                                            $n_val = $resultado['numero_periodos'];
                                        @endphp
                                        <div class="text-center text-foreground">
                                            $$R = \frac{ {{ $c_val }} }{\left[\frac{1 - (1+{{ $i_val }})^{-{{ $n_val }}}}{{{ $i_val }}}\right] \times (1+{{ $i_val }})}$$
                                        </div>
                                    </div>
                                
                                @elseif($resultado['tipo_formula'] == 'periodos_desde_monto')
                                    <div class="bg-surface p-4 rounded-lg border border-primary/20 mb-3">
                                        <p class="text-center text-base text-foreground mb-3">
                                            <strong>Períodos (n) a partir de Monto (M):</strong>
                                        </p>
                                        <div class="text-center text-foreground text-lg">
                                            $$n = \frac{\ln\left(\frac{M \cdot i}{R(1+i)} + 1\right)}{\ln(1+i)}$$
                                        </div>
                                    </div>
                                    <div class="text-sm text-foreground space-y-2 bg-primary/5 p-3 rounded mb-3">
                                        <p class="font-semibold text-primary mb-2">Datos del cálculo:</p>
                                        <p><strong>M (Monto futuro deseado):</strong> ${{ number_format($resultado['monto'], 2) }}</p>
                                        <p><strong>R (Renta periódica):</strong> ${{ number_format($resultado['renta'], 2) }}</p>
                                        <p><strong>i (Tasa efectiva {{ $resultado['periodo_pagos'] }}):</strong> {{ number_format($resultado['tasa_convertida'] * 100, 4) }}%</p>
                                        <p class="pt-2 border-t border-primary/20"><strong>n:</strong> Número de períodos</p>
                                    </div>
                                    <div class="bg-surface p-4 rounded-lg border border-success/20">
                                        <p class="text-center text-sm text-foreground-muted mb-2">Sustituyendo valores:</p>
                                        @php
                                            $m_val = $resultado['monto'];
                                            $r_val = $resultado['renta'];
                                            $i_val = $resultado['tasa_convertida'];
                                        @endphp
                                        <div class="text-center text-foreground">
                                            $$n = \frac{\ln\left(\frac{ {{ $m_val }} \cdot {{ $i_val }} }{ {{ $r_val }} (1+{{ $i_val }})} + 1\right)}{\ln(1+{{ $i_val }})}$$
                                        </div>
                                    </div>
                                
                                @elseif($resultado['tipo_formula'] == 'periodos_desde_capital')
                                    <div class="bg-surface p-4 rounded-lg border border-primary/20 mb-3">
                                        <p class="text-center text-base text-foreground mb-3">
                                            <strong>Períodos (n) a partir de Capital (C):</strong>
                                        </p>
                                        <div class="text-center text-foreground text-lg">
                                            $$n = -\frac{\ln\left(1 - \frac{C \cdot i}{R(1+i)}\right)}{\ln(1+i)}$$
                                        </div>
                                    </div>
                                    <div class="text-sm text-foreground space-y-2 bg-primary/5 p-3 rounded mb-3">
                                        <p class="font-semibold text-primary mb-2">Datos del cálculo:</p>
                                        <p><strong>C (Capital presente):</strong> ${{ number_format($resultado['valor_presente'], 2) }}</p>
                                        <p><strong>R (Renta periódica):</strong> ${{ number_format($resultado['renta'], 2) }}</p>
                                        <p><strong>i (Tasa efectiva {{ $resultado['periodo_pagos'] }}):</strong> {{ number_format($resultado['tasa_convertida'] * 100, 4) }}%</p>
                                        <p class="pt-2 border-t border-primary/20"><strong>n:</strong> Número de períodos</p>
                                    </div>
                                    <div class="bg-surface p-4 rounded-lg border border-success/20">
                                        <p class="text-center text-sm text-foreground-muted mb-2">Sustituyendo valores:</p>
                                        @php
                                            $c_val = $resultado['valor_presente'];
                                            $r_val = $resultado['renta'];
                                            $i_val = $resultado['tasa_convertida'];
                                        @endphp
                                        <div class="text-center text-foreground">
                                            $$n = -\frac{\ln\left(1 - \frac{ {{ $c_val }} \cdot {{ $i_val }} }{ {{ $r_val }} (1+{{ $i_val }})}\right)}{\ln(1+{{ $i_val }})}$$
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Conversión de Tasas -->
                        <div class="bg-surface border border-border rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-border">
                                <h3 class="text-lg font-bold text-foreground">Conversión de Tasas</h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between py-2 border-b border-border/30">
                                        <span class="text-foreground-muted">Tasa Original:</span>
                                        <span class="font-medium text-foreground">{{ number_format($resultado['tasa_original'], 2) }}% {{ ucfirst($resultado['periodo_tasa']) }}</span>
                                    </div>
                                    @if(isset($resultado['periodo_capitalizacion']) && $resultado['periodo_capitalizacion'])
                                        <div class="flex justify-between py-2 border-b border-border/30">
                                            <span class="text-foreground-muted">Capitalización:</span>
                                            <span class="font-medium text-foreground">{{ ucfirst($resultado['periodo_capitalizacion']) }}</span>
                                        </div>
                                        @if(isset($resultado['tasa_nominal_anual_porcentaje']))
                                            <div class="flex justify-between py-2 border-b border-border/30">
                                                <span class="text-foreground-muted">Tasa Nominal Anual:</span>
                                                <span class="font-medium text-foreground">{{ number_format($resultado['tasa_nominal_anual_porcentaje'], 2) }}%</span>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="flex justify-between py-2 border-b border-border/30">
                                        <span class="text-foreground-muted">Tasa Efectiva Anual:</span>
                                        <span class="font-medium text-foreground">{{ number_format($resultado['tasa_efectiva_anual_porcentaje'], 2) }}%</span>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <span class="text-foreground-muted">Tasa {{ ucfirst($resultado['periodo_pagos']) }}:</span>
                                        <span class="font-semibold text-primary">{{ number_format($resultado['tasa_convertida_porcentaje'], 2) }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- Info Inicial -->
                        <div class="bg-surface border border-border rounded-lg shadow-sm">
                            <div class="p-12 text-center">
                                <svg class="w-16 h-16 text-foreground-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-foreground mb-2">Anualidades Anticipadas</h3>
                                <p class="text-foreground-muted max-w-sm mx-auto">
                                    Selecciona qué valor deseas calcular y completa los campos requeridos
                                </p>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-danger-light border border-danger/20 rounded-lg shadow-sm">
                            <div class="p-6">
                                <div class="flex items-center mb-3">
                                    <svg class="w-5 h-5 text-danger mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <h3 class="text-lg font-bold text-danger">Error</h3>
                                </div>
                                <ul class="space-y-1 text-sm">
                                    @foreach($errors->all() as $error)
                                        <li class="text-foreground">• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @php(
        // Definir el tipo de cálculo predeterminado
        $tipoCalculoPredeterminado = old('tipo_calculo', $prefillData['tipo_calculo'] ?? 'renta')
    )
    <script>
        // Variable para el tipo de cálculo del servidor
        const tipoCalculoServidor = "{{ $tipoCalculoPredeterminado ?? 'renta' }}";
        
        const mensajesAyuda = {
            'renta': {
                campos: ['capital', 'monto', 'periodos'],
                mensaje: 'Necesitas: (Capital (C) O Monto (M)) y Número de períodos (n)'
            },
            'valor_presente': {
                campos: ['renta', 'periodos'],
                mensaje: 'Necesitas: Renta (R) y Número de períodos (n)'
            },
            'monto': {
                campos: ['renta', 'periodos'],
                mensaje: 'Necesitas: Renta (R) y Número de períodos (n)'
            },
            'periodos': {
                campos: ['capital', 'renta', 'monto'],
                mensaje: 'Necesitas: (Capital (C) O Monto (M)) y Renta (R)'
            }
        };

        let tipoSeleccionado = 'renta';

        function mostrarCamposSegunTipo() {
            const tipo = document.getElementById('tipo_calculo').value;
            
            // Ocultar todos los campos
            document.getElementById('campo_capital').style.display = 'none';
            document.getElementById('campo_renta').style.display = 'none';
            document.getElementById('campo_monto').style.display = 'none';
            document.getElementById('campo_periodos').style.display = 'none';
            document.getElementById('mensaje_ayuda').style.display = 'none';
            
            // Limpiar required
            document.getElementById('valor_presente').removeAttribute('required');
            document.getElementById('renta').removeAttribute('required');
            document.getElementById('monto').removeAttribute('required');
            document.getElementById('numero_periodos').removeAttribute('required');
            
            if (tipo && mensajesAyuda[tipo]) {
                const config = mensajesAyuda[tipo];
                
                // Mostrar campos necesarios
                config.campos.forEach(campo => {
                    const elemento = document.getElementById(`campo_${campo}`);
                    if (elemento) {
                        elemento.style.display = 'block';
                    }
                });
                
                // Configurar required según el tipo
                if (tipo === 'renta') {
                    document.getElementById('numero_periodos').setAttribute('required', 'required');
                    // Para renta, C o M es opcional (al menos uno)
                } else if (tipo === 'valor_presente' || tipo === 'monto') {
                    document.getElementById('renta').setAttribute('required', 'required');
                    document.getElementById('numero_periodos').setAttribute('required', 'required');
                } else if (tipo === 'periodos') {
                    document.getElementById('renta').setAttribute('required', 'required');
                    // Para períodos, C o M es opcional (al menos uno)
                }
                
                // Mostrar mensaje de ayuda
                document.getElementById('texto_ayuda').textContent = config.mensaje;
                document.getElementById('mensaje_ayuda').style.display = 'block';
            }
        }

        function limpiarFormulario() {
            document.getElementById('calculadora-form').reset();
            mostrarCamposSegunTipo();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const tipoCalculo = document.getElementById('tipo_calculo');
            tipoCalculo.addEventListener('change', mostrarCamposSegunTipo);
            
            // Validar números negativos
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value < 0) this.value = '';
                });
            });
            
            tipoSeleccionado = tipoCalculo.value || 'renta';
            seleccionarTipoCalculo('tipo'+tipoSeleccionado);
            mostrarCamposSegunTipo();
        });

        function seleccionarTipoCalculo(id){
            // Remover clase de todos los botones
            const buttonAnterior = document.getElementById('tipo'+tipoSeleccionado);
            buttonAnterior.classList.remove('bg-primary','text-white');
            //buttonAnterior.classList.add('border-border');

            const button = document.getElementById(id);
            //button.classList.remove('border-border');
            button.classList.add('bg-primary','text-white');
            tipoSeleccionado = id.replace('tipo','');
            document.getElementById('tipo_calculo').value = tipoSeleccionado;
            mostrarCamposSegunTipo();
        }

        // Seleccionar el tipo de cálculo basado en el valor enviado desde el servidor
        if (tipoCalculoServidor) {
            seleccionarTipoCalculo('tipo' + tipoCalculoServidor);
        }
    </script>
@endsection