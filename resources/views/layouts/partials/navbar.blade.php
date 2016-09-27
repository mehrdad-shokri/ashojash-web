<nav class="navbar navbar-default free-sans-font-only">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand p0" href="/" style="background-image: {{asset("img/static/header_logo.jpg")}}">
                <img alt="Brand" src="{{asset("img/static/header_logo.jpg")}}">

            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            {{-- Left navbar --}}
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">شهرها <span class="caret"></span></a>
                    <ul class="dropdown-menu rtl">
                        @foreach($cities as $city)
                            <li><a href="{{action('CitiesController@setCity',$city->slug)}}">{{$city->name}}</a></li>
                        @endforeach

                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">دسته بندی ها<span class="caret"></span></a>
                    <ul class="dropdown-menu rtl">
                        @foreach($navbarCuisines as $cuisine)
                            <li>
                                <a href="{{action('CitiesController@allVenuesCuisine',[$currentCity->slug,$cuisine->slug])}}">{{$cuisine->name}}</a>
                            </li>
                        @endforeach

                    </ul>
                </li>
                <li><a href="{{action("PagesController@addPlace")}}" class="{{UI::activeMenu('add-place')}}">افرودن
                        رستوران</a></li>
                <li><a href="{{action("PagesController@about")}}" class="{{UI::activeMenu('how-it-works')}}">چطور کار
                        میکند؟</a></li>
                <li><a href="{{action("PagesController@businessOwners")}}" class="{{UI::activeMenu('biz-owner')}}">صاحبان
                        کسب و کار</a></li>


            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="feedback-list-item">
                    @if(!Cookie::get("ashojash_feedback"))
                        <a class="toggle-feedback-modal" id="header-feedback-button" href="#">
                            <p>
                                بازخورد
                            </p>
                        </a>
                    @endif
                </li>
                @include('layouts.partials.user-roles-dropdown')
                @include('layouts.partials.user-dropdown')

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>