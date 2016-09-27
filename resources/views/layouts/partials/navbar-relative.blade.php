<style>
    .navbar .navbar-nav {
        display: inline-block;
        float: none;
        vertical-align: top;
    }

    .navbar .navbar-collapse {
        text-align: center;
    }
</style>
<nav class="navbar navbar-default first-page-navbar">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->


        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            {{-- Left navbar --}}
            <ul class="nav navbar-nav">
                <li><a href="{{url('/')}}"><img src="{{asset("img/static/header_logo.jpg")}}" alt="picture"></a></li>
            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>