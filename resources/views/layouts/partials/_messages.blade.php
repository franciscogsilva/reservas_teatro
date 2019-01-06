                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        <ul class="list-oddis">
                            @foreach ($errors->all() as $error)
                            <li>
                                <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i>{{ $error }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('session_msg') )
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        <i class="fe fe-check mr-2" aria-hidden="true"></i> {{ session('session_msg') }}
                    </div>
                @endif            
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        <i class="fe fe-check mr-2" aria-hidden="true"></i> {{ session('status') }}
                    </div>
                @endif
                @if(request()->has('session_msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        <i class="fe fe-check mr-2" aria-hidden="true"></i> {{ request()->input('session_msg') }}
                    </div>
                @endif 