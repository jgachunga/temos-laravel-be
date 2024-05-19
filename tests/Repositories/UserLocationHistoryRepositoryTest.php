<?php namespace Tests\Repositories;

use App\Models\UserLocationHistory;
use App\Repositories\Backend\UserLocationHistoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserLocationHistoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserLocationHistoryRepository
     */
    protected $userLocationHistoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userLocationHistoryRepo = \App::make(UserLocationHistoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_location_history()
    {
        $userLocationHistory = factory(UserLocationHistory::class)->make()->toArray();

        $createdUserLocationHistory = $this->userLocationHistoryRepo->create($userLocationHistory);

        $createdUserLocationHistory = $createdUserLocationHistory->toArray();
        $this->assertArrayHasKey('id', $createdUserLocationHistory);
        $this->assertNotNull($createdUserLocationHistory['id'], 'Created UserLocationHistory must have id specified');
        $this->assertNotNull(UserLocationHistory::find($createdUserLocationHistory['id']), 'UserLocationHistory with given id must be in DB');
        $this->assertModelData($userLocationHistory, $createdUserLocationHistory);
    }

    /**
     * @test read
     */
    public function test_read_user_location_history()
    {
        $userLocationHistory = factory(UserLocationHistory::class)->create();

        $dbUserLocationHistory = $this->userLocationHistoryRepo->find($userLocationHistory->id);

        $dbUserLocationHistory = $dbUserLocationHistory->toArray();
        $this->assertModelData($userLocationHistory->toArray(), $dbUserLocationHistory);
    }

    /**
     * @test update
     */
    public function test_update_user_location_history()
    {
        $userLocationHistory = factory(UserLocationHistory::class)->create();
        $fakeUserLocationHistory = factory(UserLocationHistory::class)->make()->toArray();

        $updatedUserLocationHistory = $this->userLocationHistoryRepo->update($fakeUserLocationHistory, $userLocationHistory->id);

        $this->assertModelData($fakeUserLocationHistory, $updatedUserLocationHistory->toArray());
        $dbUserLocationHistory = $this->userLocationHistoryRepo->find($userLocationHistory->id);
        $this->assertModelData($fakeUserLocationHistory, $dbUserLocationHistory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_location_history()
    {
        $userLocationHistory = factory(UserLocationHistory::class)->create();

        $resp = $this->userLocationHistoryRepo->delete($userLocationHistory->id);

        $this->assertTrue($resp);
        $this->assertNull(UserLocationHistory::find($userLocationHistory->id), 'UserLocationHistory should not exist in DB');
    }
}
