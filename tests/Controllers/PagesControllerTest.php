<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesControllerTest extends TestCase
{

    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        factory(App\City::class)->create([
            'name' => 'city 1',
            'slug' => 'city-1',
            'status'=>1
        ]);
    }

    public function testMainPageWithoutCookie()
    {
        $this
            ->visit('/')
            ->seeLink(null, '/city/set-city/city-1')
            ->seeText('city 1')
            ->click('city 1')
            ->seePageIs('/city/city-1')
            ->seeCookie('exp_current_city', 'city-1');
    }
    public function testStaticPages (){
    $this
        ->visit('/page/about')
        ->assertResponseOk()
        ->visit('/page/biz-owner')
        ->assertResponseOk()
        ->visit('/page/policies')
        ->assertResponseOk()
        ->visit('/page/cookie-policy');
    }
    public function testAddPlace (){
        $this->visit('/page/add-place')
            ->type('venue name','name')
            ->type('venue address','address')
            ->select('citySelector','')
            ->press('submit')
            ->seePageIs('/page/add-place')
            ->assertResponseOk()
            ->seeInDatabase('venues',['name'=>'venue name']);
    }
}
