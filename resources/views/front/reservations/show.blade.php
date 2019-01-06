@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center row-home">
            <div class="col col-lg-12 col-home">
                <h1>{{ env('APP_NAME') }}</h1>
                @include('layouts.partials._messages')
                <h4>Reserva #{{ $reservation->id }}</h4>
                <p><b>Usuario: </b>{{ $reservation->user->name }}</p>
                <p><b>Número de Personas: </b>{{ $reservation->num_persons }}</p>
                <p><b>Fecha de reserva: </b>{{ $reservation->created_at != null ? ucwords($reservation->created_at->format('F d\\, Y')) : ' Sin Fecha ' }}</p>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Silla #</th>
                            <th scope="col">Fila</th>
                            <th scope="col">Columna</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservation->chairs as $chair)
                            <tr>
                                <td scope="row">{{ $chair->id }}</td>
                                <td>{{ $chair->row }}</td>
                                <td>{{ $chair->column }}</td>
                            </tr>
                        @endforeach()
                    </tbody>
                </table>
                <br>
                <a href="{{ route('welcome') }}" class="btn btn-secondary">Ir a Inicio</a>
                <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-success">Editar</a>
            </div>
        </div>
    </div>
@endsection
