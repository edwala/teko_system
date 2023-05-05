<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Template;

use App\Models\Company;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_templates()
    {
        $templates = Template::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('templates.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.templates.index')
            ->assertViewHas('templates');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_template()
    {
        $response = $this->get(route('templates.create'));

        $response->assertOk()->assertViewIs('app.templates.create');
    }

    /**
     * @test
     */
    public function it_stores_the_template()
    {
        $data = Template::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('templates.store'), $data);

        $this->assertDatabaseHas('templates', $data);

        $template = Template::latest('id')->first();

        $response->assertRedirect(route('templates.edit', $template));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_template()
    {
        $template = Template::factory()->create();

        $response = $this->get(route('templates.show', $template));

        $response
            ->assertOk()
            ->assertViewIs('app.templates.show')
            ->assertViewHas('template');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_template()
    {
        $template = Template::factory()->create();

        $response = $this->get(route('templates.edit', $template));

        $response
            ->assertOk()
            ->assertViewIs('app.templates.edit')
            ->assertViewHas('template');
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

        $response = $this->put(route('templates.update', $template), $data);

        $data['id'] = $template->id;

        $this->assertDatabaseHas('templates', $data);

        $response->assertRedirect(route('templates.edit', $template));
    }

    /**
     * @test
     */
    public function it_deletes_the_template()
    {
        $template = Template::factory()->create();

        $response = $this->delete(route('templates.destroy', $template));

        $response->assertRedirect(route('templates.index'));

        $this->assertSoftDeleted($template);
    }
}
