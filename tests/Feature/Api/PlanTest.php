<?php

namespace Tests\Feature\Api;

use App\Models\Plant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PlanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_list_all_plants()
    {
        $plan1 = Plant::factory()->create();
        $plan2 = Plant::factory()->create();

        $this->getJson(route('api.plants.index'))
            ->assertJsonFragment(['id'=>$plan1->id])
            ->assertJsonFragment(['id'=>$plan2->id]);
    }

    /** @test */
    public function can_store_a_plant()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('image1.png');

        $response = $this->postJson(route('api.plants.store'),[
            'name' => $name = 'plan 1',
            'species' => $species = 'species 1',
            'watering_instructions' => '<b>test</b>',
            'image' => $image
        ]);

        $this->assertDatabaseHas('plants',[
            'name' => $name,
            'species' => $species
        ]);
    }
}
