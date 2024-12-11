@extends('layouts.app')
@section('content')
    <div class="ricercaVeicoli mt-5">
        @if (Session::get('status'))
        <div class="justify-content-center">
            <div class="alert alert-success alert-dismissible text-blue mx-auto" role="alert" style="position: relative;left: 47px;margin-bottom: 19px;margin-top: -87px;">
                <span class="text-sm">{{ Session::get('status') }} </span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        <div class="d-flex justify-content-center">



            <div class="text-center" id="messaggio-attesa">

            </div>
            <div class="card-deck d-md-flex justify-content-center">
                <div class="col-md-12 col-sm-12 mx-auto">
                    <div class="card mb-3 cardGeneral cardRicerca">

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


                            <form action="{{ route('add-veicolo') }}" method="post"> @csrf
                              <div class="row">
                                <div class="col-5">
                                    <div class="field" style="margin: 16px auto;">
                                    <select class="form-select" name="nuovo_usato">
                                        <option></option>
                                        <option value="n">Nuovo</option>
                                        <option value="u">Usato</option>
                                    </select>
                                    <label style="margin: -62px 3px -9px;color:#999;font-size:16px;">Stato</label>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="field" style="margin: 16px auto;">
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

                                        <label style="margin: -62px 3px -9px;color:#999;font-size:16px;">Marca</label>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="field" style="margin: 16px auto;">
                                        <input type="" name="modello" id="modello" required><br>
                                        <label style="margin: -59px 3px -9px;color:#999;font-size:16px;">Modello</label>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="field" style="margin: 16px auto;">
                                        <input type="" name="colore" id="colore"><br>
                                        <label>Colore</label>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="field" style="margin: 16px auto;">
                                        <input type="" name="targa" id="targa"><br>
                                        <label>Targa</label>
                                    </div>
                                </div>
                                <div class="col-xs-4" >
                                    <div class="field" style="margin: 16px auto;">
                                        <input type="" name="telaio" id="Telaio"><br>
                                        <label>Numero di telaio</label>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="field" style="margin: 16px auto;">
                                        <input type="" name="ubicazione" id="ubicazione"><br>
                                        <label>Ubicazione</label>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="field" style="margin: 16px auto;">
                                        <textarea type="" name="nota" id="nota" style="width: 100%;
                                        border-color: #999;
                                        border-radius: 5px;" required ></textarea><br>
                                        <label style="margin: -83px 3px -9px;color:#999;font-size:16px;">Nota</label>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="field" style="margin: 16px auto;">
                                      <input type="file" name="immagine" id="immagine" accept="image/*"><br>
                                      <label style="margin: -65px 3px -9px;">Carica immagine</label>
                                    </div>
                                  </div>
                                  
                            </div>
                                <button class="btn btn-hover color-1 btnSearch d-block mt-3 mb-2"
                                    id="">AGGIUNGI</button>
                                <a href="{{ route('home') }}" type="button"
                                    style="text-decoration:none; color:white; line-height: 39px;"
                                    class="btn btn-hover color-2 btnSearch d-block mt-3 mb-2" id="home">TORNA ALLA
                                    HOME</a>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

<!--ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;-->
