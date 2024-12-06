@extends('layouts.app')
@section('content')
  <div class="login">
      <div class="d-flex justify-content-center">
        <div class="card-deck d-md-flex justify-content-center">
            <div class="col-md-12 col-sm-12 mx-auto">
                <div class="card mb-3 cardGeneral" >
                    <div class="card-header text-header text-center"><i class="bi bi-door-open-fill"></i></i><h4 class="d-inline">Benvenuto</h4></div>
                    <div class="card-body text-primary">
                        <div class="col-xs-4">
                            <div class="field">
                                <input type="text" name="user" required><br>
                                <label>Username</label>
                              </div>
                          </div>
                          <div class="col-xs-4">
                            <div class="field">
                                <input type="password" name="password" required><br>
                                <label>Password</label>
                                </div>
                          </div>
                        <button class="btn btnAct d-block mt-3 mb-2"  data-aos="fade-right" data-aos-delay="100" data-aos-duration="1000" type="submit">Entra</button>
                    </div>
                  </div>
              </div>
         </div>
        </div>
      <div class="quadrato" data-aos="zoom-in" data-aos-delay="100" data-aos-duration="1000">
      </div>
      </div>
      <script>
        $(document).ready(function() {
      $('.js-example-basic-multiple').select2();
  });
      </script>
      <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
      <script>
        AOS.init();
      </script>
   
    
@endsection