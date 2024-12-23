@extends('layouts.app')
@section('content')
    <div class="aggiungiVeicoli">

        @if (Session::get('status'))
        <div class="justify-content-center mt-5">
            <div class="alert alert-success alert-dismissible text-blue mx-auto" role="alert">
                <span class="text-sm">{{ Session::get('status') }} </span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif


        <style>
        
        #photos-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

#photos-container img {
    border: 1px solid #ccc;
    padding: 5px;
    background: #fff;
    border-radius: 5px;
}

#photos-container button {
    background: #b8b4b4;
    color: white;
    border: none;
    cursor: pointer;
    margin-left: -28px;
    height: 19px;
    font-size: 11px;
}

        
        </style>

        <div class="d-flex justify-content-center">

   

            <div class="text-center" id="messaggio-attesa"></div>
            <div class="card-deck d-md-flex justify-content-center">
                <div class="col-md-12 col-sm-12 mx-auto">
                 <div class="card mb-3 cardGeneral cardAggiungi" style="width: 360px; position: relative;">

                        
           

                        <div class="card-header text-header text-center">
                            <h5 class="mt-3">Aggiungi veicolo</h5>
                            <img src="{{ asset('img/logoCarPoint.png') }}" alt="Logo" width="50%" class="mt-3 mx-auto">
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body text-primary">
                            <form action="{{ route('add-veicolo') }}" method="post" enctype="multipart/form-data"> @csrf
                                <div class="row">
                                    <!-- Stato -->
                                    <div class="col-5">
                                        <div class="field" style="">
                                            <label for="nuovo_usato" style="color:#999; font-size:16px;">Stato</label>
                                            <select class="form-select" name="nuovo_usato" id="nuovo_usato">
                                                <option></option>
                                                <option value="n">Nuovo</option>
                                                <option value="u">Usato</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Marca -->
                                    <div class="col-7">
                                        <div class="field" style="">
                                            <label for="marca" style="color:#999; font-size:16px;">Marca</label>
                                            <select name="marca" class="form-select" id="marca" required>
                                                <option></option>
                                                <option value="Abarth">Abarth</option>
                                                <option value="Alfa Romeo">Alfa Romeo</option>
                                                <option value="Audi">Audi</option>
                                                <option value="BMW">BMW</option>
                                                <option value="Chevrolet">Chevrolet</option>
                                                <option value="Citroen">Citroen</option>
                                                <option value="Dacia">Dacia</option>
                                                <option value="Ferrari">Ferrari</option>
                                                <option value="Fiat">Fiat</option>
                                                <option value="Ford">Ford</option>
                                                <option value="Honda">Honda</option>
                                                <option value="Hyundai">Hyundai</option>
                                                <option value="Jaguar">Jaguar</option>
                                                <option value="Jeep">Jeep</option>
                                                <option value="Kia">Kia</option>
                                                <option value="Lamborghini">Lamborghini</option>
                                                <option value="Lancia">Lancia</option>
                                                <option value="Land Rover">Land Rover</option>
                                                <option value="Lexus">Lexus</option>
                                                <option value="Maserati">Maserati</option>
                                                <option value="Mazda">Mazda</option>
                                                <option value="Mercedes-Benz">Mercedes-Benz</option>
                                                <option value="Mini">Mini</option>
                                                <option value="Mitsubishi">Mitsubishi</option>
                                                <option value="Nissan">Nissan</option>
                                                <option value="Opel">Opel</option>
                                                <option value="Peugeot">Peugeot</option>
                                                <option value="Porsche">Porsche</option>
                                                <option value="Renault">Renault</option>
                                                <option value="Seat">Seat</option>
                                                <option value="Skoda">Skoda</option>
                                                <option value="Smart">Smart</option>
                                                <option value="Subaru">Subaru</option>
                                                <option value="Suzuki">Suzuki</option>
                                                <option value="Tesla">Tesla</option>
                                                <option value="Toyota">Toyota</option>
                                                <option value="Volkswagen">Volkswagen</option>
                                                <option value="Volvo">Volvo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Modello -->
                                    <div class="col-xs-4">
                                        <div class="field" style="">
                                            <label for="modello" style="color:#999; font-size:16px;">Modello</label>
                                            <input type="text" name="modello" id="modello" required>
                                        </div>
                                    </div>

                                    <!-- Colore -->
                                    <div class="col-xs-4">
                                        <div class="field" style="">
                                            <label for="colore" style="color:#999; font-size:16px;">Colore</label>
                                            <input type="text" name="colore" id="colore">
                                        </div>
                                    </div>

                             <!-- Targa -->
                             <div class="col-xs-4">
                                <div class="field" style="">
                                    <label for="targa" style="margin-bottom: 0; color:#999; font-size:16px;">Targa</label>
                                    <input type="text" name="targa" id="targa" style="width: 100%; margin-top: 8px;">
                                </div>
                            </div>
                            
                            <!-- Numero di Telaio -->
                            <div class="col-xs-4">
                                <div class="field" style="">
                                    <label for="telaio" style="margin-bottom: 0; color:#999; font-size:16px;">Telaio</label>
                                    <input type="text" name="telaio" id="telaio" style="width: 100%; margin-top: 8px;">
                                </div>
                            </div>
                            



                                    <!-- Ubicazione -->
                                    <div class="col-xs-4">
                                        <div class="field" style="">
                                            <label for="ubicazione" style="color:#999; font-size:16px;">Ubicazione</label>
                                            <input type="text" name="ubicazione" id="ubicazione">
                                        </div>
                                    </div>

                                    <!-- Descrizione -->
                                    <div class="col-xs-4">
                                        <div class="field" style="">
                                            <label for="nota" style="color:#999; font-size:16px;">Descrizione</label>
                                            <textarea name="nota" id="nota" style="width: 100%; border-color: #999; border-radius: 5px;" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Carica Immagine  -->
                                    <div class="col-xs-4">
                                        <div class="field" style="">
                                            <label for="immagine" style="color:#999; font-size:16px;">Carica immagine</label>
                                            <input type="file" name="immagini[]" id="immagine" multiple accept="image/*" capture="camera">
                                        </div>
                                    </div>
                                   

                                    
                                        <video id="camera" width="100%"  autoplay></video>
                                        <canvas id="snapshot" style="display:none;"></canvas>
                                        <button class="btn btn-hover color-7 mt-4 mb-2" id="capture" type="button" style="max-width: 80%;margin:auto"> Scatta<i
                                            class="material-icons" style="
                                        font-size: 21px;
                                        position: relative;
                                        top: 4px;
                                        left: 10px;
                                    ">camera_alt</i></button>
                                        <input type="hidden" name="foto_base64[]" id="foto_base64" multiple>
                                        <div id="photos-container"></div>  
                
        


                                </div>
                                
                                <button type="submit" class="btn btn-hover  color-1 btnSearch d-block mt-3 mb-2" id="">AGGIUNGI</button>
                            </form>

                           
                            
                        <a href="{{ route('home_') }}" type="button" style="text-decoration:none; color:white; line-height: 39px;" class="btn btn-hover color-2 btnSearch d-block mt-3 mb-2" id="home">TORNA ALLA HOME</a>
                        
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
  $(document).ready(function() {
    $("form").on("submit", function(e) {
        
        var targa = $("#targa").val().trim();
        var telaio = $("#telaio").val().trim();

       
        if (targa === "" && telaio === "") {
           
            alert("Compila almeno uno dei due campi: Targa o Telaio.");
            e.preventDefault(); 
        }
    });
});

</script>


<script>
   
   document.addEventListener("DOMContentLoaded", function () {
    const video = document.getElementById("camera");
    const canvas = document.getElementById("snapshot");
    const captureButton = document.getElementById("capture");
    const photosContainer = document.getElementById("photos-container");

    // Verifica che l'elemento 'photos-container' esista
    if (!photosContainer) {
        console.error("Elemento photos-container non trovato!");
        return;
    }

    // Richiedi l'accesso alla fotocamera
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices
            .getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;
            })
            .catch((err) => {
                console.error("Errore nell'accesso alla fotocamera:", err);
                alert("Impossibile accedere alla fotocamera.");
            });
    } else {
        alert("La fotocamera non è supportata su questo dispositivo.");
    }

    // Cattura l'immagine quando si clicca il pulsante
    captureButton.addEventListener("click", () => {
        const context = canvas.getContext("2d");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Disegna il fotogramma corrente del video sul canvas
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Converte l'immagine in formato Base64
        const base64Image = canvas.toDataURL("image/png");

        // Crea un nuovo input nascosto per questa immagine
        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "foto_base64[]";
        hiddenInput.value = base64Image;

        // Aggiungi il nuovo input al container
        photosContainer.appendChild(hiddenInput);

        // Crea l'elemento immagine per l'anteprima
        const imgElement = document.createElement("img");
        imgElement.src = base64Image;
        imgElement.style.maxWidth = "100px"; // Imposta una larghezza fissa per le anteprime
        imgElement.style.marginRight = "10px";

        // Crea un pulsante per rimuovere l'immagine
        const removeButton = document.createElement("button");
        removeButton.innerText = "x";
        removeButton.addEventListener("click", () => {
            imgElement.remove();
            removeButton.remove();
            hiddenInput.remove();
        });

        // Aggiungi l'immagine e il pulsante di rimozione al container
        photosContainer.appendChild(imgElement);
        photosContainer.appendChild(removeButton);

        alert("Foto catturata!");
    });
});




</script>


@endsection
