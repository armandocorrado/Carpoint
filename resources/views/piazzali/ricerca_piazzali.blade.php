@extends('layouts.app')
@section('content')

    <div class="ricercaPiazzali mt-2">
        <div class="d-flex justify-content-center">
            <div class="text-center" id="messaggio-attesa">
                <div class="text-center align-items-center" id="messaggio-attesa">
                    <div class="preloader"></div>
                </div>
            </div>
            <div class="card-deck d-md-flex justify-content-center">
                <div class="col-md-6 col-sm-12 mx-auto">
                    <div class="card mx-auto mb-3 cardGeneral cardRicerca">
                        <div class="card-header text-header text-center mt-3">
                            <h5 class="d-inline mt-5">Ricerca piazzali</h5>
                            <img src="{{ asset('img/logoCarPoint.png') }}" alt="Logo" width="50%" class="mt-3 mx-auto">
                        </div>
                        <div class="card-body text-primary">
                            <form>
                                <div class="form-group">
                                    <select multiple placeholder="Scegli piazzale" name="ubicazioni[]" id="selectPiazzale"
                                        data-allow-clear="1">
                                        @foreach ($piazzali as $p)
                                            <option value="{{ $p }}">{{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-4">
                                    <select multiple placeholder="Scegli status nuovo" name="status_n[]"
                                        id="selectStatusNuovo" data-allow-clear="1">
                                        <option value="A">Stock</option>
                                        <option value="C">Virtuale</option>
                                        <option value="T">Assegnato</option>
                                        <option value="U">Uscito</option>
                                        <option value="V">Venduto</option>
                                    </select>
                                </div>
                                <div class="form-group mt-4 mb-3">
                                    <select multiple placeholder="Scegli status usato" name="status_u[]"
                                        id="selectStatusUsato" data-allow-clear="1">
                                        <option value="U">Uscito</option>
                                        <option value="A">Stock</option>
                                        <option value="S">Venduto</option>
                                    </select>
                                </div>
                                <button class="btn btn-hover color-3 d-block mt-4 mb-2" id="searchPiazzali"
                                    type="submit">CERCA</button>
                                <a href="{{ route('home_') }}" type="button"
                                    style="text-decoration:none; color:white; line-height: 39px;"
                                    class="btn btn-hover color-2 btnSearch d-block mt-3 mb-2" id="home">TORNA ALLA
                                    HOME</a>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mx-auto">
                    <div class="card mx-auto mb-3 cardGeneral cardRisultatiRicerca" id="contenitoreRicerca" >
                        <h3 class="mb-3 mt-4 text-center qui">Risultati ricerca</h3>
                        <p class="text-center qui">Qui appariranno i risultati della tua ricerca</p>
                        {{-- <div class="card-header text-header text-center mt-4 mb-3">
                            <span id="modello">
                                <!--     contenuto append  titolo      -->
                            </span>
                            <div class="d-flex justify-content-between container mt-2 mb-0 " id="piazzale">
                                <!--     contenuto append  intestazione      -->
                            </div>
                        </div> --}}
                        <div id="noresult">
                            <!-- append -->
                        </div>
                        <div class="card-body text-primary">
                            <div class="d-flex flex-wrap justify-content-center container mt-2 mb-0 " id="tablePiazzali" style="background:white;padding:10px;">
                                <!-- append contenuto   -->

                            </div>
                            <div class="d-flex flex-wrap justify-content-center container mt-2 mb-0 scrollable  "
                                style="background:white;padding:10px;" id="resultNU">
                                <!-- append contenuto   -->
                                <p id="testoVeicoloN" style='display:none;font-size:20px;'>Veicoli <strong style="color:rgb(12, 12, 164)"> NUOVI
                                    </strong>da inventariare</p>
                                    <p class=" chiudiN" style='display:none;color:black;margin-left: 29%;margin-top: 3%;font-weight: bolder;font-size: 13px;cursor: pointer;'>Chiudi</p>
                                <table id="tablePiazzaliRisult" style='display:none'>
                                    <thead>
                                        <tr>
                                            <th>Targa</th>
                                            <th>Telaio</th>
                                            <th>Marca</th>
                                            <th>Modello</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <p id="testoVeicoloU" style='display:none;font-size:20px;'>Veicoli<strong style="color:rgb(169, 180, 9)"; > USATO </strong>da
                                    inventariare</p>
                                    <p class="chiudiU" style='display:none;color:black;margin-left: 29%;margin-top: 3%;font-weight: bolder;font-size: 13px;cursor: pointer;'>Chiudi</p>
                                <table id="tablePiazzaliRisultU" style='display:none'>
                                    <thead>
                                        <tr>
                                            <th>Targa</th>
                                            <th>Telaio</th>
                                            <th>Marca</th>
                                            <th>Modello</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dynamicModal" tabindex="-1" role="dialog" aria-labelledby="dynamicModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="max-height: 58px;background:rgb(225, 225, 225)">
                    <h5 class="modal-title" id="dynamicModalLabel" style="font-size: 18px;position: relative;top: -54px;">Dettagli veicolo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Ciao
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
    

    <script>
        // Ottieni il riferimento all'elemento che contiene l'immagine di caricamento
        var loader = $('#messaggio-attesa');
        // Nascondi l'immagine di caricamento all'inizio
        loader.hide();



        $(document).ready(function() {
            $('#searchPiazzali').click(function(e) {
                e.preventDefault();

                var piazzali = $('#selectPiazzale').val();
                var status_n = $('#selectStatusNuovo').val();
                var status_u = $('#selectStatusUsato').val();
                // Verifica se entrambe le variabili sono vuote
                if (piazzali == 0 || status_n == 0 || status_u == 0) {
                    alert("Devono essere riempiempiti tutti e tre i campi");
                    return;
                }

                loader.show();
                var j = jQuery.noConflict();


                $.ajax({
                    url: '{{ route('piazzali.store') }}',
                    type: "GET",
                    dataType: "json",
                    data: {
                        // '_token': '{{ csrf_token() }}',
                        'ubicazioni': piazzali,
                        'status_n': status_n,
                        'status_u': status_u,
                    },


                    success: function(response) {

                        loader.hide();
                        $('.qui').hide();


                        var tableBody = $('#tablePiazzali');
                        tableBody.empty();


                        $('#tablePiazzali').append(
                            "<table><thead><tr><th class='gray'>Condizione</th><th class='gray'>Stock</th><th class='gray'>Inventariato</th><th class='gray'>Da inventariare</th></tr></thead><tbody>" +
                            "<tr>" +
                            "<th class='white'>" + 'NUOVO' + "</th><td>" + response.nNuoviTot +
                            "</td><td>" + response.nNuoviTrovatiTot +
                            "</td><td id='cont1' class='clicco'>" + response.nNuoviDaInTot +
                            "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<th style='color:rgb(169, 180, 9)'>" + 'USATI' + "</th><td>" + response.nUsatiTot +
                            "</td><td>" + response.nUsatiTrovatiTot +
                            "</td><td id='cont2' class='clicco'>" + response.nUsatiDaInTot +
                            "</td>" +
                            "</tr>" +
                            "</tbody></table>");

                        
                        $('#cont1').click(function() {
                            
                            $('#tablePiazzaliRisult').show();
                            $('#tablePiazzaliRisultU').hide();
                            $('#testoVeicoloN').show();
                            $('#testoVeicoloU').hide();
                            $('.chiudiU').hide();
                            $('.chiudiN').show();
                            


                        });

                        $('#cont2').click(function() {
                            
                            $('#tablePiazzaliRisultU').show();
                            $('#tablePiazzaliRisult').hide();
                            $('#testoVeicoloU').show();
                            $('#testoVeicoloN').hide();
                            $('.chiudiN').hide();
                            $('.chiudiU').show();


                        });

                        $('.chiudiN').click(function() {
                            $('#tablePiazzaliRisultU').hide();
                            $('#tablePiazzaliRisult').hide();
                            $('.chiudiN').hide();
                            $('#testoVeicoloN').hide();
                            $('#testoVeicoloU').hide();
                        });

                        $('.chiudiU').click(function() {
                            $('#tablePiazzaliRisultU').hide();
                            $('#tablePiazzaliRisult').hide();
                            $('.chiudiU').hide();
                            $('#testoVeicoloN').hide();
                            $('#testoVeicoloU').hide();
                        });



                              
                        var tableNuovo = $('#tablePiazzaliRisult tbody');
tableNuovo.empty();

$.each(response.veicoliNuoviDaInv, function (index, elemento) {

    var colore = elemento.colore || elemento.descr_colore || 'N/A';
    var telaio = elemento.telaio || elemento.vin || 'N/A';
    var interni = elemento.descr_int || elemento.colint || 'N/A';
    var alimentazione = elemento.alimentazione || 'N/A';  
    var kw = elemento.potenzakw || elemento.kw || 'N/A';
    var kmpercorsi = elemento.km_percorsi ||  'N/A';
    var ubicazione = elemento.descrizione_ubicazioni || elemento.desc_ubicazione || ubicazione || 'N/A';
    var marca = elemento.descrizione_marca || elemento.marca || 'N/A';
    var modello = elemento.descrizione_modello || elemento.modello || 'N/A';


    var riga = "<tr class='open-modal' " +
        "data-targa='" + elemento.targa + "' " +
        "data-telaio='" + telaio + "' " +
        "data-marca='" + marca + "' " +
        "data-modello='" + modello + "'" +
        "data-colore='" + colore + "' " +
        "data-interni='" + interni + "'" +
        "data-alimentazione='" + alimentazione + "'" +
        "data-kw='" + kw + "'" +
        "data-kmpercorsi='" + kmpercorsi + "'" +
        "data-ubicazione='" + ubicazione + "'>"+
    
        "<td>" + elemento.targa + "</td>" +
        "<td>" + telaio + "</td>" +
        "<td>" + marca + "</td>" +
        "<td>" + modello + "</td>" +
        "</tr>";
    $('#tablePiazzaliRisult tbody').append(riga);
});

var tableUsato = $('#tablePiazzaliRisultU tbody');
tableUsato.empty();

$.each(response.veicoliUsatiDaInv, function (index, elemento) {

    var colore = elemento.colore || elemento.descr_colore || 'N/A';
    var telaio = elemento.telaio || elemento.vin || 'N/A';
    var interni = elemento.descr_int || elemento.colint || 'N/A';
    var alimentazione = elemento.alimentazione || 'N/A';  
    var kw = elemento.potenzakw || elemento.kw || 'N/A';
    var kmpercorsi = elemento.km_percorsi ||  'N/A';
    var ubicazione = elemento.descrizione_ubicazioni || elemento.desc_ubicazione || ubicazione || 'N/A';
    var marca = elemento.desrizione_marca || elemento.marca || 'N/A';
    var modello = elemento.descrizione_modello || elemento.modello || 'N/A';

    var riga = "<tr class='open-modal' " +
    "data-targa='" + elemento.targa + "' " +
        "data-telaio='" + telaio + "' " +
        "data-marca='" + marca + "' " +
        "data-modello='" + modello + "'>" +
        "data-colore='" + colore + "'>" +
        "data-interni='" + interni + "'>" +
        "data-alimentazione='" + alimentazione + "'>" +
        "data-kw='" + kw + "'>" +
        "data-kmpercorsi='" + kmpercorsi + "'>" +
        "data-ubicazione='" + ubicazione + "'>"+
        "<td>" + targa + "</td>" +
        "<td>" + telaio + "</td>" +
        "<td>" + marca + "</td>" +
        "<td>" + modello + "</td>" +
        "</tr>";
    $('#tablePiazzaliRisultU tbody').append(riga);
});

                        $('#tablePiazzali').after(
                            "<div id='usatoDaInv' style='display:none'><table><thead><tr><th>Targa1</th><th>Telaio</th><th>Marca</th><th>Modello</th></tr></thead><tbody><tr><td>Dato 1</td><td>Dato 2</td><td>Dato 3</td><td>Dato 4</td></tr></tbody></table></div>"
                            );


                    }


                    // In caso di no response

                }).fail(function() {
                    var noResult = $('#noresult');
                    noResult.empty();
                    var tableBody = $('#tablePiazzali');
                    tableBody.empty();

                    $('#noresult').append(
                        "<h5>" + 'Nessun risultato' + "</h5>"
                    );


                    loader.hide();
                });
            });
        });





    </script>
       
     
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        AOS.init();
      </script>

      <script>
$(document).on('click', '.open-modal', function () {
    // Estrai i dati dal `data-*` attribute della riga cliccata
    var targa = $(this).data('targa');
    var telaio = $(this).data('telaio');
    var marca = $(this).data('marca');
    var modello = $(this).data('modello');
    var colore = $(this).data('colore');
    var interni = $(this).data('interni');
    var alimentazione = $(this).data('alimentazione');
    var kw = $(this).data('kw');
    var kmpercorsi = $(this).data('kmpercorsi');
    var ubicazione = $(this).data('ubicazione');

   
    // Aggiungi i dati al modal
    $('#dynamicModal .modal-body').html(
        '<p><strong>Targa:</strong> ' + targa + '</p>' +
        '<p><strong>Telaio:</strong> ' + telaio + '</p>' +
        '<p><strong>Marca:</strong> ' + marca + '</p>' +
        '<p><strong>Modello:</strong> ' + modello + '</p>'+
        '<p><strong>Colore:</strong> ' + colore + '</p>'+
        '<p><strong>Interni:</strong> ' + interni + '</p>'+
        '<p><strong>Alimentazione:</strong> ' + alimentazione + '</p>'+
        '<p><strong>Kw:</strong> ' + kw + '</p>'+
        '<p><strong>Ubicazione:</strong> ' + ubicazione + '</p>'+
        '<p><strong>AlimentaziKm percorsione:</strong> ' + kmpercorsi + '</p>'



    );
    jQuery('#dynamicModal').modal('show');
});




      </script>
@endsection
