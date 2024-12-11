@extends('layouts.app')
@section('content')
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
                            <form class="container">
                              
                                <a href="{{ route('search.veicoli') }}" type="button" style="text-decoration:none; color:white; line-height: 39px;" class="btn btn-hover color-1 btnSearch d-block mt-4 mb-2" id="cerca">RICERCA VEICOLI</a>
                                <a href="{{ route('piazzali') }}" type="button" style="text-decoration:none; color:white; line-height: 39px;" class="btn btn-hover color-3 d-block mt-4 mb-2" id="cercaPiazzali">PIAZZALI</a>   
                                <a href="{{ route('new-veicolo') }}" type="button" style="text-decoration:none; color:white; line-height: 39px;" class="btn btn-hover color-2 d-block mt-4 mb-2" >AGGIUNGI VEICOLO</a>
								<a href="" type="button" style="text-decoration:none; color:white; line-height: 42px;" class="btn btn-hover color-5 d-block mt-4 mb-2" >SVUOTA INVENTARIO</a>
                                
                                <p class="text-center textFooterCard">Sofware sviluppato da Softmind S.r.l.</p>
                            </form>
                        </div>
                    </div>
                </div>
             
                </div>
            </div>
        </div>
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
