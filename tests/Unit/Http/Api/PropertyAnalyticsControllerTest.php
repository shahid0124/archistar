<?php

namespace Tests\Unit\Http\Api;

use App\Models\Properties;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PropertyAnalyticsControllerTest extends TestCase
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
     * test to create attach property Analytics
     *
     * @return void
     */
    public function testCreatePropertyAnalytics()
    {
        //Throws 422 for analytics is already attached to that property
        $this->json('post', '/api/properties/1/analytics/1', [
            'value' => 'this is test'
        ])
            ->assertStatus(422)
            ->assertExactJson(
                ['message' => 'Property Analytics Already Exists']
            );

        //Throws 404 for analytics not present
        $this->json('post', '/api/properties/1/analytics/100', [
            'value' => 'this is test'
        ])
            ->assertStatus(404)
            ->assertExactJson(
                ['message' => 'Analytics Type Does Not Exist']
            );

        $this->json('post', '/api/properties/1/analytics/2', [
            'value' => 'this is test'
        ])
            ->assertStatus(200)
            ->assertExactJson(
                ['message' => 'Analytics attached to property']
            );
    }

    /**
     * Test for updating analytics for a property
     *
     * @return void
     */
    public function testUpdatePropertyAnalytics()
    {
        $property = Properties::find(1);

        $propertyAnalytics = $property->propertyAnalytics();

        foreach ($propertyAnalytics->get() as $propertyAnalyticKey => $propertyAnalytic) {
            $this->assertEquals(1, $propertyAnalytic->pivot->analytic_type_id);
        }

        //Checks for non existing analytic and does not allow update
        $this->json('patch', '/api/properties/1/analytics/3', [
            'value' => 'this is test',
            'analytic_type_id' => 3
        ])
            ->assertStatus(404)
            ->assertExactJson(['message' => 'Property Analytics Does Not Exist']);

        //Update the Anayltics
        $this->json('patch', '/api/properties/1/analytics/1', [
            'value' => 'this is test',
            'analytic_type_id' => 3
        ])
            ->assertStatus(200)
            ->assertExactJson(['message' => 'Property Analytics has been updated']);

        foreach ($propertyAnalytics->get() as $propertyAnalyticKey => $propertyAnalytic) {
            $this->assertEquals(3, $propertyAnalytic->pivot->analytic_type_id);
        }
    }
}
