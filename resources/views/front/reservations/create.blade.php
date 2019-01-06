@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center row-home">
            <div class="col col-lg-12 col-home">
                <h1>{{ env('APP_NAME') }}</h1>
                @include('layouts.partials._messages')
                @if(isset($reservation))
                    {!! Form::open(['route' => ['reservations.update', $reservation->id], 'method' => 'PUT', 'id' => 'form-update']) !!}
                    <?php 
                        $array = $reservation->chairs()->pluck('id')->toArray();
                    ?>
                @else 
                    {!! Form::open(['route' => 'reservations.store', 'method' => 'POST']) !!}
                @endif
                    <div class="form-group">
                        <h5>{{isset($reservation)?'Editar Reserva':'Crear Reservar'}}</h5>
                        <label for="exampleFormControlSelect1">Número de Personas</label>
                        <select id="numPersons" name="numPersons" class="form-control" id="exampleFormControlSelect1">
                            <option value="" selected disabled>Selecciona el número de personas</option>
                            @for($i=1; $i<=$chairs->where('reservation_id', null)->count(); $i++)
                                @if(isset($reservation))
                                    <option value="{{ $i }}" {{$i==$reservation->num_persons?'selected':''}}>{{ $i }}</option>
                                @else
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endif
                                option
                            @endfor
                        </select>
                        <div id="selectedChairs"></div>
                        <div class="panel-chairs">
                            <p>Selecciona las Sillas</p>
                            <div class="col col-lg-12 container-table">
                                <table class="table-chairs">
                                    @for($row=1; $row<=5; $row++)
                                        <tr>
                                            @for($column=1; $column<=10; $column++)
                                                <?php
                                                    $chair = $chairs->where('row', $row)->where('column', $column)->first();
                                                ?>
                                                <td>
                                                    <a class="chair-container {{ !$chair->reservation_id?'chair-free':(isset($reservation)?(in_array($chair->id, $array)?'my-chair':'chair-taken'):'chair-taken') }}" id="chair_{{ $chair->id }}" onclick="validateChair('{{ $chair->id }}')">
                                                        <i class="fas fa-chair"></i>
                                                    </a>
                                                </td>
                                            @endfor
                                        </tr>
                                    @endfor
                                </table>
                            </div>                            
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mb-2 btn-lg" id="btn-sub" disabled>{{isset($reservation)?'Editar Reserva':'Reservar'}}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var numPersons = "{{isset($reservation)}}"?$("#numPersons :selected").val():null;
        var selectedChairs = new Array();

        if("{{isset($reservation)}}"){
            $("#btn-sub").prop("disabled", false);
            var new_array = new Array();
            <?php
                if(isset($reservation)){ 
                    foreach($array as $val){ ?>
                        new_array.push('<?php echo $val; ?>');
            <?php }} ?>
        }

        $('select').on('change', function() {
            numPersons = $("#numPersons :selected").val();
            setChairs();
        });

        $('#form-update').on('submit', function(){
            console.log(new_array)
            if(numPersons>0){
                for (var i=0; i<new_array.length; i++){                    
                    $("#selectedChairs").append('<input type="hidden" name="selectedChairs[]" value="'+new_array[i]+'">');
                }
           }
        });

        function validateChair(id){
            if(numPersons == null){
                alert('Primero debe seleccionar el número de personas');
            }else{
                if(numPersons>0){
                    $.ajax({
                        method  : 'GET',
                        url     : "{{ url('validate-chair') }}/"+id,
                        success : function(data) {
                            if($.trim(data) == 1){
                                $("#chair_"+id).removeClass( "chair-free" ).addClass( "chair-waiting" );
                                $("#selectedChairs").append('<input type="hidden" name="selectedChairs[]" value="'+id+'">');
                                numPersons--;
                                if(numPersons<=0){
                                    $("#btn-sub").prop("disabled", false);
                                }
                            }else{
                                if("{{isset($reservation)}}"){
                                    if(new_array.includes(id)){
                                        new_array.splice(new_array.indexOf(id), 1);                                        
                                        $("#chair_"+id).removeClass( "my-chair" ).addClass( "chair-free" );
                                    }else{
                                        $("#chair_"+id).removeClass( "chair-free" ).addClass( "chair-taken disabled" );
                                        alert('La silla seleccionada fue reserva ya, intentalo de nuevo con otra.');
                                    }
                                }else{
                                    $("#chair_"+id).removeClass( "chair-free" ).addClass( "chair-taken disabled" );
                                    alert('La silla seleccionada fue reserva ya, intentalo de nuevo con otra.');
                                }
                            }
                        },
                        error : function(request, error) {
                            if (arguments[2] == "Unauthorized") {
                                window.location="{{URL::to('login')}}";
                            }
                            resetPreloader();
                        },
                    }).done(function() {
                    });
                }else{                    
                    alert('Ya se han seleccionado los asientos para el número de personas requerido, por favor registra tu reserva.');
                }
            }
        }

        function setChairs(){
            var chairs;
            $.ajax({
                method  : 'GET',
                url     : "{{ url('get-chairs') }}",
                success : function(data) {
                    data.forEach(function(chair){
                        $('#chair_'+chair.id).removeClass("chair-free chair-taken disabled chair-waiting my-chair");
                        $('#chair_'+chair.id).addClass(chair.reservation_id==null?'chair-free':(chair.reservation_id=="{{$reservation->id}}"?'my-chair':'chair-taken disabled'));
                    });
                },
                error : function(request, error) {
                    if (arguments[2] == "Unauthorized") {
                        window.location="{{URL::to('login')}}";
                    }
                    resetPreloader();
                },
            }).done(function() {
            });
            $("#selectedChairs").html("");
            $("#btn-sub").prop("disabled", true);
        }
    </script>
@endsection()
