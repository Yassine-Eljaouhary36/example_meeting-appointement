<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route('meetings-panel')}}">Home</a>
        </li>
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link " style="padding-right: 2px" href="{{route('commandes')}}">Meetings cart <i class="fa-solid fa-cart-shopping"></i> <span class="badge rounded-pill bg-danger " style="transform: translate(-45%, -66%) !important;">{{count($cart_meetings)}}</span></a>
        </li>
        @guest('client')
          <li class="nav-item">
            <a class="nav-link "style="padding-left: 2px" href="{{ route('showRegistrationForm') }}" >Register <i class="pl-1 fa-solid fa-pencil"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ route('showLoginForm') }}" >Log in <i class="fa-solid fa-user"></i></a>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link " href="{{ route('logout') }}" >Log out <i class="pl-1 fa-solid fa-right-to-bracket"></i></a>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>