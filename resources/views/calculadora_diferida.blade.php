@extends("layout")
@section("title","Calculadora Anualidades Diferidas")

@section("content")
    <div class="bg-background min-h-screen py-8">
        <div class="container max-w-6xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-foreground mb-4">Calculadora de Anualidades Diferidas</h1>
                <p class="text-foreground-muted text-lg">Calcula anualidades diferidas con diferentes tipos de períodos y conversión de tasas</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Formulario de Cálculo -->
                <div class="bg-surface border border-border rounded-lg shadow-sm py-2">
                    <div class="px-6 py-4 border-b border-border">
                        <h2 class="text-xl font-bold text-foreground mb-2">Parámetros de Cálculo</h2>
                        <p class="text-sm font-medium text-foreground-muted mb-2">Ingresa los datos para calcular la anualidad diferida</p>
                    </div>
                    
                    <div class="px-6 py-4 mt-2">
                        <form method="POST" action="{{ route('resultado_calculadora_diferida') }}" id="calculadora-form" class="space-y-6">
                            @csrf
                            
                            <!-- Capital -->
                            <div>
                                <label for="capital" class="block text-sm font-medium text-foreground mb-2">
                                    Capital Inicial (C) <span class="text-danger">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-foreground-muted">$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           id="capital" 
                                           name="capital" 
                                           class="w-full pl-8 pr-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                           placeholder="10000.00"
                                           value="{{ old('capital', $prefillData['capital'] ?? '') }}"
                                           required>
                                </div>
                                <p class="text-xs text-foreground-muted mt-1">Monto inicial de la inversión</p>
                            </div>

                            <!-- Tasa de Interés -->
                            <div>
                                <label for="tasa_nominal" class="block text-sm font-medium text-foreground mb-2">
                                    Tasa de Interés Nominal Anual (%) <span class="text-danger">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           step="0.001" 
                                           id="tasa_nominal" 
                                           name="tasa_nominal" 
                                           class="w-full px-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                           placeholder="12.00"
                                           value="{{ old('tasa_nominal', $prefillData['tasa_nominal'] ?? '') }}"
                                           required>
                                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-foreground-muted">%</span>
                                </div>
                                <p class="text-xs text-foreground-muted mt-1">Tasa nominal anual (ej: 12% = 0.1200)</p>
                            </div>

                            <!-- Tipo de Capitalización -->
                            <div>
                                <label for="capitalizacion" class="block text-sm font-medium text-foreground mb-2">
                                    Capitalización de la Tasa <span class="text-danger">*</span>
                                </label>
                                <select id="capitalizacion" 
                                        name="capitalizacion" 
                                        class="w-full px-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                        required>
                                    <option value="">Seleccionar capitalización</option>
                                    <option value="anual" {{ old('capitalizacion', $prefillData['capitalizacion'] ?? '') == 'anual' ? 'selected' : '' }}>Anual (1 vez por año)</option>
                                    <option value="semestral" {{ old('capitalizacion', $prefillData['capitalizacion'] ?? '') == 'semestral' ? 'selected' : '' }}>Semestral (2 veces por año)</option>
                                    <option value="trimestral" {{ old('capitalizacion', $prefillData['capitalizacion'] ?? '') == 'trimestral' ? 'selected' : '' }}>Trimestral (4 veces por año)</option>
                                    <option value="mensual" {{ old('capitalizacion', $prefillData['capitalizacion'] ?? '') == 'mensual' ? 'selected' : '' }}>Mensual (12 veces por año)</option>
                                </select>
                                <p class="text-xs text-foreground-muted mt-1">Frecuencia con la que se capitaliza el interés</p>
                            </div>

                            <!-- Tipo de Períodos -->
                            <div>
                                <label for="tipo_periodo" class="block text-sm font-medium text-foreground mb-2">
                                    Tipo de Períodos <span class="text-danger">*</span>
                                </label>
                                <select id="tipo_periodo" 
                                        name="tipo_periodo" 
                                        class="w-full px-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                        required>
                                    <option value="">Seleccionar tipo de período</option>
                                    <option value="mensual" {{ old('tipo_periodo', $prefillData['tipo_periodo'] ?? '') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                                    <option value="trimestral" {{ old('tipo_periodo', $prefillData['tipo_periodo'] ?? '') == 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                                    <option value="semestral" {{ old('tipo_periodo', $prefillData['tipo_periodo'] ?? '') == 'semestral' ? 'selected' : '' }}>Semestral</option>
                                    <option value="anual" {{ old('tipo_periodo', $prefillData['tipo_periodo'] ?? '') == 'anual' ? 'selected' : '' }}>Anual</option>
                                </select>
                                <p class="text-xs text-foreground-muted mt-1">Frecuencia de los pagos de la anualidad</p>
                            </div>

                            <!-- Número de Períodos -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="periodos_pago" class="block text-sm font-medium text-foreground mb-2">
                                        Períodos de Pago (n) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           id="periodos_pago" 
                                           name="periodos_pago" 
                                           min="1"
                                           class="w-full px-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                           placeholder="24"
                                           value="{{ old('periodos_pago', $prefillData['periodos_pago'] ?? '') }}"
                                           required>
                                    <p class="text-xs text-foreground-muted mt-1">Número de pagos de la anualidad</p>
                                </div>

                                <div>
                                    <label for="periodos_diferimiento" class="block text-sm font-medium text-foreground mb-2">
                                        Períodos de Diferimiento (m) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           id="periodos_diferimiento" 
                                           name="periodos_diferimiento" 
                                           min="0"
                                           class="w-full px-4 py-3 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-primary bg-surface text-foreground"
                                           placeholder="6"
                                           value="{{ old('periodos_diferimiento', $prefillData['periodos_diferimiento'] ?? '') }}"
                                           required>
                                    <p class="text-xs text-foreground-muted mt-1">Períodos sin pagos antes de empezar</p>
                                </div>
                            </div>

                            <!-- Tipo de Anualidad -->
                            <div>
                                <label for="tipo_anualidad" class="block text-sm font-medium text-foreground mb-2">
                                    Tipo de Anualidad <span class="text-danger">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="flex items-center p-3 border border-border rounded-md cursor-pointer hover:bg-surface-secondary transition-colors">
                                        <input type="radio" 
                                               name="tipo_anualidad" 
                                               value="ordinaria" 
                                               class="text-primary focus:ring-primary border-border mr-3"
                                               {{ old('tipo_anualidad', $prefillData['tipo_anualidad'] ?? 'ordinaria') == 'ordinaria' ? 'checked' : '' }}
                                               required>
                                        <div>
                                            <div class="font-medium text-foreground">Ordinaria (Vencida)</div>
                                            <div class="text-xs text-foreground-muted">Pagos al final del período</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 border border-border rounded-md cursor-pointer hover:bg-surface-secondary transition-colors">
                                        <input type="radio" 
                                               name="tipo_anualidad" 
                                               value="anticipada" 
                                               class="text-primary focus:ring-primary border-border mr-3"
                                               {{ old('tipo_anualidad', $prefillData['tipo_anualidad'] ?? '') == 'anticipada' ? 'checked' : '' }}
                                               required>
                                        <div>
                                            <div class="font-medium text-foreground">Anticipada</div>
                                            <div class="text-xs text-foreground-muted">Pagos al inicio del período</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                <button type="submit" 
                                        class="bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-md font-medium transition-colors shadow-sm flex-1">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    Calcular Anualidad
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
                        <div class="bg-success-light border border-success/20 rounded-lg shadow-sm hover:shadow-md transition-all">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-3 h-3 bg-success rounded-full mr-2"></div>
                                    <h3 class="text-xl font-bold text-success mb-0">Resultado del Cálculo</h3>
                                </div>
                                
                                <div class="bg-surface p-4 rounded-lg border border-success/20 mb-4">
                                    <div class="text-center">
                                        <p class="text-sm text-foreground-muted mb-1">Anualidad Diferida (Renta)</p>
                                        <p class="text-3xl font-bold text-success">${{ number_format($resultado['renta'], 2) }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-foreground-muted">Tasa Efectiva:</span>
                                        <span class="font-medium text-foreground">{{ number_format($resultado['tasa_efectiva'] * 100, 4) }}%</span>
                                    </div>
                                    <div>
                                        <span class="text-foreground-muted">Total a Recibir:</span>
                                        <span class="font-medium text-foreground">${{ number_format($resultado['total_recibir'], 2) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-foreground-muted">Interés Total:</span>
                                        <span class="font-medium text-foreground">${{ number_format($resultado['interes_total'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detalles del Cálculo -->
                        <div class="bg-surface border border-border rounded-lg shadow-sm py-2">
                            <div class="px-6 py-4 border-b border-border">
                                <h3 class="text-xl font-bold text-foreground mb-2">Detalles del Cálculo</h3>
                            </div>
                            <div class="px-6 py-4 mt-2">
                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-foreground-muted">Capital Inicial:</span>
                                        <span class="font-medium text-foreground">${{ number_format($resultado['capital'], 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-foreground-muted">Tasa Nominal:</span>
                                        <span class="font-medium text-foreground">{{ number_format($resultado['tasa_nominal'], 3) }}%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-foreground-muted">Capitalización:</span>
                                        <span class="font-medium text-foreground">{{ ucfirst($resultado['capitalizacion']) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-foreground-muted">Tipo de Período:</span>
                                        <span class="font-medium text-foreground">{{ ucfirst($resultado['tipo_periodo']) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-foreground-muted">Períodos de Pago:</span>
                                        <span class="font-medium text-foreground">{{ $resultado['periodos_pago'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-foreground-muted">Períodos de Diferimiento:</span>
                                        <span class="font-medium text-foreground">{{ $resultado['periodos_diferimiento'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-foreground-muted">Tipo de Anualidad:</span>
                                        <span class="font-medium text-foreground">{{ ucfirst($resultado['tipo_anualidad']) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fórmula Utilizada -->
                        <div class="bg-surface border border-primary/20 rounded-lg shadow-sm hover:shadow-md transition-all py-2">
                            <div class="px-6 py-4 border-b border-primary/20 bg-primary/5">
                                <h3 class="text-xl font-bold text-primary mb-2">Fórmula Utilizada</h3>
                            </div>
                            <div class="px-6 py-4 mt-2">
                                <div class="bg-surface p-4 rounded-lg border border-primary/20 mb-3">
                                    <p class="text-center font-mono text-sm text-foreground">
                                        R = C x [i / 1 - (1 + i)<sup>-n</sup>] x (1 + i)<sup>-m</sup>
                                    </p>
                                </div>
                                <div class="text-xs text-foreground-muted space-y-1">
                                    <p><strong>R:</strong> Renta o anualidad</p>
                                    <p><strong>C:</strong> Capital inicial</p>
                                    <p><strong>i:</strong> Tasa de interés efectiva por período</p>
                                    <p><strong>n:</strong> Número de períodos de pago</p>
                                    <p><strong>m:</strong> Número de períodos de diferimiento</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Información Inicial -->
                        <div class="bg-surface border border-border rounded-lg shadow-sm">
                            <div class="p-6 text-center py-12">
                                <svg class="w-16 h-16 text-foreground-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-foreground mb-2">¿Qué son las Anualidades Diferidas?</h3>
                                <div class="text-foreground-muted space-y-3 max-w-md mx-auto text-left">
                                    <p>Las anualidades diferidas son una serie de pagos periódicos que <strong>comienzan después de un período de diferimiento</strong>.</p>
                                    <p>Se componen de dos etapas:</p>
                                    <ul class="list-disc list-inside space-y-1 ml-4">
                                        <li><strong>Período de diferimiento:</strong> No hay pagos, solo capitalización</li>
                                        <li><strong>Período de anualidad:</strong> Se realizan los pagos periódicos</li>
                                    </ul>
                                    <p class="text-sm text-primary font-medium">👈 Completa el formulario para calcular tu anualidad diferida</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-danger-light border border-danger/20 rounded-lg shadow-sm hover:shadow-md transition-all">
                            <div class="p-6">
                                <div class="flex items-center mb-3">
                                    <div class="w-3 h-3 bg-danger rounded-full mr-2"></div>
                                    <h3 class="text-xl font-bold text-danger mb-0">Errores en el Formulario</h3>
                                </div>
                                <ul class="space-y-1 text-sm">
                                    @foreach($errors->all() as $error)
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-danger mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function limpiarFormulario() {
            document.getElementById('calculadora-form').reset();
        }

        // Validación en tiempo real
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('calculadora-form');
            const inputs = form.querySelectorAll('input[type="number"]');
            
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = '';
                    }
                });
            });
        });
    </script>
@endsection
