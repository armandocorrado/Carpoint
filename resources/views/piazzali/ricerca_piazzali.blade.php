@extends('layouts.app')
@section('content')
<style>
    .open-modal {
        cursor: pointer;
    }
</style>

    <div class="ricercaPiazzali mt-2">
        <div class="d-flex justify-content-center">
            <div class="text-center" id="messaggio-attesa">
                <div class="text-center align-items-center" id="messaggio-attesa">
                    <div class="preloader"></div>
                </div>
            </div>
            <div class="card-deck d-md-flex justify-content-center">
                <div class="col-md-4 col-sm-12 mx-auto">
                    <div class="card mx-auto mb-3 cardGeneral cardRicerca" style=" max-width: 245px;">
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
                <div class="col-md-8 col-sm-12 mx-auto">
                    <div class="card mx-auto mb-3 cardGeneral cardRisultatiRicerca" id="contenitoreRicerca" style="width:553px;" >
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
                            <div class="d-flex flex-wrap container mt-2 mb-0 scrollable  "
                                style="background:white;padding:10px;" id="resultNU">
                                <!-- append contenuto   -->
                                <p id="testoVeicoloN" style='display:none;font-size:20px;'>Veicoli <strong style="color:rgb(12, 12, 164)"> NUOVI
                                    </strong>da inventariare</p>
                                    <p class=" chiudiN" style='display:none;background-color:rgb(174, 174, 174);margin-left: 29%;margin-top: 3%;font-weight: bolder;font-size: 13px;cursor: pointer;padding: 4px;color: black;border-radius: 5px;'>Chiudi</p>
                                <table id="tablePiazzaliRisult" style='display:none'>
                                    <thead>
                                        <tr>
                                            <th>Targa</th>
                                            <th>Telaio</th>
                                            <th>Marca</th>
                                            <th>Modello</th>
                                            <th>Info</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <p id="testoVeicoloU" style='display:none;font-size:20px;'>Veicoli<strong style="color:rgb(169, 180, 9)"; > USATO </strong>da
                                    inventariare</p>
                                    <p class="chiudiU" style='display:none;background-color:rgb(174, 174, 174);margin-left: 29%;margin-top: 3%;font-weight: bolder;font-size: 13px;cursor: pointer;padding: 4px;color: black;border-radius: 5px;'>Chiudi</p>
                                <table id="tablePiazzaliRisultU" style='display:none;font-size:13px;'>
                                    <thead>
                                        <tr>
                                            <th>Targa</th>
                                            <th>Telaio</th>
                                            <th>Marca</th>
                                            <th>Modello</th>
                                            <th>Info</th>
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
            <div class="modal-content" style="width: 85%;">
                <div class="modal-header" style="max-height: 58px;background:rgb(225, 225, 225)">
                    <h5 class="modal-title" id="dynamicModalLabel" style="font-size: 18px;position: relative;top: -54px;">Dettagli veicolo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 13px;">
                    Ciao
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-size: 13px;">Chiudi</button>
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
    var ubicazione = elemento.descrizione_ubicazioni || elemento.desc_ubicazione || ubicazione || 'N/A';
    var marca = elemento.descrizione_marca || elemento.marca || 'N/A';
    var modello = elemento.descrizione_modello || elemento.modello || 'N/A';
    var dataImma = elemento.data_immatricolazione ||  'N/A';
	var status = elemento.status ||  'N/A';
	var linea = elemento.linea ||  'N/A';
	var note = '';
    var data_fattura_v = elemento.data_fattura_v ||  'N/A';
    var data_contratto = elemento.data_contratto ||  'N/A';
    var data_arrivo = elemento.data_arrivo ||  'N/A';
 



    var riga = "<tr class='open-modal' " +
        "data-targa='" + elemento.targa + "' " +
        "data-telaio='" + telaio + "' " +
        "data-marca='" + marca + "' " +
        "data-modello='" + modello + "'" +
        "data-colore='" + colore + "' " +
        "data-immatricolazione='" + dataImma + "'" +
		"data-status='" + status + "'" +
		"data-linea='" + linea + "'" +
		"data-note='" + note + "'" +
        "data-fattura_v='" + data_fattura_v + "'" +
        "data-contratto='" + data_contratto + "'" +
        "data-arrivo='" + data_arrivo + "'" +
        "data-ubicazione='" + ubicazione + "'>"+
        "<td>" + elemento.targa + "</td>" +
        "<td>" + elemento.telaio + "</td>" +
        "<td>" + elemento.descrizione_marca + "</td>" +
        "<td>" + elemento.descrizione_modello + "</td>" +
       "<td>" + "<i class='fa fa-info-circle' style='font-size: 16px; color: gray; position: relative; left: 6px;'></i>" + "</td>" + 
        "</tr>";
    $('#tablePiazzaliRisult tbody').append(riga);
});

var tableUsato = $('#tablePiazzaliRisultU tbody');
tableUsato.empty();
$.each(response.veicoliUsatiDaInv, function (index, elemento) {

    var colore = elemento.colore || elemento.descr_colore || 'N/A';
    var telaio = elemento.telaio || elemento.vin || 'N/A';
    var ubicazione = elemento.descrizione_ubicazioni || elemento.desc_ubicazione || ubicazione || 'N/A';
    var marca = elemento.descrizione_marca || elemento.marca || 'N/A';
    var modello = elemento.descrizione_modello || elemento.modello || 'N/A';
    var dataImma = elemento.data_immatricolazione ||  'N/A';
	var status = elemento.status_veicolo ||  'N/A';
	var linea = elemento.linea ||  'N/A';
	var note = '';
    var data_fattura_v = elemento.data_fattura_v ||  'N/A';
    var data_contratto = elemento.data_contratto ||  'N/A';
    var data_arrivo = elemento.data_arrivo ||  'N/A';


    var riga = "<tr class='open-modal' " +
    "data-targa='" + elemento.targa + "' " +
        "data-telaio='" + telaio + "' " +
        "data-marca='" + marca + "' " +
        "data-modello='" + modello + "'" +
        "data-colore='" + colore + "'" +
        "data-immatricolazione='" + dataImma + "'" +
		"data-status='" + status + "'" +
		"data-linea='" + linea + "'" +
		"data-note='" + note + "'" +
        "data-fattura_v='" + data_fattura_v + "'" +
        "data-contratto='" + data_contratto + "'" +
        "data-arrivo='" + data_arrivo + "'" +
        "data-ubicazione='" + ubicazione + "'>"+
        "<td>" + elemento.targa + "</td>" +
        "<td>" + telaio + "</td>" +
        "<td>" + marca + "</td>" +
        "<td>" + modello + "</td>" +
        "<td>" + "<i class='fa fa-info-circle' style='font-size: 16px; color: gray; position: relative; left: 6px;'></i>" + "</td>" +
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
       
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

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
    var ubicazione = $(this).data('ubicazione');
    var dataImmatric = $(this).data('immatricolazione');
	var status = $(this).data('status'); 
	var linea = $(this).data('linea');
	var note = $(this).data('note');
    var data_fattura_v = $(this).data('fattura_v');
    var data_contratto = $(this).data('contratto');
    var data_arrivo = $(this).data('arrivo');

    if(data_arrivo != 'N/A'){
    var data_arrivo_america = data_arrivo; // Formato originale: YYYY-MM-DD 
    var data_arrivo_europe = moment(data_arrivo_america, "YYYY-MM-DD").format("DD/MM/YYYY") || 'NC';
    }else{
    
        var data_arrivo_europe = 'N/A';
    }

    if(data_contratto != 'N/A'){
    var data_contratto_america = data_contratto; // Formato originale: YYYY-MM-DD 
    var data_contratto_europe = moment(data_contratto_america, "YYYY-MM-DD").format("DD/MM/YYYY") ?? 'NC';
    }else{
        var data_contratto_europe = 'N/A';
    }

    if(data_fattura_v != 'N/A'){
    var data_fattura_america = data_fattura_v; // Formato originale: YYYY-MM-DD 
    var data_fattura_europe = moment(data_fattura_america, "YYYY-MM-DD").format("DD/MM/YYYY") ?? 'NC';
    }else{
        var data_fattura_europe = 'N/A';
    }


    switch (linea) {
                                case '00':
                                    linea = "Normale";
                                    break;
                                case '01':
                                    linea = "Km0";
                                    break;
                                case '02':
                                    linea = "Demo Visibility";
                                    break;
                                case '03':
                                    linea = "Demo cortesia";
                                    break;
                                case '04':
                                    linea = "FLEET";
                                    break;
                                case '05':
                                    linea = "FBP";
                                    break;
                                case '06':
                                    linea = "Trapasso";
                                    break;
                                case '07':
                                    linea = "Km0 altre marche";
                                    break;
                                case 'CE':
                                    linea = "Cespite";
                                    break;
                                case 'D3':
                                    linea = "DOC03";
                                    break;
                                case 'NV':
                                    linea = "Non vendibile";
                                    break;
                                default:
                                    linea = "Nessun valore";
                            }


                            //verifica la lettera status e passa la stringa corrispondente

                            switch (status) {

                            case 'A':
                                status = 'Stock'; 
                                break;
                            case 'C':
                                status = 'Virtuale';
                                break;
                            case 'R':
                                status = 'Richiesto'; 
                                break;
                            case 'T':
                                status = "Assegnato"; 
                                break;
                            case 'U':
                                status = "Uscito"; 
                                break;
                            case 'V':
                                status = "Venduto";
                                break;
                            case 'M':
                                status = "Manuale"; 
                                break;
                                
                                default:
                                status = "Stato sconosciuto";
                            }




// Aggiungi i dati al modal
$('#dynamicModal .modal-body').html(
    '<div class="container">' +
        '<div class="row">' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Targa:</strong>' +
                '<span style="display: block;">' + targa + '</span></p>' +
            '</div>' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Telaio:</strong>' +
                '<span style="display: block;">' + telaio + '</span></p>' +
            '</div>' +
        '</div>' +
        '<div class="row">' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Marca:</strong>' +
                '<span style="display: block;">' + marca + '</span></p>' +
            '</div>' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Modello:</strong>' +
                '<span style="display: block;">' + modello + '</span></p>' +
            '</div>' +
        '</div>' +
        '<div class="row">' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Colore:</strong>' +
                '<span style="display: block;">' + colore + '</span></p>' +
            '</div>' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Data arrivo:</strong>' +
                '<span style="display: block;">' + data_arrivo_europe + '</span></p>' +
            '</div>' +
        '</div>' +
        '<div class="row">' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Data vendita:</strong>' +
                '<span style="display: block;">' + data_fattura_europe + '</span></p>' +
            '</div>' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Data contratto:</strong>' +
                '<span style="display: block;">' + data_contratto_europe + '</span></p>' +
            '</div>' +
        '</div>' +
        '<div class="row">' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Ubicazione:</strong>' +
                '<span style="display: block;">' + ubicazione + '</span></p>' +
            '</div>' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Fornitore:</strong>' +
                '<span style="display: block;">' + "fornitore" + '</span></p>' +
            '</div>' +
        '</div>' +
        '<div class="row">' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Data Immatricolazione:</strong>' +
                '<span style="display: block;">' + dataImmatric + '</span></p>' +
            '</div>' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Status:</strong>' +
                '<span style="display: block;">' + status + '</span></p>' +
            '</div>' +
        '</div>' +
        '<div class="row">' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Linea:</strong>' +
                '<span style="display: block;">' + linea + '</span></p>' +
            '</div>' +
            '<div class="col-md-6">' +
                '<p><strong style="display: block;">Note veicolo:</strong>' +
                '<span style="display: block;">' + note + '</span></p>' +
            '</div>' +
        '</div>' +
    '</div>'
);



    jQuery('#dynamicModal').modal('show');
});




      </script>
@endsection
