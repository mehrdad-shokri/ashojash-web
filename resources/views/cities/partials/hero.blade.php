@if(!$currentUser)
    <section class="module parallax">
        <div class="container hero">
            <h2 class="home-banner cntr-align-txt">
                آشوجاش آخرین راهنمای شما برای
            </h2>

            <h1 id="hero-text" class="cntr-align-txt">Serene</h1>
            <a href="/register" class="iran-sans hero-register ">
                حساب کاربری رایگان خود را بسازید
            </a>
        </div>
        <footer class="hero-login">
            <a href="{{action("PagesController@about")}}">
                چطور کار می‌کند؟
            </a>
        </footer>
    </section>
@endif