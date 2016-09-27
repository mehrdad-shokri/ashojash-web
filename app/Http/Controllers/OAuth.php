<?php
	/**
	 * Created by PhpStorm.
	 * User: admin
	 * Date: 10/2/2015
	 * Time: 5:02 PM
	 */

	namespace App\Http\Controllers;


	use Illuminate\Http\Request;

	interface OAuth {

		function redirectProvider();

		function handleProviderCallback(Request $request);


	}