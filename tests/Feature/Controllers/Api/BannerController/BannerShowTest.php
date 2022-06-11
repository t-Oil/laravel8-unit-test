<?php

namespace Tests\Feature\Controllers\Api\BannerController;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Carbon\Carbon;

class BannerShowTest extends TestCase
{
    protected $header = [];

    private function mockedActingAsMember()
    {
        $mockUser = User::factory()->create();

        $this->actingAs($mockUser, 'api');

        $this->header = [
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($mockUser),
        ];

        return $mockUser;
    }

    /**
     * @return void
     * @group BannerShowTest
     * @group testShowBannerTestWithoutAuthorizationShouldBeFails
     */
    public function testShowBannerTestWithoutAuthorizationShouldBeFails()
    {
        Banner::factory()->count(3)->create();

        $response = $this->json('GET', route('frontend.banners.show', 1), []);

        $this->assertEquals('Authorization Token not found', $response->json('status'));
    }

    /**
     * @return void
     * @group BannerShowTest
     * @group testShowBannerTestNotFoundShouldBeFails
     */
    public function testShowBannerTestNotFoundShouldBeFails()
    {
        $this->mockedActingAsMember();
        Banner::factory()->count(3)->create();

        $response = $this->json('GET', route('frontend.banners.show', 10), [], $this->header);

        $this->assertEquals(404, $response->json('status'));
        $this->assertNull($response->json('data'));
    }

    /**
     * @return void
     * @group BannerShowTest
     * @group testShowBannerTestInActiveShouldBeFails
     */
    public function testShowBannerTestInActiveShouldBeFails()
    {
        $this->mockedActingAsMember();
        Banner::factory()->count(3)->create([
            'is_active' => 0
        ]);

        $response = $this->json('GET', route('frontend.banners.show', 3), [], $this->header);

        $this->assertEquals(404, $response->json('status'));
        $this->assertNull($response->json('data'));
        $this->assertCount(3, Banner::all());
    }

    /**
     * @return void
     * @group BannerShowTest
     * @group testShowBannerTestShouldBeOk
     */
    public function testShowBannerTestShouldBeOk()
    {
        $this->mockedActingAsMember();
        Banner::factory()->count(3)->create();

        $response = $this->json('GET', route('frontend.banners.show', 3), [], $this->header);

        $this->assertEquals(200, $response->json('status'));
        $response->assertJsonStructure([
            'status',
            'data' => [
                'uuid',
                'title',
                'image',
                'target'
            ]
        ]);
    }
}
