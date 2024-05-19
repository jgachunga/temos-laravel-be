<?php namespace Tests\Repositories;

use App\Models\UserRoute;
use App\Repositories\Backend\UserRouteRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserRouteRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserRouteRepository
     */
    protected $userRouteRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userRouteRepo = \App::make(UserRouteRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_route()
    {
        $userRoute = factory(UserRoute::class)->make()->toArray();

        $createdUserRoute = $this->userRouteRepo->create($userRoute);

        $createdUserRoute = $createdUserRoute->toArray();
        $this->assertArrayHasKey('id', $createdUserRoute);
        $this->assertNotNull($createdUserRoute['id'], 'Created UserRoute must have id specified');
        $this->assertNotNull(UserRoute::find($createdUserRoute['id']), 'UserRoute with given id must be in DB');
        $this->assertModelData($userRoute, $createdUserRoute);
    }

    /**
     * @test read
     */
    public function test_read_user_route()
    {
        $userRoute = factory(UserRoute::class)->create();

        $dbUserRoute = $this->userRouteRepo->find($userRoute->id);

        $dbUserRoute = $dbUserRoute->toArray();
        $this->assertModelData($userRoute->toArray(), $dbUserRoute);
    }

    /**
     * @test update
     */
    public function test_update_user_route()
    {
        $userRoute = factory(UserRoute::class)->create();
        $fakeUserRoute = factory(UserRoute::class)->make()->toArray();

        $updatedUserRoute = $this->userRouteRepo->update($fakeUserRoute, $userRoute->id);

        $this->assertModelData($fakeUserRoute, $updatedUserRoute->toArray());
        $dbUserRoute = $this->userRouteRepo->find($userRoute->id);
        $this->assertModelData($fakeUserRoute, $dbUserRoute->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_route()
    {
        $userRoute = factory(UserRoute::class)->create();

        $resp = $this->userRouteRepo->delete($userRoute->id);

        $this->assertTrue($resp);
        $this->assertNull(UserRoute::find($userRoute->id), 'UserRoute should not exist in DB');
    }
}
