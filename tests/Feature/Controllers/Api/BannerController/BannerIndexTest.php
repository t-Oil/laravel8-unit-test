<?php

namespace Tests\Feature\Controllers\Api\BannerController;

use App\Models\Banner;
use Tests\TestCase;
use Carbon\Carbon;

class BannerIndexTest extends TestCase
{
    /**
     * @return void
     * @group BannerIndexTest
     * @group testGetBannerNotFoundShouldBeFails
     */
    public function testGetBannerNotFoundShouldBeFails()
    {
        Banner::factory()->count(3)->create([
            'is_active' => 0
        ]);

        $response = $this->json('GET', route('frontend.banners.index'), []);

        $this->assertEquals(404, $response->json('status'));
        $this->assertCount(0, $response->json('data'));
        $this->assertCount(3, Banner::all());
    }

    /**
     * @return void
     * @group BannerIndexTest
     * @group testGetBannerShouldBeOk
     */
    public function testGetBannerShouldBeOk()
    {
        Banner::factory()->count(3)->create();

        Banner::factory()->create([
            'start_datetime' => Carbon::now()->subDays(7),
            'end_datetime' => Carbon::now()->subDays(7),
        ]);

        $response = $this->json('GET', route('frontend.banners.index'), []);

        $this->assertEquals(200, $response->json('status'));
        $this->assertCount(3, $response->json('data'));
        $this->assertCount(4, Banner::all());
    }
}
