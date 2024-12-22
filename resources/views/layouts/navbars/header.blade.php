<div class="container-fluid">

@if(Auth::check())
<div class="navbar">
 
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>


      <div class="d-flex float-end">
       
      </div>
      <div class="dropdown d-flex float-end ">
        <div class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         
          <img src="/img/teamIcon.png" style="width:7%;" class="mt-1 float-end">
          <h6 class="float-end " style="margin-top: 14px;margin-right:10px;font-size: 20px;font-weight:700">{{Auth::user()->name  }}</h6>
        </div>
        <div class="dropdown-menu" style="margin-top:-14px;font-size:15px;" aria-labelledby="dropdownMenuButton" class="mt-3 float-end">
          <a class="dropdown-item" style="color:rgb(124, 124, 124);" href="{{ route('home_') }}"><strong>Home</strong></a>
          <a class="dropdown-item" style="color:black;" href="{{route('report.index')}}"><strong>Report</strong></a>
          <a class="dropdown-item" style="color:green;" href="{{ route('search.veicoli') }}"><strong>Ricerca veicoli</strong></a>
          <a class="dropdown-item" style="color:rgb(177, 177, 56);" href="{{ route('piazzali') }}"><strong>Piazzali</strong></a>
          <a class="dropdown-item" href="{{ route('new-veicolo') }}"><strong>Nuovo veicolo</strong></a>
         @role('Admin')<a class="dropdown-item"  style="color:rgb(75, 75, 26);" href="{{ route('user') }}"><strong>Utenti</strong></a>@endrole
          <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Esci</a>
        </div>
      </div>
    </div>
  @endif
  </div>

  

