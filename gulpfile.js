var elixir = require('laravel-elixir');
var autoprefixer = require('gulp-autoprefixer');
var sass = require('gulp-sass');
var gulp = require('gulp');
var minifyCss = require('gulp-minify-css');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    /*
     * STYLESHEET FILES
     * */
    mix.copy('node_modules/sweetalert/dev/sweetalert.scss', 'resources/assets/sass/libs/sweetalert.scss');
    mix.copy('node_modules/bootstrap-sass/assets/stylesheets/bootstrap', 'resources/assets/sass/bootstrap');
    mix.copy('node_modules/bootstrap-sass/assets/stylesheets/_bootstrap.scss', 'resources/assets/sass/_bootstrap.scss');
    mix.copy('node_modules/font-awesome/scss', 'resources/assets/sass/font-awesome/');
    mix.copy('node_modules/ionicons/scss', 'resources/assets/sass/ionicons/');
    mix.copy('node_modules/font-awesome/fonts', 'public/fonts');
    mix.copy('node_modules/ionicons/fonts', 'public/fonts');
    mix.copy('node_modules/timepicker/jquery.timepicker.css', 'public/css/jquery.timepicker.css')
    mix.copy("bower_components/jquery-bar-rating/dist/themes/bars-1to10.css", "public/css/bars-1to10.css");
    mix.copy("bower_components/jquery-bar-rating/dist/themes/fontawesome-stars.css", "public/css/fontawesome-stars.css");
    mix.copy("bower_components/jquery-bar-rating/dist/themes/bars-horizontal.css", "public/css/bars-horizontal.css");

    // mix.styles(['libs/sweetalert.css'],'public/css/libs.css','resources/assets/sass');
    mix.copy('node_modules/photoswipe/dist/photoswipe.css', 'public/css/image-gallery.css');
    mix.copy('node_modules/photoswipe/dist/default-skin/default-skin.css', 'public/css/image-gallery-skin.css');
    mix.copy("node_modules/dropzone/dist/min/dropzone.min.css", "public/css/dropzone.min.css");
    mix.copy("node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css", "public/css/bootstrap-datepicker.min.css");
    /*
     *  JAVASCRIPT FILES
     * */
    mix.copy('node_modules/sweetalert/dist/sweetalert.min.js', 'resources/assets/js/vendor/sweetalert.min.js');
    //mix.copy('node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js', 'resources/assets/js/bootstrap.min.js');
    mix.copy('node_modules/timepicker/jquery.timepicker.min.js', 'public/js/jquery.timepicker.min.js')
    mix.copy('node_modules/photoswipe/dist/photoswipe.min.js', 'public/js/image-gallery.min.js')
    mix.copy('node_modules/photoswipe/dist/photoswipe-ui-default.min.js', 'public/js/image-gallery-skin.min.js')
    mix.copy("bower_components/typeahead.js/dist/bloodhound.min.js", "public/js/bloodhound.min.js");
    mix.copy("bower_components/typeahead.js/dist/typeahead.bundle.min.js", "public/js/typeahead.bundle.min.js");
    mix.copy("bower_components/typeahead.js/dist/typeahead.jquery.min.js", "public/js/typeahead.jquery.min.js");
    mix.copy("bower_components/jquery-bar-rating/dist/jquery.barrating.min.js", "public/js/jquery.barrating.min.js");
    mix.copy("node_modules/dropzone/dist/min/dropzone.min.js", "public/js/dropzone.min.js");
    mix.copy("node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js", "public/js/bootstrap-datepicker.min.js")
    mix.scripts('admin.table.js', 'public/js/admin.table.js');
    mix.scripts('add-clock-picker.js', 'public/js/add-clock-picker.js');
    mix.scripts('follows.js', 'public/js/follows.js');
    mix.scripts('upload-profile-pic.js', 'public/js/upload-profile-pic.js');
    mix.scripts(['vendor/jquery.js', 'app.js', 'vendor/modernizr.js', 'vendor/fastclick.js', 'vendor/jquery.cookie.js', 'vendor/sweetalert.min.js', 'bootstrap.min.js'], "public/js/app.js");
    mix.scripts('echo.js', "public/js/async-loader.js");
    mix.scripts('menu.js', "public/js/menu.js");
    mix.scripts('review.js', "public/js/review.js");
    mix.scripts('ban-user.js', 'public/js/ban-user.js');
    mix.scripts('assign-owner.js', "public/js/assign-owner.js");
    mix.scripts("search.js", "public/js/search.js");
    mix.scripts("search-user.js", "public/js/search-user.js");
    mix.scripts("hero-quote.js", "public/js/hero-quote.js");
    mix.scripts("delete-review.js", "public/js/delete-review.js");
    mix.scripts("review-loader.js", "public/js/review-loader.js");
    mix.scripts("admin.js", "public/js/admin.js");

    /**/
    mix.task('css')
});

gulp.task('css', function () {
    //gulp.src('resources/assets/sass/**/*.scss')
    gulp.src('resources/assets/sass/app.scss')
        .pipe(sass())
        .pipe(minifyCss())
        .pipe(autoprefixer({
            browsers: ['last 10 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/css'));
    /*gulp.src('resources/assets/sass/owner.scss')
     .pipe(sass())
     .pipe(minifyCss())
     .pipe(autoprefixer({
     browsers: ['last 10 versions'],
     cascade: false
     }))
     .pipe(gulp.dest('public/css'));*/
    gulp.src('resources/assets/sass/home.scss')
        .pipe(sass())
        .pipe(minifyCss())
        .pipe(autoprefixer({
            browsers: ['last 10 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/css'));
    gulp.src('resources/assets/sass/venue-show.scss')
        .pipe(sass())
        .pipe(minifyCss())
        .pipe(autoprefixer({
            browsers: ['last 10 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/css'));
    gulp.src('resources/assets/sass/biz-owner.scss')
        .pipe(sass())
        .pipe(minifyCss())
        .pipe(autoprefixer({
            browsers: ['last 10 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/css'));
    gulp.src('resources/assets/sass/user-profile.scss')
        .pipe(sass())
        .pipe(minifyCss())
        .pipe(autoprefixer({
            browsers: ['last 10 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/css'));
    gulp.src('resources/assets/sass/cuisine.scss')
        .pipe(sass())
        .pipe(minifyCss())
        .pipe(autoprefixer({
            browsers: ['last 10 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/css'));
    gulp.src(['resources/assets/sass/admin/*.scss'])
        .pipe(sass())
        .pipe(minifyCss())
        .pipe(autoprefixer({
            browsers: ['last 10 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/css/'));
    /*gulp.src('resources/assets/sass/admin/sidebar.scss')
     .pipe(sass())
     .pipe(minifyCss())
     .pipe(autoprefixer({
     browsers: ['last 10 versions'],
     cascade: false
     }))
     .pipe(gulp.dest('public/css'));*/
});
