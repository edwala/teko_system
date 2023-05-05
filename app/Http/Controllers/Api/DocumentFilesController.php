<?php

namespace App\Http\Controllers\Api;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Resources\FileResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\FileCollection;

class DocumentFilesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Document $document
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Document $document)
    {
        $this->authorize('view', $document);

        $search = $request->get('search', '');

        $files = $document
            ->files()
            ->search($search)
            ->latest()
            ->paginate();

        return new FileCollection($files);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Document $document
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Document $document)
    {
        $this->authorize('create', File::class);

        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
            'file' => ['nullable', 'file'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $file = $document->files()->create($validated);

        return new FileResource($file);
    }
}
