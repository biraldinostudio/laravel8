<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
    <a class="navbar-brand" href="{{url('')}}">{{config('app.name')}}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">  {{__('categories')}}  </a>
              <ul class="dropdown-menu">
                @foreach($menu_categories as $category)
                  <li><a class="dropdown-item" href="#"> {{ $category->name }} @if(count($category->childs)) &raquo @endif</a>
                    @if(count($category->childs))
                      @include('layouts.front.inc.menuChild',['childs' => $category->childs])
                     @endif
                  </li>
                @endforeach
              </ul>
          </li>
          @guest
          <li class="nav-item">
            <a class="nav-link" href="{{url('/')}}">{{__('article')}}</a>
          </li>  
          @if (Route::has('login'))
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">{{ __('login') }}</a>
              </li>
          @endif
          
          @if (Route::has('register'))
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('register') }}</a>
              </li>
          @endif
      @else
      <li class="nav-item active">
        <a class="nav-link" href="{{url('home')}}">{{__('home')}}
          <span class="sr-only">(current)</span>
        </a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="{{url('/')}}">{{__('article')}}</a>
      </li>      
      <li class="nav-item">
        <a class="nav-link" href="{{route('article.index')}}">{{__('article management')}}</a>
      </li>      
          <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }}
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              </div>
          </li>

      @endguest
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          <img class="flag-icon" src="{{asset('front/icon/'.app()->getLocale().'.png')}}">
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            @if(app()->getLocale()=='id')
              <a href="{{url('locale/en')}}" class="dropdown-item"><img src="{{asset('front/icon/en.png')}}"> {{__('english')}}</a>
              <a href="{{url('locale/cn')}}" class="dropdown-item"><img src="{{asset('front/icon/cn.png')}}"> {{__('china')}}</a>
            @endif
            @if(app()->getLocale()=='en')
              <a href="{{url('locale/id')}}" class="dropdown-item"><img src="{{asset('front/icon/id.png')}}"> {{__('indonesian')}}</a>
              <a href="{{url('locale/cn')}}" class="dropdown-item"><img src="{{asset('front/icon/cn.png')}}"> {{__('china')}}</a>
            @endif
            @if(app()->getLocale()=='cn')
            <a href="{{url('locale/id')}}" class="dropdown-item"><img src="{{asset('front/icon/id.png')}}"> {{__('indonesian')}}</a>
            <a href="{{url('locale/en')}}" class="dropdown-item"><img src="{{asset('front/icon/en.png')}}"> {{__('english')}}</a>
          @endif
        </div>
      </li>
    </ul>
    </div>
  </div>
</nav>