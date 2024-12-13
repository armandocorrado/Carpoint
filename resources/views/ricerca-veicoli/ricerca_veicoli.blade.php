@extends('layouts.app')
@section('content')

<style>
    #preloaderocr {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        /* Sfondo semi-trasparente */
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        /* Sopra tutto */
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 6px solid #ccc;
        border-top-color: #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>


<div class="ricercaVeicoli mt-5">


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

    <div class="d-flex justify-content-center">
        <div class="text-center align-items-center" id="messaggio-attesa">
            <div class="preloader"></div>
        </div>


        <div class="card-deck d-md-flex justify-content-center ">
            <div class="col-md-6 col-sm-12 mx-auto">
                <div class="card mx-auto mb-3 cardGeneral cardRicerca" data-aos="fade" data-aos-duration="2500">
                    <div class="card-header text-header text-center  justify-content-center mt-3 ">
                        <h5 class="d-inline mt-2">Ricerca veicoli</h5>
                        <img src="{{ asset('img/logoCarPoint.png') }}" alt="Logo" width="50%" class="mt-3 mx-auto">

                    </div>




                    {{-- Geolocalizzazione--}}

                    <input hidden id="latitude" value="">
                    <input hidden id="longitude" value="">


                    <script>
                        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    $("#latitude").val(latitude);
                    $("#longitude").val(longitude);
                       
                    
                },
                (error) => {
                    console.error("Errore nella geolocalizzazione:", error);
                    alert("Impossibile ottenere la posizione. Controlla le impostazioni del GPS.");
                }
            );
        } else {
            alert("La geolocalizzazione non è supportata su questo dispositivo.");
        }

      

                    </script>

                    <!-- fine -->



                    <!--  PlateRecognizer -->


                    <video id="video" hidden autoplay></video>
                    <button id="capture" style="text-decoration: none;
    color: white;
    line-height: 39px;
    width: 80%;
    margin: auto;" class="btn btn-hover color-6 mt-4 mb-2" hidden>Cattura Immagine</button>
                    <canvas id="canvas" style="display: none;"></canvas>
                    <img id="capturedImage" hidden alt="Immagine catturata" />


                    <div id="preloaderocr" hidden>
                        <div class="spinner"></div>
                    </div>




                    <script>
                        $(document).ready(function () {

    const video = $('#video')[0]; // Seleziona il video usando jQuery
    const canvas = $('#canvas')[0]; // Seleziona il canvas usando jQuery
    const capturedImage = $('#capturedImage'); // Seleziona l'immagine catturata
    const captureButton = $('#capture'); // Seleziona il pulsante di cattura


    $('#ocrButton').click(function () {

    // Start webcam
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {

            video.srcObject = stream;
            $('#video').removeAttr('hidden');
            $('#capture').removeAttr('hidden');
            $('#ocrButton').css('display', 'none');

        })
        .catch((err) => {
            console.error("Errore nell'accesso alla webcam:", err);
        });

    });

    // Cattura immagine
    captureButton.on('click', function () {

        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        $('#preloaderocr').removeAttr('hidden');
     

        // Ottieni immagine in base64
        const imageData = canvas.toDataURL('image/jpeg');

        // Mostra immagine catturata
        capturedImage.attr('src', imageData);

        // Invia immagine al server
        $.ajax({
            url: '/recognize-plate',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: JSON.stringify({ image: imageData }),

            success: function (response) {

                $('#preloaderocr').attr('hidden', 'hidden');

                const plate = (response.results[0].plate || "").toUpperCase();
                $('#targa').val(plate).css('color', 'red');

            },
            error: function (xhr, status, error) {
                console.error("Errore nella richiesta:", error);
                $('#preloaderocr').attr('hidden', 'hidden');
            }

            
        });
    });
});



                    </script>

                    <div class="card-body text-primary mt-0 ">
                        <form class="container" style="margin-top: -5px;">

                            <label class="text-secondary" style="margin-bottom: 0.2rem;">Targa</label>
                            <div class="input-group mb-3">

                                <input name="targa" id="targa" value="{{ Session::get('targa') }}" type=""
                                    class="form-control" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-success" id="ocrButton" type="button">Attiva<i
                                            class="material-icons" style="
                                        font-size: 16px;
                                        position: relative;
                                        top: 3px;
                                        left: 5px;
                                    ">camera_alt</i>


                                    </button>
                                </div>
                            </div>

                            {{-- <div class="col-xs-4">
                                <div class="field" data-validate="Inserire targa completa">
                                    <label class="text-secondary" style="margin-bottom: 0.2rem;"> Targa</label>
                                    <input type="" name="targa" id="targa" value="{{ Session::get('targa') }}"
                                        maxlength="7" style="max-width:50%"><br>
                                </div>
                            </div> --}}

                            <div class="col-xs-4">
                                <div class="field" data-validate="Da 7 a 17 caratteri">
                                    <label class="text-secondary" style="margin-bottom: 0.2rem;">Numero telaio</label>
                                    <input type="" name="telaio" id="numTelaio" value="{{ Session::get('telaio') }}"
                                        maxlength="17"><br>
                                </div>
                            </div>
                            <button class="btn btn-hover color-1 btnSearch d-block mt-3 mb-2" id="cerca">CERCA</button>
                            <a href="{{ route('home_') }}" type="button"
                                style="text-decoration:none; color:white; line-height: 39px;"
                                class="btn btn-hover color-2 btnSearch d-block mt-3 mb-2" id="home">TORNA ALLA
                                HOME</a>

                        </form>
                    </div>

                </div>
            </div>
            <div class="col-md-6 col-sm-12 mx-auto">
                <div class="card mx-auto mb-3 cardGeneral cardRisultatiRicerca" id="contenitoreRicerca" data-aos="fade"
                    data-aos-duration="3000">
                    <h3 class="mb-3 mt-4 text-center qui">Risultati ricerca</h3>
                    <p class="qui" style="text-align: center;font-size:13px;">Qui appariranno le informazioni del
                        veicolo ricercato</p>
                    <div class="headModello" style="display: none">
                        <div class="card-header text-header text-center mt-3">
                            <span id="modello">
                                <!--     contenuto append  titolo      -->
                            </span>
                            <div class="d-flex justify-content-between container mt-3 mb-0 " id="veicolo">
                                <!--     contenuto append  intestazione      -->
                            </div>
                        </div>
                    </div>
                    <div id="noresult">
                        <!-- append -->
                    </div>
                    <div class="card-body text-primary ">
                        <div class="d-flex flex-wrap justify-content-between mt-2 mb-0 " id="tableVeicoli">
                            <!-- append contenuto   -->
                            <button id='confInv'>CONFERMA INVENTARIO</button>
                        </div>
                        <div style="display: none" id=btnModInv>
                            <form method='post' style='width:100%' action='{{ route(' destroy-trovata') }}'> @csrf
                                <input type="number" hidden name="trovata" id="veicoloTrovataId">
                                <button type='submit' class="btn btn-hover color-4 btnSearch" id='deleteInv'> ESCLUDI DA
                                    INVENTARIO </button>
                            </form>


                        </div>
                    </div>

                    <button id="addNota" class="btnAddNota" style="display:none">AGGIUNGI NOTA</button>
                    <div id="notaManuale" style="display: none; position: relative;top: -70px;">

                        <form style="width:100%;" id="formAddNota" action="{{ route('note-store') }}" method="post">
                            @csrf
                            <h2 style="color:black;text-align:center">Nuova nota</h2>
                            <div class="container">
                                <p id="operatore" style="display:inline;">Operatore: {{ Auth::user()->operatore }} </p>
                                <p id="dataOra" style="display:inline;">Data e ora correnti: </p>
                                <p id="ubicazione" style="display:inline;">Ubicazione: {{ Auth::user()->ubicazione }}
                                </p>
                                <textarea id="nota-textarea"
                                    style="display:block; width:100%;height:130px;border-radius:5px;padding:10px;"
                                    name="nota" placeholder="Scrivi qua un testo"></textarea>
                                <input name="id_veicolo" hidden id="id_veicolo_nota">
                                <input name="status" hidden id="status_nota">
                            </div>

                            <div style="text-align:center;margin-top:10px">
                                <button id="annullaNota"
                                    style="background-image: linear-gradient(to right, #FF6666, #B30000);border-radius:50px;padding:12px;color:white;font-weight:700;display: inline;width: 45%;border:none;margin-bottom: 10px;">Annulla</button>
                                <button id="aggiungiNota"
                                    style="background-image: linear-gradient(to right, #7CFC00, #006400); border-radius:50px;padding:12px;color:white;font-weight:700; display: inline; width: 45%; border:none; margin-left: 4px;margin-bottom: 10px;">Aggiungi</button>
                            </div>
                        </form>
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
        // nascondi in partenza il button 'conferma inventariato'           
            $('#confInv').hide();

            // Ottieni il riferimento all'elemento che contiene l'immagine di caricamento
            var loader = $('#messaggio-attesa');
            // Nascondi l'immagine di caricamento all'inizio
            loader.hide();
            $(document).ready(function() {

                
                $('#cerca').click(function(e) {
                 e.preventDefault();   
                 $('.qui').hide();
                 $('.cardRisultatiRicerca').addClass('heightBodyCardRisultati');
                
                 
            
                    var targa = $('#targa').val();
                    var telaio = $('#numTelaio').val();

                    // mostro pulsante "Aggiungi nota"

                    if(targa || telaio ){

                        $('#addNota').show();
                    }

                    // Verifica se entrambe le variabili sono vuote
                    if (targa == 0 && telaio == 0) {
                        alert("Riempi uno dei due campi.");
                        return;
                    }

                    // Verifica se targa contiene 7 caratteri alfanumerici
                    if (targa && !/^[a-zA-Z0-9]{7}$/.test(targa)) {
                        alert("Targa deve contenere esattamente 7 caratteri alfanumerici.");
                        return;
                    }

                    // Verifica se telaio contiene da 7 a 17 caratteri alfanumerici
                    if (telaio && !/^[a-zA-Z0-9]{7,17}$/.test(telaio)) {
                        alert("Il numero di telaio deve contenere da 7 a 17 caratteri alfanumerici.");
                        return;
                    }

                    // Dichiarazione della variabile fuori dal callback
                    let latitude = '';
                    let longitude = '';


                    
                    // Recupera i dati e aggiorna l'interfaccia
                    loader.show();

                   
        

                    $.ajax({
                        url: '{{ route('get-ajax') }}',
                        type: "GET",
                        // cache: true,
                        dataType: "json",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'targa': targa,
                            'telaio': telaio,
                        },

                        success: function(response) {
                            loader.hide();

                            var status_n = response.car.status;
                            var status_nuovo;


                          var latitudine = $('#latitude').val(); 
                          var longitudine = $('#longitude').val();

                            if (status_n) {

                                switch (status_n) {
                                    case 'A':
                                        status_nuovo = "Stock";
                                        break;
                                    case 'C':
                                        status_nuovo = "Virtuale";
                                        break;
                                    case 'R':
                                        status_nuovo = "Richiesto";
                                        break;
                                    case 'T':
                                        status_nuovo = "Assegnato";
                                        break;
                                    case 'U':
                                        status_nuovo = "Uscito";
                                        break;
                                    case 'V':
                                        status_nuovo = "Venduto";
                                        break;
                                    case 'M':
                                        status_nuovo = "Manuale";
                                        break;

                                    default:
                                        status_nuovo = "Nessuno status";
                                }


                            }


                            // creo uno switch case per tradurre in base al codice alla stringa corrispondente su 'status' in usato

                            var status_u = response.car.status_veicolo;
                            var status_usato;

                            if (status_u) {

                                switch (status_u) {
                                    case 'A':
                                        status_usato = "Stock";
                                        break;
                                    case 'S':
                                        status_usato = "Venduto";
                                        break;
                                    case 'R':
                                        status_usato = "Rottamazione";
                                        break;
                                    case 'U':
                                        status_usato = "Uscito";
                                        break;
                                    case 'V':
                                        status_usato = "Vendita";
                                        break;
                                    case 'M':
                                        status_usato = "Manuale";
                                        break;

                                    default:
                                        status_usato = "Nessuno status";
                                }


                            }

                            var spanTitolo = $('#modello');
                            spanTitolo.empty();

                            // imposto il titolo del veicolo in base che la tabella sia veicoli usati, nuovi...:
                            var nomeVeicolo;
                            if (response.car.vin) {

                                nomeVeicolo = response.car.descrizione;

                            } else if (response.car.telaio && response.car.status != 'M') {

                                nomeVeicolo = response.car.descr_versione;

                            }



                            //Inserisco il titolo descrittivo del veicolo su nuovo/usato oppure in alternativa quello manuale con i campi marca e modello
                            $('#modello').append(
                                "<h5 class='d-inline text-left'>" + (nomeVeicolo ?? response.car
                                    .marca + ' ' + response.car.modello) + "</h5>"
                            );

                            $('#modello h5').addClass('classeModello');


                            //--------------------------------------------------------------------

                            //recupera i 3 dati con veicolo status e inventariato si/no


                            var status;
                            var nuovo_usato;

                            if (status_nuovo) {

                                status = status_nuovo;

                            } else if (status_usato) {
                                status = status_usato;
                            }


                            
                            if (response.car.vin) {

                                nuovo_usato = 'USATO';

                            } else if (response.car.telaio && response.car.nuovo_usato == 'u' &&
                                response.car.status == 'M') {
                                nuovo_usato = 'USATO';
                            } else if (response.car.telaio && response.car.nuovo_usato == 'n' &&
                                response.car.status == 'M') {

                                nuovo_usato = 'NUOVO';
                            } else {
                                nuovo_usato = 'NUOVO';
                            }


                            var divIntest = $('#veicolo');
                            divIntest.empty();

                            var noResult = $('#noresult');
                            noResult.empty();



                            $('#veicolo').append(
                                "<div class='subTitleVeicolo'>" + "Veicolo: " +
                                "<span> <strong>" + nuovo_usato + "</strong> </span>" +
                                "</div>" +
                                "<div class='subTitleStatus'>Status: <span>" + status +
                                "</span>" + "</div>" +
                                "<div class='subTitleInventariato'>Inventariato: <span id='inventario'>" +
                                response.test.invent + "</span>" + "</div>"
                            );

                            //-------------------------------------------------------------------------


                            var tableBody = $('#tableVeicoli')
                            tableBody.empty();


                            // creo uno switch case per tradurre in base al codice alla stringa corrispondente su 'linea'

                            var x = response.car.linea;
                            var linea;

                            switch (x) {
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


                            // controllo l'ubicazione
                            var luogo;
                            if (response.car.descrizione_ubicazioni) {

                                luogo = response.car.descrizione_ubicazioni;
                            } else if (response.car.desc_ubicazione) {
                                luogo = response.car.desc_ubicazione;
                            } else {
                                luogo = response.car.ubicazione;
                            }


                       

                            $('#tableVeicoli').append(
                                "<div class='cell'>Targa: <span><strong> " + response.car
                                .targa + ' ' +
                                "</span></strong>" + "</div>" +
                                "<div class='cell'>Telaio: <span><strong> " + (response.car
                                    .telaio ?
                                    response.car.telaio : response.car.vin) +
                                "</span> </strong>" +
                                "</div>" +
                                "<div class='cell'>Colore: <span><strong> " + response.car
                                .colore +
                                "</span></strong>" + "</div>" +
                                "<div class='cell'>Ubicazione: <span><strong> " + luogo +
                                "</span></strong>" + "</div>" +
                                "<div class='cell'>Tipo prodotto: <span><strong> " + (linea) +
                                "</span></strong>" + "</div>" +
                                "<div class='cell'>N° contratto: <span><strong> " + (response
                                    .car
                                    .numero_contratto ?? '-') + "</span></strong>" + "</div>" +
                                "<div class='cellData'>Data stipula contratto: <span><strong> " +
                                (response.car.data_contratto ?? '-') + "</span></strong>" +
                                "</div>" +
                                "<div class='cellData'>Data chiusura contratto: <span><strong> " +
                                (response.car.data_uscita ?? '-') + "</span></strong>" +
                                "</div>" +
                                "<div class='cellData'>Data fattura vendita: <span><strong> " +
                                (response
                                    .car.data_fattura_v ?? '-') + "</span></strong>" +
                                "</div>" +


                                "<div class='textNessunaNotaInfinity' id='nota_infinity'></div>" +
                                "<form method='post' style='width:100%' action='{{ route('store-trovata') }}'>" +
                                '@csrf' +
                                "<input name='id_operatore' hidden id='id_operatore' value='{{ Auth::user()->id }}'>" +
                                "<input name='user_operatore' hidden id='user_operatore' value='{{ Auth::user()->name }}'>" +
                                "<input name='idveicolo' hidden id='idveicolo' value='" +
                                response.car.id_veicolo + "'>" +
                                "<input name='nuovo_usato' hidden id='nuovo_usato' value='" + (
                                    response.car.telaio ? 'n' : 'u') + "'>" +
                                "<input name='ubicazione' hidden id='ubicazione' value='{{ Auth::user()->ubicazione }}'>" +
                                "<input name='latitudine' hidden  id='' value='"+latitudine+"'>" +
                                "<input name='longitudine' hidden  id='' value='"+longitudine+"'>" +
                                "<button type='submit'  id='confInv' >" +
                                'CONFERMA INVENTARIO' + "</button>" + "</form>" +
                                "<div class='textNessunaNota' id='nota_manuale'></div>" 
                                // '<button id="addNota" style="width: 48%;display:inline;position: relative;top: -76px;left: 268px;">AGGIUNGI NOTA</button>'

                            );
                      

                            if (response.test.invent == "No") {
                                $('#confInv').show();
                                $('#no_invent').text('Ancora non inventariato');
                                $('#btnModInv').hide();
                                $('#addNota').removeClass('positionBtnAddNoteInvSi');
                                $('#addNota').addClass('positionBtnAddNoteInvNo');

                            }

                            if (response.test.invent == "Si") {
                                $('#confInv').hide();
                                $('#no_invent').text('Inventariato dall\'operatore, ' + response
                                    .trovata.user_operatore + ' in data ' + response.trovata
                                    .dataOra + ' presso ' + response.trovata.luogo);
                                //Aggiunta pulsante modifica stato inventariato
                                $('#veicoloTrovataId').val(response.trovata.idveicolo);
                                $('#btnModInv').show();
                                $('#addNota').removeClass('positionBtnAddNoteInvNo');
                                $('#addNota').addClass('positionBtnAddNoteInvSi');


                                $('#deleteInv').click(function(event) {
                                    event.preventDefault();
                                    if (confirm(
                                            "Sei sicuro di voler escludere questo veicolo dall'inventario?"
                                            )) {
                                        $(this).closest('form').submit();
                                    }
                                });




                            }

                                 $('#addNota').on('click', function() {
                                    
                                $('#id_veicolo_nota').val(response.car.id_veicolo);
                                response.car.vin ? $('#status_nota').val('u') : $('#status_nota').val('n');
                               $('#notaManuale').addClass('clickAddNote');
                                 $('#notaManuale').show();
                               

                                });
                                
                                
                              $('#annullaNota').on('click', function(e) {
                                 e.preventDefault();
                                 $('#notaManuale').hide();

                                });
                                
                                

                       // Controllo se è stato inventariato il veicolo (Si/No)

                            if (response.test.invent == "No") {
                                $('#confInv').show();
                                $('#no_invent').text('Ancora non inventariato');


                            }


                            if (response.test.invent == "Si") {
                                $('#confInv').hide();
                                $('#no_invent').text('Inventariato dall\'operatore, ' + response
                                    .trovata.user_operatore + ' in data ' + response.trovata
                                    .dataOra + ' presso ' + response.trovata.luogo);

                            }

                            // Controllo se il veicolo nuovo o usato  riporta delle note infinity

                            if (response.car.note == null || response.car.note == "") {
                                $('#nota_infinity').text(
                                    'Nessuna nota da Infinity per questo veicolo').css(
                                    'font-size', '13px');

                            } else {

                                $('#nota_infinity').text(response.car.note);

                            }
                            $('.headModello').show();

                        }

                        // In caso di no response 

                    }).fail(function() {
                        var noResult = $('#noresult');
                        noResult.empty();

                        var divIntest = $('#veicolo');
                        divIntest.empty();
                        var tableBody = $('#tableVeicoli')
                        tableBody.empty();
                        var spanTitolo = $('#modello');
                        spanTitolo.empty();
                        $('#headModello').hide();
                        $('#btnModInv').hide();
                        $('#noresult').append(
                            "<h4 style='font-size:29px;text-align:center;margin-top:18px;'>" +
                            'Nessun risultato' + "</h4>" +
                            "<a href='/aggiungi-veicolo'><button class='cellData' id='myButton'>CREA UN NUOVO VEICOLO</button>"
                        );


                        loader.hide();
                       $('#addNota').hide();
                       $('#contenitoreRicerca').addClass('cardRisultatiRicercaNotfound');

                    });
                });
            });


           


    </script>

    <script>
        AOS.init();
    </script>









    @endsection


    <!--ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;-->
    <!--x10236548x-->
    <!--WVGZZZA1ZPV618988-->
    <!--CX936AS si inventario-->
    <!--SJ305HD  no inventario-->
    <!--AJ305HD -->
    <!---->