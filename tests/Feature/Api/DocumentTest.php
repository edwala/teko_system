<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Document;

use App\Models\Client;
use App\Models\Company;
use App\Models\Employee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentTest extends TestCase
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
    public function it_gets_documents_list()
    {
        $documents = Document::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.documents.index'));

        $response->assertOk()->assertSee($documents[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_document()
    {
        $data = Document::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.documents.store'), $data);

        $this->assertDatabaseHas('documents', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_document()
    {
        $document = Document::factory()->create();

        $company = Company::factory()->create();
        $client = Client::factory()->create();
        $employee = Employee::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'content' => $this->faker->text,
            'revision' => $this->faker->date,
            'category' => $this->faker->text(255),
            'company_id' => $company->id,
            'client_id' => $client->id,
            'employee_id' => $employee->id,
        ];

        $response = $this->putJson(
            route('api.documents.update', $document),
            $data
        );

        $data['id'] = $document->id;

        $this->assertDatabaseHas('documents', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_document()
    {
        $document = Document::factory()->create();

        $response = $this->deleteJson(
            route('api.documents.destroy', $document)
        );

        $this->assertSoftDeleted($document);

        $response->assertNoContent();
    }
}
