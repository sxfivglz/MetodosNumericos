<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;


class EulerController extends Controller
{
    public function index()
    {
        return view('euler');
    }

    public function calculate(Request $request)
    {
        // Validación de entrada
        $request->validate([
            'function' => 'required|string',
            'x0' => 'required|numeric',
            'y0' => 'required|numeric',
            'point' => 'required|numeric',
            'h' => 'required|numeric',
            'n' => 'required|numeric',
        ]);

        // Obteniendo los datos del formulario
        $function = $request->input('function');
        $x0 = $request->input('x0');
        $y0 = $request->input('y0');
        $point = $request->input('point');
        $h = $request->input('h');
        $n = $request->input('n');

        // Calculando los valores requeridos
        $results = $this->calculateImprovedEuler($function, $x0, $y0, $point, $h, $n, $function);

        // Pasando los resultados a la vista
        return view('euler', [
            'results' => $results,
            'function' => $function,
            'x0' => $x0,
            'y0' => $y0,
            'point' => $point,
            'h' => $h,
            'n' => $n,
        ]);
    }

    private function calculateImprovedEuler($function, $x0, $y0, $point, $h, $n, $exactFunction)
    {
        $results = [];

        $x = $x0;
        $y = $y0;

        for ($i = 0; $i <= $n; $i++) {
            $fxy = $this->evaluateFunction($function, $x, $y);

            // Método de Euler mejorado
            $yPredicted = $y + $h * $fxy;
            $yCorrected = $y + $h / 2 * ($fxy + $this->evaluateFunction($function, $x + $h, $yPredicted));

            // Calculando los valores necesarios para la tabla
            $exactSolution = $this->evaluateFunction($exactFunction, $x, null);
            $absoluteError = abs($yCorrected - $exactSolution);

            $results[] = [
                'n' => $i,
                'x' => round($x, 2),
                'approximation' => round($y, 4),
                'fxy' => round($fxy, 4),
                'ynext' => round($yCorrected, 4),
                'exact_solution' => round($exactSolution, 4),
                'absolute_error' => round($absoluteError, 4),
            ];

            // Actualizando los valores para la próxima iteración
            $x += $h;
            $y = $yCorrected;
        }

        return $results;
    }
private function evaluateFunction($function, $x, $y)
{
    $language = new ExpressionLanguage();

    // Definimos las variables para x e y
    $variables = ['x' => $x, 'y' => $y];

    // Evaluamos la expresión con las variables definidas
    try {
        $result = $language->evaluate($function, $variables);
        // Verificar si el resultado es un número finito
        if (!is_finite($result)) {
            throw new \RuntimeException('La expresión evaluada no es un número finito.');
        }
        return $result;
    } catch (\DivisionByZeroError $e) {
        // Manejar la división por cero
        return INF; // Retornar infinito como valor predeterminado
    } catch (\Throwable $e) {
        // Manejar otros errores
        throw new \RuntimeException('Error al evaluar la función: ' . $e->getMessage());
    }
}

}
