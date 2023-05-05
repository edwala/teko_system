<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\File;
use App\Models\Document;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentFilesTest extends TestCase
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
    public function it_gets_document_files()
    {
        $document = Document::factory()->create();
        $files = File::factory()
            ->count(2)
            ->create([
                'document_id' => $document->id,
            ]);

        $response = $this->getJson(
            route('api.documents.files.index', $document)
        );

        $response->assertOk()->assertSee($files[0]->file);
    }

    /**
     * @test
     */
    public function it_stores_the_document_files()
    {
        $document = Document::factory()->create();
        $data = File::factory()
            ->make([
                'document_id' => $document->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.documents.files.store', $document),
            $data
        );

        $this->assertDatabaseHas('files', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $file = File::latest('id')->first();

        $this->assertEquals($document->id, $file->document_id);
    }
}
