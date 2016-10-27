<?php
/* (c) Anton Medvedev <anton@medv.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__ . '/common.php';
// This recipe support Laravel 5.1+, with orther version, please see document https://github.com/deployphp/docs

// Laravel shared dirs
set('shared_dirs', [
	'storage/app',
	'storage/framework/cache',
	'storage/framework/sessions',
	'storage/framework/views',
	'storage/logs',
]);
// Laravel 5 shared file
set('shared_files', ['.env']);

// Laravel writable dirs
set('writable_dirs', ['bootstrap/cache', 'storage', 'vendor', 'storage/*', 'storage/*/*', 'bootstrap/cache/*']);


/**
 * Main task
 */
task('deploy', [
	'deploy:prepare',
	'deploy:release',
	'deploy:update_code',
	'deploy:vendors',
	'deploy:shared',
	'deploy:symlink',
	'deploy:writable',
	'cleanup',
	'environment:copy',
	/*'db:migrate',*/
	'success'
])->desc('Deploy your project');