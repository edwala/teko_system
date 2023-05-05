<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Resources\FileResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\FileCollection;
use App\Http\Requests\FileStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FileUpdateRequest;

class FileController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', File::class);

        $search = $request->get('search', '');

        $files = File::search($search)
            ->latest()
            ->paginate();

        return new FileCollection($files);
    }

    /**
     * @param \App\Http\Requests\FileStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileStoreRequest $request)
    {
        $this->authorize('create', File::class);

        $validated = $request->validated();
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $file = File::create($validated);

        return new FileResource($file);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, File $file)
    {
        $this->authorize('view', $file);

        return new FileResource($file);
    }

    /**
     * @param \App\Http\Requests\FileUpdateRequest $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function update(FileUpdateRequest $request, File $file)
    {
        $this->authorize('update', $file);

        $validated = $request->validated();

        if ($request->hasFile('file')) {
            if ($file->file) {
                Storage::delete($file->file);
            }

            $validated['file'] = $request->file('file')->store('public');
        }

        $file->update($validated);

        return new FileResource($file);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, File $file)
    {
        $this->authorize('delete', $file);

        if ($file->file) {
            Storage::delete($file->file);
        }

        $file->delete();

        return response()->noContent();
    }
}
