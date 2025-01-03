@extends('layouts.app')
@section('content')
    <div class="utentiVeicoli row mt-5">
		@role('Admin')
     
        @if (Session::get('status'))
        <div class="alert alert-success alert-dismissible text-blue" role="alert">
            <span class="text-sm">{{ Session::get('status') }} </span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<style>
 .table  td{
       padding: 2px 9px;
    border: 1px solid #cfcfcf;
    }

    .fa-solid, .fas {
    font-weight: 900;
    font-size: 13px;
    
}
</style>

        <div class="card-deck d-md-flex justify-content-center ">
            <div class="col-md-6 col-sm-12 mx-auto">
                <div class="card mx-auto mb-3 cardGeneral cardRicerca" style="width: 760px;" data-aos="fade"
                    data-aos-duration="2500">
                    <div class="card-header text-header text-center" style="height:53px;background-color: #d9dfe2;">
                        <h4 class="mx-auto">Lista utenti</h4> 
                           {{-- <img src="{{ asset('img/logoCarPoint.png') }}" alt="Logo" width="10%" class="mt-3"> --}}
                                     <!-- Button trigger modal -->
                                   <button type="button" class="btn btn-light float-right ml-2" style="margin-top: -38px;
    border-radius: 30px;
    background-color: #f8f9fa5e;
    border-color: #f8f9fa;
    font-size: 13px;
    margin-right: 119px;
}" data-bs-toggle="modal" data-bs-target="#creaUtente">
                                        <i class="fa-solid fa-user" style="font-size:13px"></i>   Crea utente
                                      </button>
 <button type="button" class="btn btn-light float-right" style="margin-top: -38px;border-radius:30px;background-color: #f8f9fa5e;border-color:#f8f9fa;font-size:13px;" data-bs-toggle="modal" data-bs-target="#creaRuolo">
   <i class="fa fa-address-book" aria-hidden="true" style="font-size:13px"></i>
Crea ruolo
 </button>

                       </div>

                    <div class="card-body text-primary mt-0 ">


                        <div class="table-reponsive box" style="margin-top: 0%;font-size: 13px;">
                            <table id="utentiTable" class="table table-striped table-bordered">
                                <thead class="mx-auto">
                                    <tr>
                                        <th>User</th>
                                        <th>Ruolo</th>
                                        <th>Ubicazione</th>
                                        <th style="
                                        max-width: 44px;
                                    ">Modifica </th>
                                       <th style="
                                       max-width: 44px;
                                   ">Elimina </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)  
                                        <tr> 
                                            <td>{{ $user->username ?? '' }}</td>
                                            <td>{{ $user['roles'][0]['name'] ?? '' }}</td>
                                            <td>{{ $user->ubicazione ?? '' }}</td>
                                            <td style="text-align: center;">
												<button style="background: none;color: gray;border:none;padding: 0px;" type="button" class="btn btn-success b" data-bs-toggle="modal"
                                                 data-id={{ $user->id }} 
                                                 data-username="{{$user->username}}" 
                                                 data-ubicazione="{{$user->ubicazione}}" 
                                                 data-password="{{$user->password}}"
                                                 data-ruolo="{{ $user['roles'][0]['name'] }}"
                                        
                                                    data-bs-target="#editUtente" id="b">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button style="background: none;color: gray;border:none;padding: 0px;" type="button" class="btn btn-success b updatePassword" data-bs-toggle="modal"
                                                 data-id={{ $user->id }} 
                                                 data-bs-target="#editPass" id="b">
                                                 <i class="fa-solid fa-key" style="position: relative;left: 8px;"></i>
                                                </button>
                                            </td>
                                            <td style="text-align: center;">
                                                <form action="{{route('user.delete', $user->id)}}" method="post"> @csrf
                                            <button type="submit" class="btn btn-danger" style="background: none;color: gray;border:none;padding: 0px;">
                                                <i class="fa-sharp fa-solid fa-trash"></i>
                                            </button>  
                                        </form>
                                    </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>



    <!-- Modal crea utente -->
    <div class="modal fade" id="creaUtente" tabindex="-1" aria-labelledby="creaUtente" aria-hidden="true">
        <div class="modal-dialog" style="
    max-width: 20%;
">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="
                    margin-top: -10px;
                    font-size: 20px;
                ">Crea Utente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="container" action="{{ route('user.store') }}" method="post">@csrf
                        <input type="hidden" value="{{$url}}" id="url">
                      
                        <div class="col-xs-4">
                            <div class="field" data-validate="Inserire User">
                                <label>User</label>
                                <input type="text" name="username" ><br>
                                
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="field mb-0" data-validate="Inserire password">
                                <label>Password</label>
                                <input type="password" name="password" id="rolePassword" value=""><br>
                               
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="field" data-validate="Inserire ubicazione">
                                <label>Ubicazione</label>
                                <input type="text" name="ubicazione" id="roleUbicazione" value=""><br>
                               
                            </div>
                        </div>
                        <br>
                        <div class="col-xs-4" style="margin-top: -20px;">
                            <label>Ruolo</label>
                            <select class="form-select form-select-lg mb-3" name="ruolo" style="font-size:15px;padding-left: 5px;">
                                <option>Scegli ruolo</option>
                                @foreach ($ruoli as $ruolo)
                                    <option value="{{ $ruolo->name }}">{{ $ruolo->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button style="text-decoration:none; color:white; line-height: 39px;"
                            class="btn btn-hover color-2 btnSearch d-block mt-5 mb-2" type="submit">SALVA</button>

                    </form>
                </div>

            </div>
        </div>
    </div>



    



          
        </div>





    <!-- Modal edit utente -->
    <div class="modal fade" id="editUtente" tabindex="-1" aria-labelledby="editUtente" aria-hidden="true">
        <div class="modal-dialog" style="
        max-width: 20%;
    ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="
                    margin-top: -10px;
                    font-size: 20px;
                " id="exampleModalLabel">Modifica dati Utente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="container" id="formEdit"  method="post">@csrf

                    
                        <div class="col-xs-4">
                            <div class="field" data-validate="Inserire Email">
                                <label>User</label>
                                <input type="text" name="username" id="userEdit" value=""><br>
                               
                            </div>
                        </div>
                        
                        <div class="col-xs-4">
                            <div class="field" data-validate="Inserire ubicazione">
                                <label>Ubicazione</label>
                                <input type="text" name="ubicazione" id="ubicazioneEdit"><br>
                                
                            </div>
                        </div>
                        <br>
                        <div class="col-xs-4" style="margin-top: -20px;">
                            <label>Ruolo</label>
                            <select class="form-select form-select-lg mb-3" name="ruolo" id="ruoloEdit" style="font-size:15px;padding-left: 5px;">
                                <option value=""></option>
                                @foreach ($ruoli as $ruolo)
                                    <option value="{{ $ruolo->name }}">{{ $ruolo->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button style="text-decoration:none; color:white; line-height: 39px;"
                            class="btn btn-hover color-2 btnSearch btnSearchPass d-block mt-5 mb-2" type="submit">AGGIORNA</button>

                    </form>
                </div>

            </div>
        </div>
    </div>



<!-- Modal edit password -->
<div class="modal fade" id="editPass" tabindex="-1" aria-labelledby="editUtente" aria-hidden="true">
    <div class="modal-dialog" style="
    max-width: 20%;
">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="
                margin-top: -10px;
                font-size: 20px;
            " id="exampleModalLabel">Modifica password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="container formPassw" action="" id="formEdit"  method="post">@csrf

                    <div class="col-xs-4">
                        <div class="field mb-0" data-validate="Inserire password">
                            <label>Password</label>
                            <input type="password" name="password" id="rolePassword" value="" required><br>
                          
                        </div>
                    </div>
                      
                    <button style="text-decoration:none; color:white; line-height: 39px;"
                        class="btn btn-hover color-2 btnSearch btnSearchPass d-block mt-5 mb-2" type="submit">AGGIORNA</button>

                </form>
            </div>

        </div>
    </div>
</div>


    

    <!-- Modal crea ruolo -->
    <div class="modal fade" id="creaRuolo" tabindex="-1" aria-labelledby="creaRuolo" aria-hidden="true">
        <div class="modal-dialog" style="
    max-width: 20%;
">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="
                    margin-top: -10px;
                    font-size: 20px;
                " id="exampleModalLabel">Crea ruolo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span style="margin-left:19px">Esistenti:
                        @foreach ($ruoli as $ruolo)
                    </span><span class="badge text-bg-primary">{{ $ruolo->name }}</span>
                    @endforeach
                    <form class="container" action="{{ route('ruoli.store') }}" method="post">@csrf

                        <div class="col-xs-4 mt-3">
                            <div class="field" data-validate="Inserire nome ruolo">
                                <label>Crea ruolo</label>
                                <input type="text" name="nameCreaRuolo" id="nameCreaRuolo" value=""><br>
                                
                            </div>
                        </div>


                        <button type="submit" style="text-decoration:none; color:white; line-height: 39px;"
                            class="btn btn-hover color-2 btnSearch  d-block mt-3 mb-2">SALVA</button>

                    </form>
                </div>

            </div>
        </div>
    </div>

@else

<div class="card-deck d-md-flex justify-content-center ">
    <h1 class="h1">Non hai i permessi necessari</h1>
    </div>


@endrole


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
    </script>


    {{-- <script>$(document).ready(function() {
            $('#utentiTable').DataTable();
        } );</script> --}}

    <script>
        AOS.init();
    </script>


            <script>


            $('.b').on('click', function() {

            var id = $(this).data("id");
            
            var username = $(this).data("username"); 
            var ubicazione = $(this).data("ubicazione"); 
            var password = $(this).data("password"); 
            var ruolo = $(this).data("ruolo"); 
         
            $('#userEdit').val(username);
            $('#ubicazioneEdit').val(ubicazione);
            $('#rolePassword').val(password);
            
            $('#ruoloEdit').val(ruolo).change(); 





            var url = $('#url').val()+'/utenti/update/';

            $('#formEdit').attr('action', url+id);
     
        

            });


            </script>

            <script>

$('.updatePassword').click(function(){


    var origin = window.location.origin;

    var id = $(this).data("id");

    $('.formPassw').attr('action', origin+'/utenti/password/update/'+id);





});



            </script>


@endsection


