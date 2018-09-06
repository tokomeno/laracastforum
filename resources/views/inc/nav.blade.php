 <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                {{-- <li class="nav-item">
                    <a class="nav-link" href="/threads">All Threads</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="/threads?popular=1">Popular</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/threads/create">Add Thread</a>
                </li> --}}

                <li class="nav-item dropdown">
                        <a id="browse" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                             Broewse <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="browse">
                                <a  class="dropdown-item" href="/threads">All Threads</a>
                                <a  class="dropdown-item" href="/threads/create">Add Thread</a>
                                <a  class="dropdown-item" href="/threads?unanswered=1">Unanswered threads</a>
                        </div>
                    </li>

                @auth
                <li class="nav-item">
                    <a class="nav-link" href="/threads?by={{auth()->user()->name }}">My Thread</a>
                </li>
                @endauth




                    <li class="nav-item dropdown">
                        <a id="channelsDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                             Cannels <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="channelsDropdown">
                            @foreach ($channels as $ch)
                                <a class="dropdown-item" href="/threads/{{ $ch->slug }}">
                                    {{$ch->name}}
                                </a>
                            @endforeach

                        </div>
                    </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
            <user-note></user-note>
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/profiles/{{auth()->user()->name}}">
                               My profile
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
