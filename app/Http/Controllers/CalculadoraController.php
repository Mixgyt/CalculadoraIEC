<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculadoraController extends Controller
{
    public function index()
    {
        return view('calculadora');
    }

    public function calcular(Request $request)
    {
        // Validación base
        $validated = $request->validate([
            'tipo_calculo' => 'required|in:renta,valor_presente,monto,periodos',
            'tasa_interes' => 'required|numeric|min:0|max:100',
            'periodo_tasa' => 'required|in:anual,semestral,trimestral,bimestral,mensual',
            'periodo_capitalizacion' => 'nullable|in:anual,semestral,trimestral,bimestral,mensual,diario,continuo',
            'periodo_pagos' => 'required|in:anual,semestral,trimestral,bimestral,mensual',
            'valor_presente' => 'nullable|numeric|min:0',
            'renta' => 'nullable|numeric|min:0',
            'monto' => 'nullable|numeric|min:0',
            'numero_periodos' => 'nullable|integer|min:1|max:1000',
        ]);

        // Validaciones específicas según tipo de cálculo
        $this->validarCamposRequeridos($request);

        try {
            $resultado = $this->calcularAnualidadAnticipada($validated);
            return view('calculadora', compact('resultado'));
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Valida campos requeridos según el tipo de cálculo
     */
    private function validarCamposRequeridos(Request $request)
    {
        $validaciones = [
            'renta' => [
                'numero_periodos' => 'required|integer|min:1',
            ],
            'valor_presente' => [
                'renta' => 'required|numeric|min:0.01',
                'numero_periodos' => 'required|integer|min:1',
            ],
            'monto' => [
                'renta' => 'required|numeric|min:0.01',
                'numero_periodos' => 'required|integer|min:1',
            ],
            'periodos' => [
                'renta' => 'required|numeric|min:0.01',
            ],
        ];

        // Validación especial para renta: requiere Capital O Monto
        if ($request->tipo_calculo === 'renta') {
            $tieneCapital = $request->filled('valor_presente') && $request->valor_presente > 0;
            $tieneMonto = $request->filled('monto') && $request->monto > 0;
            
            if (!$tieneCapital && !$tieneMonto) {
                $request->validate([
                    'valor_presente' => 'required_without:monto|numeric|min:0.01',
                    'monto' => 'required_without:valor_presente|numeric|min:0.01',
                ]);
            }
        }

        // Validación especial para períodos: requiere Capital O Monto
        if ($request->tipo_calculo === 'periodos') {
            $tieneCapital = $request->filled('valor_presente') && $request->valor_presente > 0;
            $tieneMonto = $request->filled('monto') && $request->monto > 0;
            
            if (!$tieneCapital && !$tieneMonto) {
                $request->validate([
                    'valor_presente' => 'required_without:monto|numeric|min:0.01',
                    'monto' => 'required_without:valor_presente|numeric|min:0.01',
                ]);
            }
        }

        $tipo = $request->tipo_calculo;
        if (isset($validaciones[$tipo])) {
            $request->validate($validaciones[$tipo]);
        }
    }

    /**
     * Calcula anualidad anticipada según el tipo seleccionado
     */
    private function calcularAnualidadAnticipada(array $datos)
    {
        // Convertir tasa a decimal
        $tasaOriginal = $datos['tasa_interes'] / 100;
        
        // Determinar período de capitalización
        $periodoCapitalizacion = $datos['periodo_capitalizacion'] ?? $datos['periodo_tasa'];
        
        // Calcular tasas efectivas
        $tasaEfectivaAnual = $this->calcularTasaEfectivaAnual(
            $tasaOriginal, 
            $datos['periodo_tasa'],
            $periodoCapitalizacion
        );

        if($periodoCapitalizacion != $datos['periodo_tasa']){
            $tasaConvertida = $this->convertirDeTasaEfectivaAnual(
                $tasaEfectivaAnual, 
                $datos['periodo_pagos']
            );
        }
        else{
            $tasaConvertida = $tasaOriginal;
        }

        
        
        // Preparar resultado base
        $resultado = [
            'tipo_calculo' => $datos['tipo_calculo'],
            'tasa_original' => $datos['tasa_interes'],
            'periodo_tasa' => $datos['periodo_tasa'],
            'periodo_pagos' => $datos['periodo_pagos'],
            'tasa_convertida' => $tasaConvertida,
            'tasa_convertida_porcentaje' => $tasaConvertida * 100,
            'tasa_efectiva_anual' => $tasaEfectivaAnual,
            'tasa_efectiva_anual_porcentaje' => $tasaEfectivaAnual * 100,
        ];
        
        // Agregar información de capitalización si es diferente
        if ($periodoCapitalizacion !== $datos['periodo_tasa']) {
            $resultado['periodo_capitalizacion'] = $periodoCapitalizacion;
            $resultado['tasa_nominal_anual'] = $this->calcularTasaNominalAnual(
                $tasaOriginal, 
                $datos['periodo_tasa'], 
                $periodoCapitalizacion
            );
            $resultado['tasa_nominal_anual_porcentaje'] = $resultado['tasa_nominal_anual'] * 100;
        }

        // Realizar cálculo específico
        $metodoCalculo = $this->obtenerMetodoCalculo($datos['tipo_calculo']);
        $resultadoCalculo = $this->$metodoCalculo($datos, $tasaConvertida);
        
        return array_merge($resultado, $resultadoCalculo);
    }

    /**
     * Obtiene el nombre del método de cálculo
     */
    private function obtenerMetodoCalculo(string $tipoCalculo): string
    {
        $tipo = str_replace('_', '', ucwords($tipoCalculo, '_'));
        return 'calcular' . $tipo;
    }

    /**
     * Calcula la RENTA (R) - Pago periódico
     * Puede calcularse desde Capital (C) o desde Monto (M)
     */
    private function calcularRenta(array $datos, float $i): array
    {
        $n = $datos['numero_periodos'];
        
        // Determinar si se calcula desde Capital o Monto
        if (isset($datos['valor_presente']) && $datos['valor_presente'] > 0) {
            return $this->calcularRentaDesdeCapital($datos, $i);
        } elseif (isset($datos['monto']) && $datos['monto'] > 0) {
            return $this->calcularRentaDesdeMonto($datos, $i);
        }
        
        throw new \Exception('Se requiere Capital (C) o Monto (M) para calcular la renta.');
    }
    
    /**
     * Calcula renta desde el Capital (C)
     * Fórmula: R = C / [((1 - (1+i)^-n) / i) * (1+i)]
     */
    private function calcularRentaDesdeCapital(array $datos, float $i): array
    {
        $C = $datos['valor_presente'];
        $n = $datos['numero_periodos'];
        
        if ($i == 0) {
            $renta = $C / $n;
        } else {
            // Factor de valor presente ordinario
            $factorVPOrdinario = (1 - pow(1 + $i, -$n)) / $i;
            // Ajustar para anualidad anticipada
            $renta = $C / ($factorVPOrdinario * (1 + $i));
        }
        
        $totalPagado = $renta * $n;
        $interesesTotales = $totalPagado - $C;
        
        return [
            'valor_calculado' => $renta,
            'nombre_calculado' => 'Renta (R)',
            'valor_presente' => $C,
            'numero_periodos' => $n,
            'total_pagado' => $totalPagado,
            'intereses_totales' => $interesesTotales,
            'descripcion' => 'Pago periódico desde capital',
            'calculado_desde' => 'capital',
        ];
    }
    
    /**
     * Calcula renta desde el Monto (M)
     * Fórmula: R = M / [((1+i)^n - 1) / i) * (1+i)]
     */
    private function calcularRentaDesdeMonto(array $datos, float $i): array
    {
        $M = $datos['monto'];
        $n = $datos['numero_periodos'];
        
        if ($i == 0) {
            $renta = $M / $n;
        } else {
            // Factor de monto ordinario
            $factorMontoOrdinario = (pow(1 + $i, $n) - 1) / $i;
            // Ajustar para anualidad anticipada
            $renta = $M / ($factorMontoOrdinario * (1 + $i));
        }
        
        $totalDepositado = $renta * $n;
        $interesesGanados = $M - $totalDepositado;
        
        return [
            'valor_calculado' => $renta,
            'nombre_calculado' => 'Renta (R)',
            'monto' => $M,
            'numero_periodos' => $n,
            'total_depositado' => $totalDepositado,
            'intereses_ganados' => $interesesGanados,
            'descripcion' => 'Depósito periódico desde monto',
            'calculado_desde' => 'monto',
        ];
    }

    /**
     * Calcula el VALOR PRESENTE o CAPITAL (C)
     * Necesita: Renta (R), Número de períodos (n)
     * Fórmula: C = R * [(1 - (1+i)^-n) / i] * (1+i)
     */
    private function calcularValorPresente(array $datos, float $i): array
    {
        $R = $datos['renta'];
        $n = $datos['numero_periodos'];
        
        if ($i == 0) {
            $valorPresente = $R * $n;
        } else {
            // Factor de valor presente ordinario
            $factorVPOrdinario = (1 - pow(1 + $i, -$n)) / $i;
            // Ajustar para anualidad anticipada
            $valorPresente = $R * $factorVPOrdinario * (1 + $i);
        }
        
        $totalPagos = $R * $n;
        $interesesGanados = $totalPagos - $valorPresente;
        
        return [
            'valor_calculado' => $valorPresente,
            'nombre_calculado' => 'Capital (C)',
            'renta' => $R,
            'numero_periodos' => $n,
            'total_pagos' => $totalPagos,
            'intereses_ganados' => $interesesGanados,
            'descripcion' => 'Valor presente de la anualidad',
        ];
    }

    /**
     * Calcula el MONTO o VALOR FUTURO (M)
     * Necesita: Renta (R), Número de períodos (n)
     * Fórmula: M = R * [((1+i)^n - 1) / i] * (1+i)
     */
    private function calcularMonto(array $datos, float $i): array
    {
        $R = $datos['renta'];
        $n = $datos['numero_periodos'];
        
        if ($i == 0) {
            $monto = $R * $n;
        } else {
            // Factor de monto ordinario
            $factorMontoOrdinario = (pow(1 + $i, $n) - 1) / $i;
            // Ajustar para anualidad anticipada
            $monto = $R * $factorMontoOrdinario * (1 + $i);
        }
        
        $totalDepositado = $R * $n;
        $interesesGanados = $monto - $totalDepositado;
        
        return [
            'valor_calculado' => $monto,
            'nombre_calculado' => 'Monto (M)',
            'renta' => $R,
            'numero_periodos' => $n,
            'total_depositado' => $totalDepositado,
            'intereses_ganados' => $interesesGanados,
            'descripcion' => 'Monto (Valor futuro de la anualidad)',
        ];
    }

    /**
     * Calcula el NÚMERO DE PERÍODOS (n)
     * Puede calcularse desde Capital (C) o desde Monto (M)
     */
    private function calcularPeriodos(array $datos, float $i): array
    {
        $R = $datos['renta'];
        
        // Determinar si se calcula desde Capital o Monto
        if (isset($datos['valor_presente']) && $datos['valor_presente'] > 0) {
            return $this->calcularPeriodosDesdeCapital($datos, $i);
        } elseif (isset($datos['monto']) && $datos['monto'] > 0) {
            return $this->calcularPeriodosDesdeMonto($datos, $i);
        }
        
        throw new \Exception('Se requiere Capital (C) o Monto (M) para calcular períodos.');
    }

    /**
     * Calcula períodos desde el Capital (C)
     * Fórmula: n = -ln(1 - (C * i) / (R * (1+i))) / ln(1+i)
     */
    private function calcularPeriodosDesdeCapital(array $datos, float $i): array
    {
        $C = $datos['valor_presente'];
        $R = $datos['renta'];
        
        if ($i == 0) {
            $numPeriodos = $C / $R;
        } else {
            // Validar que los valores permitan el cálculo
            $rentaAjustada = $R * (1 + $i);
            
            if ($rentaAjustada <= 0) {
                throw new \Exception('La renta debe ser mayor a cero.');
            }
            
            $factor = 1 - ($C * $i) / $rentaAjustada;
            
            if ($factor <= 0) {
                throw new \Exception('La renta es insuficiente para pagar el capital con la tasa dada. Aumenta la renta.');
            }
            
            if ($factor >= 1) {
                throw new \Exception('El capital es menor o igual a la primera renta. Se requiere máximo 1 pago.');
            }
            
            $numPeriodos = -log($factor) / log(1 + $i);
        }
        
        $periodoCompleto = ceil($numPeriodos);
        $periodoExacto = $numPeriodos;
        
        // Calcular último pago ajustado si no es exacto
        $ultimoPago = $R;
        if (abs($periodoExacto - $periodoCompleto) > 0.01) {
            // Calcular saldo después del penúltimo pago
            $C_penultimo = $R * ((1 - pow(1 + $i, -($periodoCompleto - 1))) / $i) * (1 + $i);
            $ultimoPago = ($C - $C_penultimo) / (1 + $i);
        }
        
        $totalPagado = ($R * ($periodoCompleto - 1)) + $ultimoPago;
        
        return [
            'valor_calculado' => $periodoCompleto,
            'nombre_calculado' => 'Número de Períodos (n)',
            'periodos_exactos' => round($periodoExacto, 4),
            'valor_presente' => $C,
            'renta' => $R,
            'descripcion' => 'Períodos necesarios para amortizar',
            'calculado_desde' => 'capital',
        ];
    }

    /**
     * Calcula períodos desde el Monto (M)
     * Fórmula: n = ln(1 + (M * i) / (R * (1+i))) / ln(1+i)
     */
    private function calcularPeriodosDesdeMonto(array $datos, float $i): array
    {
        $M = $datos['monto'];
        $R = $datos['renta'];
        
        if ($i == 0) {
            $numPeriodos = $M / $R;
        } else {
            $rentaAjustada = $R * (1 + $i);
            
            if ($rentaAjustada <= 0) {
                throw new \Exception('La renta debe ser mayor a cero.');
            }
            
            if ($M <= 0) {
                throw new \Exception('El monto debe ser mayor a cero.');
            }
            
            $factor = 1 + ($M * $i) / $rentaAjustada;
            
            if ($factor <= 1) {
                throw new \Exception('El monto es menor que la primera renta. Se requiere máximo 1 depósito.');
            }
            
            $numPeriodos = log($factor) / log(1 + $i);
        }
        
        $periodoCompleto = ceil($numPeriodos);
        $periodoExacto = $numPeriodos;
        
        // Calcular último depósito ajustado si no es exacto
        $ultimoDeposito = $R;
        if (abs($periodoExacto - $periodoCompleto) > 0.01) {
            // Calcular monto después del penúltimo depósito
            $M_penultimo = $R * ((pow(1 + $i, $periodoCompleto - 1) - 1) / $i) * (1 + $i);
            $ultimoDeposito = ($M - $M_penultimo * (1 + $i)) / (1 + $i);
        }
        
        $totalDepositado = ($R * ($periodoCompleto - 1)) + $ultimoDeposito;
        $interesesGanados = $M - $totalDepositado;
        
        return [
            'valor_calculado' => $periodoCompleto,
            'nombre_calculado' => 'Número de Períodos (n)',
            'periodos_exactos' => round($periodoExacto, 4),
            'monto' => $M,
            'renta' => $R,
            'intereses_ganados' => $interesesGanados,
            'descripcion' => 'Períodos necesarios para acumular',
            'calculado_desde' => 'monto',
        ];
    }

    /**
     * Calcula la tasa efectiva anual considerando capitalización
     */
    private function calcularTasaEfectivaAnual(float $tasa, string $periodoTasa, string $periodoCapitalizacion): float
    {
        // Si no hay capitalización específica, usar el método tradicional
        if ($periodoCapitalizacion === $periodoTasa) {
            $m = $this->obtenerFrecuencia($periodoTasa);
            return pow(1 + $tasa, $m) - 1;
        }
        
        // Primero convertir a tasa nominal anual
        $tasaNominalAnual = $this->calcularTasaNominalAnual($tasa, $periodoTasa, $periodoCapitalizacion);
        
        // Luego calcular la tasa efectiva anual
        return $this->convertirNominalAEfectiva($tasaNominalAnual, $periodoCapitalizacion);
    }
    
    /**
     * Calcula la tasa nominal anual a partir de una tasa de período
     */
    private function calcularTasaNominalAnual(float $tasa, string $periodoTasa, string $periodoCapitalizacion): float
    {
        // Convertir la tasa del período a tasa efectiva anual
        $m = $this->obtenerFrecuencia($periodoTasa);
        $tasaEfectivaAnual = pow(1 + $tasa, $m) - 1;
        
        // Convertir tasa efectiva anual a nominal con la capitalización deseada
        return $this->convertirEfectivaANominal($tasaEfectivaAnual, $periodoCapitalizacion);
    }
    
    /**
     * Convierte tasa efectiva anual a tasa nominal
     */
    private function convertirEfectivaANominal(float $tasaEfectiva, string $periodoCapitalizacion): float
    {
        if ($periodoCapitalizacion === 'continuo') {
            return log(1 + $tasaEfectiva);
        }
        
        $n = $this->obtenerFrecuencia($periodoCapitalizacion);
        return $n * (pow(1 + $tasaEfectiva, 1 / $n) - 1);
    }
    
    /**
     * Convierte tasa nominal a tasa efectiva anual
     */
    private function convertirNominalAEfectiva(float $tasaNominal, string $periodoCapitalizacion): float
    {
        if ($periodoCapitalizacion === 'continuo') {
            return exp($tasaNominal) - 1;
        }
        
        $n = $this->obtenerFrecuencia($periodoCapitalizacion);
        return pow(1 + $tasaNominal / $n, $n) - 1;
    }

    /**
     * Convierte tasa efectiva anual a tasa del período
     * Fórmula: i_periodo = (1 + i_EA)^(1/n) - 1
     */
    private function convertirDeTasaEfectivaAnual(float $tasaEfectivaAnual, string $periodo): float
    {
        $n = $this->obtenerFrecuencia($periodo);
        return $tasaEfectivaAnual / $n;
    }

    /**
     * Obtiene la frecuencia de capitalización por año
     */
    private function obtenerFrecuencia(string $periodo): int
    {
        $frecuencias = [
            'anual' => 1,
            'semestral' => 2,
            'trimestral' => 4,
            'bimestral' => 6,
            'mensual' => 12,
            'diario' => 365,
            'continuo' => PHP_INT_MAX // Se maneja especialmente
        ];

        return $frecuencias[$periodo] ?? 1;
    }
}