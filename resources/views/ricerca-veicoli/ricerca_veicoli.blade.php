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


    <script>
        $(document).ready(function () {
            // Aggiungi l'evento click al bottone con ID confInv
            $('#confInv').on('click', function () {
                // Mostra un alert di conferma
                if (confirm('Sei sicuro di voler inventariare questo veicolo?')) {
                    console.log('Conferma inventario accettata.');
                    // Puoi aggiungere qui il codice per completare l'inventario
                } else {
                    console.log('Conferma inventario annullata.');
                }
            });
        });
    </script>

<div class="ricercaVeicoli">


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

                    <input hidden id="latitude" name="latitude" value="">
                    <input hidden id="longitude" name="longitude" value="">
                    
                    <div style="display: flex; align-items: center; justify-content: center; text-align: center; font-weight: bold;">
                        <i class="material-icons" style="margin-right: 8px; font-size: 18px;color: #b9b7b7;">
                            <span class="material-symbols-outlined" style="
                            position: relative;
                            top: -4px;
                            left: 11px;
                            font-weight: bold;
                            font-size: 14px;
                        ">location_on</span>
                        </i>
                        <input id="indirizzo" readonly style="font-size: 9px;color: #bfbfbf;margin-top: -3px;border: none; font-weight: bold;">
                    </div>
                    
                    

                    <script>
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(
                                (position) => {

                                    const latitude = position.coords.latitude;
                                    const longitude = position.coords.longitude;
                                    
                                    // Imposta i valori degli input nascosti
                                    $("#latitude").val(latitude);
                                    $("#longitude").val(longitude);
                                    
                                    // Invia i dati al backend (solo via URL, senza il corpo "data")
                                    $.ajax({
                                        url: '/reverse-geocoding/' + latitude + '/' + longitude,
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                        },
                                        success: function (response) {
                                            if (response.success) {
                                                // Mostra l'indirizzo ricevuto
                                                $("#indirizzo").val(response.address);
                                            } else {
                                                alert("Errore: " + response.message);
                                            }
                                        },
                                        error: function (xhr) {
                                            console.error("Errore nella richiesta:", xhr.responseText);
                                            alert("Errore durante la comunicazione con il server.");
                                        }
                                    });
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
    <button id="capture"  style="text-decoration: none;
    color: white;
    line-height: 39px;
    width: 80%;
    margin: auto;" class="btn btn-hover color-6 mt-4 mb-2" hidden >Cattura Targa</button>
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

     // Seleziona la fotocamera posteriore
navigator.mediaDevices.getUserMedia({
    video: { facingMode: { exact: "environment" } } // Forza l'uso della fotocamera posteriore
})
.then((stream) => {
    const video = document.querySelector("video"); // Assicurati di avere un <video> nella tua pagina HTML
    video.srcObject = stream;
	 $('#video').removeAttr('hidden');
            $('#capture').removeAttr('hidden');
            $('#ocrButton').css('display', 'none');
})
.catch((err) => {
    console.error("Errore nell'accesso alla webcam:", err);

    // FallBack se la fotocamera posteriore non è disponibile
    if (err.name === "OverconstrainedError" || err.name === "ConstraintNotSatisfiedError") {
        console.warn("Fotocamera posteriore non trovata, utilizzo quella frontale.");
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } })
            .then((stream) => {
                const video = document.querySelector("video");
                video.srcObject = stream;
			 $('#video').removeAttr('hidden');
            $('#capture').removeAttr('hidden');
            $('#ocrButton').css('display', 'none');
            })
            .catch((err) => {
                console.error("Errore nell'accesso alla webcam:", err);
            });
    }
});

    });



    // Cattura immagine
    captureButton.on('click', function () {
    
        const context = canvas.getContext('2d');
    
        // Assegna dimensioni al canvas alla dimensione del video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Mostra il preloader
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

                // Nascondi il preloader
                $('#preloaderocr').attr('hidden', 'hidden');

                // Controllo se la targa è stata riconosciuta
                if(response.results.length == 0){
                  alert('OCR: Non siamo riusciti a catturare la targa, ritenta')
                }

                 // Assegna la targa al campo input
                const plate = (response.results[0].plate || "").toUpperCase();
                $('#targa').val(plate).css('color', 'red');


                },
                error: function (xhr, status, error) {
                    console.error("Errore nella richiesta:", error);
                    // Nascondi il preloader
                    $('#preloaderocr').attr('hidden', 'hidden');

                    
                }

            
        });
    });
});

//WF0YXXTTGYGS00222
//cc631ze

                    </script>

                            <div class="card-body text-primary " style="padding: 15px 0; ">
                        <form class="container" style="margin-top: -5px;">

                            <label class="text-secondary" style="margin-bottom: 0.2rem;">Targa</label>
                            <div class="input-group mb-3">

                                <input name="targa" id="targa" value="{{ Session::get('targa') }}" type=""
                                    class="form-control" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-success" id="ocrButton" type="button"><i
                                            class="material-icons" style="
                                        font-size: 16px;
                                        position: relative;
                                        top: 3px;
                                        left: 0px;
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
                <div class=" card mx-auto mb-3 cardGeneral cardRisultatiRicerca" id="contenitoreRicerca" data-aos="fade"
                    data-aos-duration="3000" >
                    <h3 class="mb-3 mt-4 text-center qui">Risultati ricerca</h3>
                    <p class="qui" style="text-align: center;font-size:13px;">Qui appariranno le informazioni del
                        veicolo ricercato</p>
                        <div class="headModello" style="display: none">
                            <div class="card-header text-header mt-3">
                                <span id="modello">
                                   <!--     contenuto append  titolo      -->
                                </span>
                                <div class="d-flex justify-content-between container mt-3 mb-0 " id="veicolo">
                                  xx  <!--     contenuto append  intestazione      -->
                                </div>
                            </div>
                        </div>
                    <div id="noresult">
                        <!-- append -->
                    </div>
                    <div class="card-body text-primary " style="">
                        <div class="d-flex flex-wrap justify-content-between mt-2 mb-0 " id="tableVeicoli">
                            <!-- append contenuto   -->
                            <button id='confInv'>CONFERMA INVENTARIO</button>
                        </div>
                        <div style="display: none;padding:3px;" id=btnModInv>
                            <form method='post' style='width:100%' action='{{ route('destroy-trovata') }}'> @csrf
                                <input type="number" hidden name="trovata" id="veicoloTrovataId">
                                           <button type='submit' class="btn btn-hover color-4 btnSearch" id='deleteInv' style="font-size: 11px;font-weight:100;max-height: 55px;margin-top:10px;margin-left:1.1rem;margin-left: 0.1rem;font-weight: bolder;width: 100%;position: relative;top: -4px;"> ESCLUDI DA INVENTARIO </button>

                            </form>


                        </div>
                    </div>

                    <button id="addNota" class="btnAddNota" style="display:none">AGGIUNGI NOTA</button>
                    <div id="notaManuale" style="display: none; position: relative;top: -70px;">

                        <form style="width:100%;" id="formAddNota" action="{{ route('note-store') }}" method="post">
                            @csrf
                            <h4 class="mt-2" style="color:black;text-align:center">Nuova nota</h4>
                            <div class="container">
                                <p id="operatore" style="display:inline;">Operatore<b>{{ Auth::user()->operatore }} </p>
                                <p id="dataOra" style="display:inline;">Data e ora correnti:</b<b></b> </p>
                                <p id="ubicazione" style="display:inline;">Ubicazione:<b> {{ Auth::user()->ubicazione }}</b>
                                </p>
                                <textarea id="nota-textarea"
                                    style="display:block; width:100%;height:130px;border-radius:5px;padding:10px;"
                                    name="nota" placeholder="Scrivi qua un testo"></textarea>
                                <input name="id_veicolo" hidden id="id_veicolo_nota">
                                <input name="status" hidden id="status_nota">
                            </div>

                            <div style="text-align:center;margin-top:10px">
                                <button id="annullaNota" class="btn btn-hover color-8"
                                    style="border-radius:50px;padding:12px;color:white;font-weight:700;display: inline;width: 45%;border:none;margin-bottom: 10px;">Annulla</button>
                                <button id="aggiungiNota" class="btn btn-hover color-9"
                                    style="border-radius:50px;padding:12px;color:white;font-weight:700; display: inline; width: 45%; border:none; margin-left: 4px;margin-bottom: 10px;">Aggiungi</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal immagini -->
<div class="modal fade" id="showGallery" tabindex="-1" aria-labelledby="showGallery" aria-hidden="true">
    <div class="modal-dialog" style="
    max-width: 20%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="
                margin-top: -10px;
                font-size: 20px;
            " id="exampleModalLabel">Galleria foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img class="d-block w-100" src="..." alt="First slide">
                      </div>
                      <div class="carousel-item">
                        <img class="d-block w-100" src="..." alt="Second slide">
                      </div>
                      <div class="carousel-item">
                        <img class="d-block w-100" src="..." alt="Third slide">
                      </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
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

                function getStatusDescription(status, type) {
    const statusMap = {
        nuovo: {
            A: "Stock",
            C: "Virtuale",
            R: "Richiesto",
            T: "Assegnato",
            U: "Uscito",
            V: "Venduto",
            M: "Manuale",
        },
        usato: {
            A: "Stock",
            S: "Venduto",
            R: "Rottamazione",
            U: "Uscito",
            V: "Vendita",
            M: "Manuale",
        }
    };
    return statusMap[type]?.[status] || "Nessuno status";
}




                //ANCHOR Cerca veicolo
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

                            const immagini = response.car.immagini; 

                     

                        var tel = response.car.telaio || response.car.vin;
                        // Salva il valore nel local storage
                        localStorage.setItem('telaio', tel);

                        console.log('Telaio salvato nel local storage:', telaio);



                        var status_n = response.car.status;
                        var status_nuovo;


                          var latitudine = $('#latitude').val(); 
                          var longitudine = $('#longitude').val();
                          var indirizzo = $('#indirizzo').val(); 

                            if (status_n) {

                                var status_nuovo = getStatusDescription(response.car.status, 'nuovo');
                            }


                            // creo uno switch case per tradurre in base al codice alla stringa corrispondente su 'status' in usato

                            var status_u = response.car.status_veicolo;
                            var status_usato;

                            if (status_u) {

                                var status_usato = getStatusDescription(response.car.status, 'usato');

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
                            "<h5 class='text-left limit-text'>" + 
                            (nomeVeicolo ?? response.car.marca + ' ' + response.car.modello) + 
                            "</h5>"
                            // "<button type='button' style='padding:1px 5px;position:relative;' class='btn btn-foto ms-2 b' data-bs-toggle='modal' data-bs-target='#showGallery' data-bs-toggle='tooltip' title='Apri la galleria' id='b'>" +
                            // "<i class='fa-regular fa-images'></i>" +
                            // "</button>"
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



                            var inventarioStatus = response.test.invent; // Memorizza il valore di inventario
							console.log('Inventario Status:', inventarioStatus);

							var backgroundColor = "";
							var fontSize = "12px"; // Imposta la dimensione del font a 15px
							var borderRadius = "30px"; // Imposta il border-radius a 30px
							var padding = ""; // Padding inizialmente vuoto
							var color = "white"; // Imposta il colore del testo a bianco
							var display = "inline-block"; // Imposta il display inline-block

							// Normalizza il valore di inventario per evitare problemi di case-sensitivity
							if (inventarioStatus) {
								inventarioStatus = inventarioStatus.toLowerCase();
							}

							// Controlla il valore di inventario e imposta il colore di sfondo e il padding
							if (inventarioStatus === "si") {
								backgroundColor = "green";
								padding = "5px 10px 0px 6px"; // Specifico per "si"
							} else if (inventarioStatus === "no") {
								backgroundColor = "red";
								padding = "5px 9px"; // Padding generico
							} else {
								console.warn('Valore inventario non riconosciuto:', inventarioStatus);
							}

							$('#veicolo').append(
								"<div class='dati-header'>" +
									"<div class='subTitleVeicolo' style='display:block;font-weight:700'>Veicolo: " +
									"<span class='info-veicolo'> <strong>" + nuovo_usato + "</strong> </span>" +
									"</div>" +
									"<div class='subTitleStatus' style='display:block;font-weight:700'>Status: " +
									"<span class='info-stato'>" + status + "</span>" +
									"</div>" +
									"<div class='subTitleInventariato' style='display:block;font-weight:700'>Inventariato: " +
									"<span class='info-inventariato' id='inventario'>" + inventarioStatus + "</span>" +
									"</div>" +
								"</div>"
							).promise().done(function() {
								// Assicurati che l'elemento esista prima di applicare gli stili
								if ($('#inventario').length) {
									$('#inventario').css({
										'background-color': backgroundColor,
										'font-size': fontSize,
										'border-radius': borderRadius,
										'padding': padding,
										'color': color,
										'display': display
									});
								} else {
									console.error('Elemento #inventario non trovato nel DOM.');
								}
							});


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
                            var luogo = 
                                    response?.car?.descrizione_ubicazioni || 
                                    response?.car?.desc_ubicazione || 
                                    response?.car?.ubicazione || 
                                    response?.trovata?.luogo || 
                                    'NC';

                            var operatore;
                            var data;

                            if(response.trovata != null){

                                var operatore = response.trovata.user_operatore;
                                var data = response.trovata.dataOra;


                            }else{

                                var operatore = '';
                                var data = '';

                            }

                          

                             
                       
                           var formattedDate = data.split(' ')[0].split('-').reverse().join('-');
                            $('#tableVeicoli').append(
                                "<div class='cell cell-targa'><span class='span-cell-targa' style='color:gray;margin-top:-4px;'>Targa:</span> <span class='d-block dato-cell-targa'><strong> " + response.car.targa + ' ' +
                                "</span></strong>" + "</div>" +
                                "<div class='cell cell-ritiro'><span class='span-cell-ritiro'>Tipo di ritiro:</span> <span class='d-block dato-cell-ritiro'><strong> " + (linea) +
                                "</span></strong>" + "</div>" +
                                "<div class='cell cell-telaio'><span class='span-cell-telaio'>Telaio:</span> <span class='d-block dato-cell-telaio'><strong> " + (response.car.telaio ? response.car.telaio : response.car.vin) +
                                "</span> </strong>" + "</div>" +
                                "<div class='cell cell-ncontratto'><span class='span-cell-ncontratto'>N° contratto:</span> <span class='d-block dato-cell-ncontratto'><strong> " + (response.car.numero_contratto ?? '-') +
                                "</span></strong>" + "</div>" +
                                "<div class='cell cell-colore'><span class='span-cell-colore'>Colore:</span> <span class='d-block dato-cell-colore'><strong> " + response.car.colore +
                                "</span></strong>" + "</div>" +
                                "<div class='cellData cell-stipula-contratto'><span class='span-cell-stipula-contratto'>Data stipula contratto:</span> <span class='d-block dato-cell-stipula-contratto'><strong> " +
                                (response.car.data_contratto ?? '-') + "</span></strong>" + "</div>" +
                                "<div class='cell cell-ubicazione'><span class='span-cell-ubicazione'>Ubicazione:</span> <span class='d-block dato-cell-ubicazione'><strong> " + luogo +
                                "</span></strong>" + "</div>" +
                                "<div class='cellData cell-data-vendita'><span class='span-cell-data-vendita'>Data fattura vendita:</span> <span class='d-block dato-cell-vendita'><strong> " +
                                (response.car.data_fattura_v ?? '-') + "</span></strong>" + "</div>" +

                                                                
                                 "<p id='inventariato'><span class='info-inventario'>Inventariato</span> Operatore: <span class='info-operatore'>" + operatore +  "</span> in data: <span class='info-data'>" + formattedDate + "</span> presso: <span class='info-luogo'>" + luogo + "</span></p>" +


                                "</div>" +
                               
                                "<form method='post' style='width:100%' action='{{ route('store-trovata') }}'>" +
                                '@csrf' +
                                "<input name='id_operatore' hidden id='id_operatore' value='{{ Auth::user()->id }}'>" +
                                "<input style='border:none' hidden name='user_operatore'  id='user_operatore' value='{{ Auth::user()->name }}'>" +
                                "<input name='idveicolo' hidden id='idveicolo' value='" + response.car.id_veicolo + "'>" +
                                "<input name='nuovo_usato' hidden id='nuovo_usato' value='" + (response.car.telaio ? 'n' : 'u') + "'>" +
                                "<input name='ubicazione' hidden id='ubicazione' value='{{ Auth::user()->ubicazione }}'>" +
                                "<input name='latitudine' hidden  id='' value='"+latitudine+"'>" +
                                "<input name='longitudine' hidden id='' value='"+longitudine+"'>" +
                                "<input readonly hidden name='indirizzo_gps'  id='indirizzo_gps' value='"+indirizzo+"'>" +
                                "<button type='submit'  id='confInv' >" +
                                'CONFERMA INVENTARIO' + "</button>" + "</form>" +
                                "<div class='textNessunaNota' id='nota_manuale'></div>" +
                                "<div class='textNessunaNotaInfinity' id='nota_infinity'></div>"  

                            );
                      

                    if (response.test.invent == "No") {
                        $('#confInv').show();
                        $('#inventariato').text('').hide(); // Nascondi il messaggio
                        $('#btnModInv').hide();
                        $('#addNota').removeClass('positionBtnAddNoteInvSi');
                        $('#addNota').addClass('positionBtnAddNoteInvNo');

                        // Aggiungi il listener per la conferma inventario
                        $('#confInv').click(function(event) {
                            event.preventDefault();
                            if (confirm("Sei sicuro di voler confermare l'inventario per questo veicolo?")) {
                                console.log("Inventario confermato.");
                            }

                            // Raccogli i dati del modulo
                        let formData = {
                            id_operatore: $('#id_operatore').val(),
                            user_operatore: $('#user_operatore').val(),
                            idveicolo: $('#idveicolo').val(),
                            nuovo_usato: $('#nuovo_usato').val(),
                            ubicazione: $('#ubicazione').val(),
                            latitudine: $('#latitudine').val(),
                            longitudine: $('#longitudine').val(),
                            indirizzo_gps: $('#indirizzo_gps').val(),
                            _token: $('input[name="_token"]').val() // Include il CSRF token
                        };

                           // Invia la richiesta AJAX
                        $.ajax({
                            url: "{{ route('store-trovata') }}", // La route per il controller
                            type: "POST",
                            data: formData,
                            success: function (response) {

                                const americanDateTime = response.trovata.dataOra; // Formato originale: YYYY-MM-DD HH:mm:ss
                                const europeanDateTime = moment(americanDateTime, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY HH:mm");
                               
                                
                                $('#inventario').text('SI').css('background-color', 'green');
                                $('#confInv').hide();
                                $('#btnModInv').show();

                                $('#inventariato') // Mostra il messaggio solo in questo caso
                                .text('Inventariato da: ' + response.trovata.user_operatore + 
                                    ' in data: ' + europeanDateTime + 
                                    ' presso ' + response.trovata.luogo)
                                .css('color', 'black')
                                .css('font-size', '12px')
                                .show(); 

                                $('#veicoloTrovataId').val(response.trovata.idveicolo);
                               
                                alert('Dati salvati con successo!');
                            },
                            error: function (xhr, status, error) {
                                // Gestisci eventuali errori
                                console.error(xhr.responseText);
                                alert('Errore durante il salvataggio dei dati.');
                            }
                        });


                        });
                    }

if (response.test.invent == "Si") {
    $('#confInv').hide();
    $('#inventariato') // Mostra il messaggio solo in questo caso
    .html(
        'Inventariato da: <span class="operatore" style="color: red; font-weight: 700;">' + response.trovata.user_operatore + 
        '</span> in data: <span class="data-ora" style="color: red; font-weight: 700;">' + formatDataEU(response.trovata.dataOra) + 
        '</span> presso <span class="luogo" style="color: red; font-weight: 700;">' + response.trovata.luogo + '</span>'
    )
    .css({
        'color': 'black',
        'font-size': '12px'
    })
    .show(); // Assicurati che sia visibile

// Funzione per formattare la data
function formatDataEU(dataOra) {
    // Supponendo che `dataOra` sia nel formato ISO, ad esempio "2024-12-30T15:45:00"
    const data = new Date(dataOra); 
    const giorno = data.getDate().toString().padStart(2, '0'); // gg
    const mese = (data.getMonth() + 1).toString().padStart(2, '0'); // mm
    const anno = data.getFullYear(); // aaaa
    return `${giorno}/${mese}/${anno}`; // Formato europeo
}





    // Aggiunta pulsante modifica stato inventariato
    $('#veicoloTrovataId').val(response.trovata.idveicolo);
    $('#btnModInv').show();
    $('#addNota').removeClass('positionBtnAddNoteInvNo');
    $('#addNota').addClass('positionBtnAddNoteInvSi');

    $('#deleteInv').click(function(event) {
        event.preventDefault();
        if (confirm("Sei sicuro di voler escludere questo veicolo dall'inventario?")) {
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

                            }


                            if (response.test.invent == "Si") {
                                $('#confInv').hide();

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
    "<a href='/aggiungi-veicolo'>" +
    "<button class='cellData' id='myButton' style='width:86%; display:block; margin-left:auto; margin-right:auto;'>CREA UN NUOVO VEICOLO</button>" +
    "</a>"
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

<script>
    // Inizializza tutti i tooltip nella pagina
$(document).ready(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});

</script>







    @endsection
