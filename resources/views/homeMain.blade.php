@extends('layouts.app')
@section('content')

@if (Session::get('status'))
<div class="justify-content-center mt-5">
    <div class="alert alert-success alert-dismissible text-blue mx-auto" role="alert" >
        <span class="text-sm">{{ Session::get('status') }} </span>
        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

<div class="d-flex justify-content-center">


    <div class="mt-5 ">

          
            <div class="card-deck d-md-flex justify-content-center" data-aos="fade" data-aos-duration="2000">
                <div class="col-md-12 col-sm-12 mx-auto">
                    <div class="card mb-3 cardGeneral cardRicerca">
                        <div class="card-header text-header text-center">
                            <h5><strong>Ricerca stock</strong></h5>
                            <img src="{{asset('img/logoCarPoint.png')}}" alt="Pratiche" width="50%" class="mt-3 mx-auto">
                        </div>
                        <div class="card-body text-primary">
                         
                              
                                <a href="{{ route('search.veicoli') }}" type="button" style="text-decoration:none; color:white; line-height: 39px;" class="btn btn-hover color-1 btnSearch d-block mt-4 mb-2" id="cerca">RICERCA VEICOLI</a>
                                <a href="{{ route('piazzali') }}" type="button" style="text-decoration:none; color:white; line-height: 39px;" class="btn btn-hover color-3 d-block mt-4 mb-2" id="cercaPiazzali">PIAZZALI</a>   
                                <a href="{{ route('new-veicolo') }}" type="button" style="text-decoration:none; color:white; line-height: 39px;" class="btn btn-hover color-2 d-block mt-4 mb-2" >AGGIUNGI VEICOLO</a>
								
                           
                                @role('Admin')
                                    <!-- Pulsante per aprire il modal -->
                                    <button type="button" style="text-decoration:none; color:white; line-height: 42px;" 
                                        class="btn btn-hover color-5 d-block mt-4 mb-2 svuota-db" 
                                        data-bs-toggle="modal" data-bs-target="#passwordModal">
                                        SVUOTA INVENTARIO
                                    </button>

                                    <!-- Modal Bootstrap -->
                                    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="passwordModalLabel">Conferma Azione</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Per confermare, inserisci la password segreta:</p>
                                                    <form id="confirmForm" action="{{ route('destroy-trovata.all') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <input type="password" name="secret_password" class="form-control" id="secretPassword" 
                                                                placeholder="Password segreta" required>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                                    <button type="submit" form="confirmForm" class="btn btn-danger">Conferma</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endrole


                                @role('Admin')
                                <!-- Pulsante per aprire il modal -->
                                <button type="button" style="text-decoration:none; color:white; line-height: 42px;" 
                                    class="btn btn-hover color-5 d-block mt-4 mb-2 svuota-veicoli-manuali" 
                                    data-bs-toggle="modal" data-bs-target="#passwordVeicoliModal">
                                    SVUOTA VEICOLI MANUALI
                                </button>
                            
                                <!-- Modal Bootstrap -->
                                <div class="modal fade" id="passwordVeicoliModal" tabindex="-1" aria-labelledby="passwordVeicoliModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="passwordVeicoliModalLabel">Conferma Azione</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Per confermare, inserisci la password segreta:</p>
                                                <form id="confirmVeicoliForm" action="{{ route('destroy-veicolo') }}" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <input type="password" name="secret_password" class="form-control" id="secretPasswordVeicoli" 
                                                            placeholder="Password segreta" required>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                                <button type="submit" form="confirmVeicoliForm" class="btn btn-danger">Conferma</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endrole
                            

                                <p class="text-center textFooterCard">Sofware sviluppato da Softmind S.r.l.</p>
                           
                        </div>
                    </div>
                </div>
             
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
    // Intercetta il click sul pulsante con classe svuota-db
    $('.svuota-db').on('click', function (event) {
        event.preventDefault(); // Previene l'invio immediato del form
        if (confirm("Sei sicuro di voler svuotare l'inventario?")) {
            $(this).closest('form').submit(); // Invia il form solo se confermato
        }
    });

    // Intercetta il click sul pulsante con classe svuota-veicoli-manuali
    $('.svuota-veicoli-manuali').on('click', function (event) {
        event.preventDefault(); // Previene l'invio immediato del form
        if (confirm("Sei sicuro di voler svuotare i veicoli manuali?")) {
            $(this).closest('form').submit(); // Invia il form solo se confermato
        }
    });
});

        </script>


        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
            integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
        </script>
        <script>
// Ottieni il riferimento all'elemento che contiene l'immagine di caricamento
var loader = $('#messaggio-attesa');
// Nascondi l'immagine di caricamento all'inizio

        </script>





    @endsection


<!--ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;-->
