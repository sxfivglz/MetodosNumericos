@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Calculadora que implementa el método de Newton</h1>
    <form action="{{ route('newton.calculate') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="input-function">Función</label>
            <input type="text" class="form-control" id="input-function" placeholder="(e.j., x^2 - 4)" name="function">
        </div>
        <div class="form-group">
            <label for="input-x0">Valor inicial (x0)</label>
            <input type="text" class="form-control" id="input-x0" name="x0" placeholder="(ej. -5)">
        </div>
        <div class="form-group">
            <label for="input-tolerance">Tolerancia deseada</label>
            <input type="text" class="form-control" id="input-tolerance" name="tolerance" placeholder="(ej. 0.0001)">
        </div>
        <div class="form-group">
            <label for="input-convergence">Tipo de tolerancia</label>
            <select class="form-control" id="input-convergence" name="convergence">
                <option value="endpoint">Convergencia del punto final</option>
                <option value="function">Convergencia de la función</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Calcular</button>
    </form>

    <!-- Sección para mostrar el resultado -->
    @if(isset($result))
    <div class="mt-5">
        <h2>Result:</h2>
        <table class="table">
            <thead>
                <tr>
                   
                    <th>Paso</th>
                    <th>x</th>
                    <th>F (X)</th>
                    <th>|x(i) - x(i-1)|</th>
                </tr>
            </thead>
            <tbody>
                @foreach($iterations as $iteration)
                <tr>
                    <td>{{ $iteration['step'] }}</td>
                    <td>{{ $iteration['x'] }}</td>
                    <td>{{ $iteration['fx'] }}</td>
                    <td>{{ $iteration['absolute_difference'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection