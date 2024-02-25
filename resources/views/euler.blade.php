@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Método de Euler</h1>

    <!-- Formulario de entrada -->
    <form action="{{ route('euler.calculate') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="input-function">Ecuación diferencial (y'): </label>
            <input type="text" class="form-control" id="input-function" name="function" placeholder=" ej. -x/y"
                value="{{ isset($function) ? $function : '' }}">
        </div>
        <div class="form-group">
            <label for="input-x0">Inicial x (x<sub>0</sub>): </label>
            <input type="text" class="form-control" id="input-x0" name="x0" placeholder="ej. 0" value="{{ isset($x0) ? $x0 : '' }}">
        </div>
        <div class="form-group">
            <label for="input-y0">Inicial y (y<sub>0</sub>): </label>
            <input type="text" class="form-control" id="input-y0" name="y0" placeholder="ej. 4" value="{{ isset($y0) ? $y0 : '' }}">
        </div>
        <div class="form-group">
            <label for="input-point">Punto de aproximación: </label>
            <input type="text" class="form-control" id="input-point" placeholder="ej. 0" name="point"
                value="{{ isset($point) ? $point : '' }}">
        </div>
        <div class="form-group">
            <label for="input-h">Tamaño del paso (h): </label>
            <input type="text" class="form-control" id="input-h" name="h" placeholder="0.1" value="{{ isset($h) ? $h : '' }}">
        </div>
        <div class="form-group">
            <label for="input-n">Número de pasos (n): </label>
            <input type="text" class="form-control" id="input-n" name="n" placeholder="10" value="{{ isset($n) ? $n : '' }}">
        </div>
        <button type="submit" class="btn btn-primary">Calcular</button>
    </form>

    <!-- Resultados del Método de Euler -->
    @if(isset($results))
    <h2 class="mt-5">Resultados</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">n</th>
                <th scope="col">x<sub>n</sub></th>
                <th scope="col">Aproximación</th>
                <th scope="col">f(x,y)</th>
                <th scope="col">y<sub>n+1</sub></th>
                <th scope="col">Solución Exacta</th>
                <th scope="col">Error Absoluto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr>
                <td>{{ $result['n'] }}</td>
                <td>{{ $result['x'] }}</td>
                <td>{{ $result['approximation'] }}</td>
                <td>{{ $result['fxy'] }}</td>
                <td>{{ $result['ynext'] }}</td>
                <td>{{ isset($result['exact_solution']) ? $result['exact_solution'] : '' }}</td>
                <td>{{ isset($result['absolute_error']) ? $result['absolute_error'] : '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection