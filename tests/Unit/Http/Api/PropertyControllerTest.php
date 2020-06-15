<?php

namespace Tests\Unit\Http\Api;

use App\Http\Resources\AnalyticsTypeResource;
use App\Models\Properties;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PropertyControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed --class=PropertySeeder');
        $this->artisan('db:seed --class=AnalyticTypeSeeder');
        $this->artisan('db:seed --class=PropertyAnalyticsSeeder');
    }

    /**
     * test Analytics by Property Id.
     *
     * @return void
     */
    public function testGetAnalyticsByPropertyId()
    {
        $property = Properties::find(10);

        $response = $this->json('get', 'api/properties/10');

        $response->assertExactJson((AnalyticsTypeResource::collection($property->propertyAnalytics()->get()))->response()->getData(true));
        $response->assertOk();
    }

    /**
     * test Analytics by Property Id for noe existent id.
     *
     * @return void
     */
    public function testGetAnalyticsThrows422ForNonExistProperty()
    {
        $this->json('get', 'api/properties/20000')
            ->assertStatus(404)
            ->assertExactJson(['message' => 'Property Not found.']);;
    }

    /**
     * test to create the property in database
     *
     * @return void
     */
    public function testToCreateProperty()
    {
        $property = [
            'suburb' => 'Doonside',
            'state' => 'NSW',
            'country' => 'Australia',
        ];

        Properties::query()->delete();

        /** Delete all the rows for the current test and then create a new one . At end we should have one row in database*/
        $this->assertEmpty(Properties::all());

        $this->json('POST', '/api/properties', $property)
            ->assertOk()
            ->assertExactJson(
                ['message' => 'Property Created']
            );

        $this->assertEquals(1, Properties::count());
    }

    /**
     * test to get summary by suburb
     *
     * @return void
     */
    public function testGetSummaryBySuburb()
    {
       $this->json('get', 'api/properties/summary_by_suburb/Parramatta')
           ->assertOk();
    }

    /**
     * test to get summary by Country
     *
     * @return void
     */
    public function testGetSummaryByCountry()
    {
        $this->json('get', 'api/properties/summary_by_country/Australia')
            ->assertOk();
    }

    /**
     * test to get summary by State
     *
     * @return void
     */
    public function testGetSummaryByState()
    {
       $this->json('get', 'api/properties/summary_by_state/NSW')
           ->assertOk();
    }
}


