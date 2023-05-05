<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Template;

use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_templates_list()
    {
        $templates = Template::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.templates.index'));

        $response->assertOk()->assertSee($templates[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_template()
    {
        $data = Template::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.templates.store'), $data);

        $this->assertDatabaseHas('templates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_template()
    {
        $template = Template::factory()->create();

        $company = Company::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'content' => $this->faker->text,
            'company_id' => $company->id,
        ];

        $response = $this->putJson(
            route('api.templates.update', $template),
            $data
        );

        $data['id'] = $template->id;

        $this->assertDatabaseHas('templates', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_template()
    {
        $template = Template::factory()->create();

        $response = $this->deleteJson(
            route('api.templates.destroy', $template)
        );

        $this->assertSoftDeleted($template);

        $response->assertNoContent();
    }
}
