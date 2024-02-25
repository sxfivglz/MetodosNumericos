{{-- runge_kutta.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Método de Runge-Kutta</h1>

    <!-- Formulario de entrada -->
    <form action="{{ route('runge-kutta.calculate') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="input-function">Ecuación diferencial (y'): </label>
            <input type="text" class="form-control" id="input-function" name="function" value="{{ old('function') }}"
                placeholder="Ingrese la función">
        </div>
        <div class="form-group">
            <label for="input-x0">Inicial x (x<sub>0</sub>): </label>
            <input type="text" class="form-control" id="input-x0" name="x0" value="{{ old('x0') }}"
                placeholder="Ingrese x0">
        </div>
        <div class="form-group">
            <label for="input-y0">Inicial y (y<sub>0</sub>): </label>
            <input type="text" class="form-control" id="input-y0" name="y0" value="{{ old('y0') }}"
                placeholder="Ingrese y0">
        </div>
        <div class="form-group">
            <label for="input-point">Número de puntos: </label>
            <input type="text" class="form-control" id="input-point" name="point" value="{{ old('point') }}"
                placeholder="Ingrese el número de puntos">
        </div>
        <div class="form-group">
            <label for="input-h">Tamaño del paso (h): </label>
            <input type="text" class="form-control" id="input-h" name="h" value="{{ old('h') }}"
                placeholder="Ingrese h">
        </div>
        <button type="submit" class="btn btn-primary">Calcular</button>
    </form>

    <!-- Resultados del Método de Runge-Kutta -->
 <!-- Resultados del Método de Runge-Kutta -->
@if(isset($results))
<h2 class="mt-5">Resultados</h2>
<table class="table">
    <thead>
        <tr>
            <th scope="col">n</th>
            <th scope="col">x{n}</th>
            <th scope="col">y{n}</th>
            <th scope="col">k1</th>
            <th scope="col">k2</th>
            <th scope="col">k3</th>
            <th scope="col">k4</th>
            <th scope="col">y{n+1}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $key => $result)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $result['x'] }}</td>
            <td>{{ $result['y'] }}</td>
            <td>{{ $result['k1'] }}</td>
            <td>{{ $result['k2'] }}</td>
            <td>{{ $result['k3'] }}</td>
            <td>{{ $result['k4'] }}</td>
            <td>{{ $result['ynext'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
</div>
@endsection