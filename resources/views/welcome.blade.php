@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center row-home">
            <div class="col col-lg-12 col-home">
                @include('layouts.partials._messages')
				<section class="jumbotron text-center">
					<div class="container">
						<h1 class="jumbotron-heading">{{ env('APP_NAME') }}</h1>
						<p class="lead text-muted">Bienvenidos al sistema para la gestion de Reservas en un Teatro</p>
						<p>
							<a href="{{ route('reservations.create') }}" class="btn btn-success my-2">Crear una Reserva</a>
						</p>
					</div>
				</section>
            </div>
        </div>
    </div>
@endsection()