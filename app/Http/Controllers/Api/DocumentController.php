<?php

namespace App\Http\Controllers\Api;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\DocumentCollection;
use App\Http\Requests\DocumentStoreRequest;
use App\Http\Requests\DocumentUpdateRequest;

class DocumentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Document::class);

        $search = $request->get('search', '');

        $documents = Document::search($search)
            ->latest()
            ->paginate();

        return new DocumentCollection($documents);
    }

    /**
     * @param \App\Http\Requests\DocumentStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentStoreRequest $request)
    {
        $this->authorize('create', Document::class);

        $validated = $request->validated();

        $document = Document::create($validated);

        return new DocumentResource($document);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Document $document
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Document $document)
    {
        $this->authorize('view', $document);

        return new DocumentResource($document);
    }

    /**
     * @param \App\Http\Requests\DocumentUpdateRequest $request
     * @param \App\Models\Document $document
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentUpdateRequest $request, Document $document)
    {
        $this->authorize('update', $document);

        $validated = $request->validated();

        $document->update($validated);

        return new DocumentResource($document);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Document $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Document $document)
    {
        $this->authorize('delete', $document);

        $document->delete();

        return response()->noContent();
    }
}
