<?php

namespace Depotwarehouse\SoDoge\Tests\Model;

use Depotwarehouse\SoDoge\Model\Shibe;
use Depotwarehouse\SoDoge\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use File;

class ShibeTest extends TestCase
{

    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_returns_the_finished_path_attribute()
    {
        $shibe = new Shibe([ 'hash' => 'some_hash' ]);

        $this->assertEquals(public_path() . "/img/finished/some_hash", $shibe->finished_path);
    }

    /**
     * @test
     */
    public function it_returns_the_finished_url_path_attribute()
    {
        $shibe = new Shibe([ 'hash' => 'some_hash' ]);

        $this->assertEquals("/img/finished/some_hash", $shibe->finished_url);
    }

    /**
     * @test
     */
    public function it_increments_view_count_when_viewed()
    {

        Shibe::create([ 'hash' => 'some_hash', 'views' => 2 ]);

        $shibes = new Shibe();

        File::shouldReceive('exists')->andReturn(true);
        $shibe = $shibes->view("some_hash");

        $this->assertInstanceOf(Shibe::class, $shibe);
        $this->seeInDatabase('shibes', [ 'hash' => 'some_hash', 'views' => 3 ]);
    }

    /**
     * @test
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function it_throws_exception_when_trying_to_view_a_file_that_does_not_exist()
    {
        Shibe::create([ 'hash' => 'some_hash', 'views' => 2 ]);

        $shibes = new Shibe();

        File::shouldReceive('exists')->andReturn(false);
        $shibe = $shibes->view("some_hash");

        $this->fail("A ModelNotFoundException should be thrown");
    }

}
