<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewtonRaphsonController extends Controller
{
    public function index()
    {
        return view('newton');
    }

    public function calculate(Request $request)
    {
        // Validación de entrada
        $request->validate([
            'function' => 'required|string',
            'x0' => 'required|numeric',
            'tolerance' => 'required|numeric',
            'convergence' => 'required|string|in:endpoint,function',
        ]);

        // Obteniendo los datos del formulario
        $function = $request->input('function');
        $x0 = $request->input('x0');
        $tolerance = $request->input('tolerance');
        $convergence = $request->input('convergence');

        // Formatear la expresión antes de evaluarla
        $function = $this->formatExpression($function);

        // Resolviendo la ecuación diferencial usando el método de Newton-Raphson
        $result = $this->newtonRaphson($function, $x0, $tolerance, $convergence);

        // Calculando las iteraciones
        $iterations = $this->calculateIterations($function, $x0, $tolerance, $convergence);

        // Pasando los resultados a la vista
        return view('newton', [
            'result' => $result,
            'iterations' => $iterations,
            'function' => $function,
            'x0' => $x0,
            'tolerance' => $tolerance,
            'convergence' => $convergence,
        ]);
    }

    // Método para calcular la raíz de la ecuación usando el método de Newton-Raphson
    private function newtonRaphson($function, $x0, $tolerance, $convergence)
    {
        $x = $x0;
        $iteration = 0;

        do {
            // Evaluamos la función y su derivada en x
            $fx = $this->evaluateFunction($function, $x);
            $dfx = $this->evaluateDerivative($function, $x);

            // Manejo de división por cero en la derivada
            if ($dfx == 0) {
                throw new \Exception("Division by zero occurred when evaluating the derivative.");
            }

            // Calculamos el siguiente valor de x usando el método de Newton-Raphson
            $xNext = $x - ($fx / $dfx);

            // Comprobamos el criterio de convergencia
            if ($convergence === 'endpoint') {
                $error = abs($xNext - $x);
            } else {
                $error = abs($fx);
            }

            // Actualizamos el valor de x
            $x = $xNext;

            $iteration++;

            // Salir si la tolerancia es alcanzada o si se alcanza el número máximo de iteraciones
        } while ($error > $tolerance && $iteration < 100);

        return $x;
    }

    // Método para evaluar la función en un valor dado de x
    private function evaluateFunction($function, $x)
    {
        // Usamos la función `eval` para evaluar la expresión matemática
        $expression = str_replace('x', "($x)", $function);
        return eval("return $expression;");
    }

    // Método para evaluar la derivada de la función en un valor dado de x
    private function evaluateDerivative($function, $x)
    {
        // Usamos la función `eval` para evaluar la expresión matemática de la derivada
        $h = 0.0001; // Un pequeño incremento para calcular la derivada
        $expression = "((" . str_replace('x', "($x + $h)", $function) . ") - (" . str_replace('x', "($x)", $function) . ")) / $h";
        return eval("return $expression;");
    }

    private function calculateIterations($function, $x0, $tolerance, $convergence)
{
    $iterations = [];
    $xPrev = $x0;
    $iteration = 0;

    do {
        // Evaluamos la función y su derivada en xPrev
        $fx = $this->evaluateFunction($function, $xPrev);
        $dfx = $this->evaluateDerivative($function, $xPrev);

        // Manejo de división por cero en la derivada
        if ($dfx == 0) {
            throw new \Exception("Division by zero occurred when evaluating the derivative.");
        }

        // Calculamos el siguiente valor de x usando el método de Newton-Raphson
        $xNext = $xPrev - ($fx / $dfx);

        // Calculamos el error absoluto
        $absoluteDifference = abs($xNext - $xPrev);

        // Almacenamos los datos de la iteración actual
        $iterations[] = [
            'iteration' => $iteration + 1,
            'step' => 'x' . ($iteration + 1),
            'x' => round($xNext, 4), // Redondeamos a 4 decimales
            'fx' => round($this->evaluateFunction($function, $xNext), 4), // Evaluamos f(x) en el nuevo valor de x y redondeamos a 4 decimales
            'absolute_difference' => round($absoluteDifference, 4), // Redondeamos a 4 decimales
        ];

        // Actualizamos el valor de x para la próxima iteración
        $xPrev = $xNext;

        $iteration++;

        // Salir si la tolerancia es alcanzada o si se alcanza el número máximo de iteraciones
    } while ($absoluteDifference > $tolerance && $iteration < 100);

    return $iterations;
}

// private function calculateIterations($function, $x0, $tolerance, $convergence)
// {
//     $iterations = [];
//     $xPrev = $x0;
//     $iteration = 0;

//     do {
//         // Evaluamos la función y su derivada en xPrev
//         $fx = $this->evaluateFunction($function, $xPrev);
//         $dfx = $this->evaluateDerivative($function, $xPrev);

//         // Manejo de división por cero en la derivada
//         if ($dfx == 0) {
//             throw new \Exception("Division by zero occurred when evaluating the derivative.");
//         }

//         // Calculamos el siguiente valor de x usando el método de Newton-Raphson
//         $xNext = $xPrev - ($fx / $dfx);

//         // Calculamos el error absoluto
//         $absoluteDifference = abs($xNext - $xPrev);

//         // Almacenamos los datos de la iteración actual
//         $iterations[] = [
//             'iteration' => $iteration + 1,
//             'step' => 'x' . ($iteration + 1),
//             'x' => round($xNext, 4), // Redondeamos a 4 decimales
//             'fx' => round($fx, 4), // Redondeamos a 4 decimales
//             'absolute_difference' => round($absoluteDifference, 4), // Redondeamos a 4 decimales
//         ];

//         // Actualizamos el valor de x para la próxima iteración
//         $xPrev = $xNext;

//         $iteration++;

//         // Salir si la tolerancia es alcanzada o si se alcanza el número máximo de iteraciones
//     } while ($absoluteDifference > $tolerance && $iteration < 100);

//     return $iterations;
// }



    // Método para formatear la expresión
    private function formatExpression($expression)
    {
        // Reemplaza los operadores y símbolos matemáticos
        $formattedExpression = str_replace('^', '**', $expression);
        // Agrega otros reemplazos si es necesario

        return $formattedExpression;
    }
}

