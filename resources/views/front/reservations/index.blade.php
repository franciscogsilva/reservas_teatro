@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center row-home">
            <div class="col col-lg-12 col-home">
                <h1>{{ env('APP_NAME') }}</h1>
                @include('layouts.partials._messages')
                <h4>Reservaciones de {{ Auth::user()->name }}</h4>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Reservación #</th>
                            <th scope="col"># de Personas</th>
                            <th scope="col">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td scope="row">{{ $reservation->id }}</td>
                                <td>{{ $reservation->num_persons }}</td>
                                <td>{{ $reservation->created_at != null ? ucwords($reservation->created_at->format('F d\\, Y')) : ' Sin Fecha ' }}</td>
                                <td>
                                    <a href="{{ route('reservations.destroy', $reservation->id) }}" class="btn btn-danger">Eliminar</a>
                                    <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-success">Editar</a>
                                </td>
                            </tr>
                        @endforeach()
                    </tbody>
                </table>
                <br>
            </div>
        </div>
    </div>
@endsection
