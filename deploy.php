<?php
require_once "deploy/common.php";
require_once "deploy/laravel.php";

server('mainServer', '94.23.98.194', 22)
	->user('root')
	->password("nahuwuwRusa3uWrUv2bruchebre6ra4u")
	->stage('production')
	->env('branch', 'master')
	->env('deploy_path', '/var/www/ashojash');

set('repository', 'git@bitbucket.org:ashojash/web.git');
set('keep_releases', 3);
set('default_stage', 'production');

