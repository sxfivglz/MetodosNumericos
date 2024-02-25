<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RungeKuttaController extends Controller
{
    public function index()
    {
        return view('runge_kutta');
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
        ]);

        // Obteniendo los datos del formulario
        $function = $request->input('function');
        $x0 = $request->input('x0');
        $y0 = $request->input('y0');
        $point = $request->input('point');
        $h = $request->input('h');

        // Calculando los valores requeridos
        $results = $this->calculateRungeKutta($function, $x0, $y0, $point, $h);

        // Pasando los resultados a la vista
        return view('runge_kutta', [
            'results' => $results,
            'function' => $function,
            'x0' => $x0,
            'y0' => $y0,
            'point' => $point,
            'h' => $h,
        ]);
    }

  private function calculateRungeKutta($function, $x0, $y0, $point, $h)
{
    $results = [];

    $x = $x0;
    $y = $y0;

    for ($i = 0; $i < $point; $i++) {
        // Método de Runge-Kutta
        $k1 = $h * $this->evaluateFunction($function, $x, $y);
        $k2 = $h * $this->evaluateFunction($function, $x + $h / 2, $y + $k1 / 2);
        $k3 = $h * $this->evaluateFunction($function, $x + $h / 2, $y + $k2 / 2);
        $k4 = $h * $this->evaluateFunction($function, $x + $h, $y + $k3);
        $yNext = $y + ($k1 + 2 * $k2 + 2 * $k3 + $k4) / 6;
        
        // Agregar resultado a la lista
        $results[] = [
            'x' => $x,
            'y' => $y,
            'k1' => $k1,
            'k2' => $k2,
            'k3' => $k3,
            'k4' => $k4,
            'ynext' => $yNext,
        ];

        // Actualizar x e y para la siguiente iteración
        $x += $h;
        $y = $yNext;
    }

    return $results;
}


    private function evaluateFunction($function, $x, $y)
    {
        // Implementa la evaluación de la función aquí
        // Por ejemplo, puedes usar una librería de expresiones matemáticas como Symfony ExpressionLanguage

        // Aquí asumo que utilizas Symfony ExpressionLanguage para evaluar la función
        $language = new \Symfony\Component\ExpressionLanguage\ExpressionLanguage();
        return $language->evaluate($function, ['x' => $x, 'y' => $y]);
    }
}
