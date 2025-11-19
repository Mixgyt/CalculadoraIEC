<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculadoraDiferidaController extends Controller
{
    public function index(){
        return view("calculadora_diferida",["page"=>"calculadoraD"]);
    }

    //Calcular Renta
    public function renta(Request $request){
        $request->validate([
            "capital" => "required|numeric|min:0.01",
            "tasa_nominal" => "required|numeric|min:0.001|max:100",
            "capitalizacion" => "required|in:anual,semestral,trimestral,mensual",
            "tipo_periodo" => "required|in:mensual,trimestral,semestral,anual",
            "periodos_pago" => "required|integer|min:1",
            "periodos_diferimiento" => "required|integer|min:0",
            "tipo_anualidad" => "required|in:ordinaria,anticipada"
        ], [
            "capital.required" => "El capital inicial es obligatorio",
            "capital.min" => "El capital debe ser mayor a 0",
            "tasa_nominal.required" => "La tasa de interés es obligatoria",
            "tasa_nominal.min" => "La tasa debe ser mayor a 0.001%",
            "tasa_nominal.max" => "La tasa no puede ser mayor a 100%",
            "capitalizacion.required" => "Debe seleccionar el tipo de capitalización",
            "tipo_periodo.required" => "Debe seleccionar el tipo de período",
            "periodos_pago.required" => "El número de períodos de pago es obligatorio",
            "periodos_pago.min" => "Debe haber al menos 1 período de pago",
            "periodos_diferimiento.required" => "Los períodos de diferimiento son obligatorios",
            "periodos_diferimiento.min" => "Los períodos de diferimiento no pueden ser negativos",
            "tipo_anualidad.required" => "Debe seleccionar el tipo de anualidad"
        ]);

        // Obtener datos del formulario
        $capital = $request->input("capital");
        $tasaNominal = $request->input("tasa_nominal") / 100; // Convertir porcentaje a decimal
        $capitalizacion = $request->input("capitalizacion");
        $tipoPeriodo = $request->input("tipo_periodo");
        $periodosPago = $request->input("periodos_pago");
        $periodosDiferimiento = $request->input("periodos_diferimiento");
        $tipoAnualidad = $request->input("tipo_anualidad");

        try {
            // Calcular la anualidad diferida
            $resultado = $this->calcularAnualidadDiferida(
                $capital,
                $tasaNominal,
                $capitalizacion,
                $tipoPeriodo,
                $periodosPago,
                $periodosDiferimiento,
                $tipoAnualidad
            );

            return view("calculadora_diferida", [
                "page" => "calculadoraD",
                "resultado" => $resultado
            ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'calculo' => 'Error en el cálculo: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Calcula la anualidad diferida con todos los parámetros
     */
    private function calcularAnualidadDiferida($capital, $tasaNominal, $capitalizacion, $tipoPeriodo, $periodosPago, $periodosDiferimiento, $tipoAnualidad)
    {
        // 1. Obtener frecuencias de capitalización y períodos
        $frecuenciaCapitalizacion = $this->getFrecuenciaCapitalizacion($capitalizacion);
        $frecuenciaPeriodo = $this->getFrecuenciaPeriodo($tipoPeriodo);

        // 2. Calcular tasa efectiva anual
        $tasaEfectivaAnual = pow(1 + ($tasaNominal / $frecuenciaCapitalizacion), $frecuenciaCapitalizacion) - 1;

        // 3. Convertir tasa efectiva anual a tasa efectiva por período
        $tasaEfectivaPeriodo = pow(1 + $tasaEfectivaAnual, 1 / $frecuenciaPeriodo) - 1;

        // 4. Calcular anualidad ordinaria básica
        $denominador = 1 - pow(1 + $tasaEfectivaPeriodo, -$periodosPago);
        
        if ($denominador == 0) {
            throw new \Exception("Error matemático: denominador es cero");
        }

        $rentaOrdinaria = ($capital * $tasaEfectivaPeriodo) / $denominador;

        // 5. Aplicar factor de diferimiento
        $factorDiferimiento = pow(1 + $tasaEfectivaPeriodo, $periodosDiferimiento);
        $rentaDiferida = $rentaOrdinaria * $factorDiferimiento;

        // 6. Ajustar para anualidad anticipada si es necesario
        if ($tipoAnualidad === 'anticipada') {
            $rentaDiferida = $rentaDiferida / (1 + $tasaEfectivaPeriodo);
        }

        // 7. Calcular totales y métricas adicionales
        $totalRecibir = $rentaDiferida * $periodosPago;
        $interesTotal = $totalRecibir - $capital;

        return [
            // Resultado principal
            'renta' => $rentaDiferida,
            
            // Métricas calculadas
            'tasa_efectiva' => $tasaEfectivaPeriodo,
            'total_recibir' => $totalRecibir,
            'interes_total' => $interesTotal,
            
            // Parámetros de entrada (para mostrar en el resumen)
            'capital' => $capital,
            'tasa_nominal' => $tasaNominal * 100,
            'capitalizacion' => $capitalizacion,
            'tipo_periodo' => $tipoPeriodo,
            'periodos_pago' => $periodosPago,
            'periodos_diferimiento' => $periodosDiferimiento,
            'tipo_anualidad' => $tipoAnualidad,
            
            // Datos adicionales para análisis
            'tasa_efectiva_anual' => $tasaEfectivaAnual,
            'factor_diferimiento' => $factorDiferimiento,
            'renta_sin_diferimiento' => $rentaOrdinaria
        ];
    }

    /**
     * Obtiene la frecuencia de capitalización por año
     */
    private function getFrecuenciaCapitalizacion($capitalizacion)
    {
        $frecuencias = [
            'anual' => 1,
            'semestral' => 2,
            'trimestral' => 4,
            'mensual' => 12
        ];

        return $frecuencias[$capitalizacion] ?? 1;
    }

    /**
     * Obtiene la frecuencia de períodos por año
     */
    private function getFrecuenciaPeriodo($tipoPeriodo)
    {
        $frecuencias = [
            'anual' => 1,
            'semestral' => 2,
            'trimestral' => 4,
            'mensual' => 12
        ];

        return $frecuencias[$tipoPeriodo] ?? 1;
    }
}
