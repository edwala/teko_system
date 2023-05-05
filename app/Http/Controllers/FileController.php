<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Document;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.files.index', compact('files', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', File::class);

        $documents = Document::pluck('name', 'id');

        return view('app.files.create', compact('documents'));
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

        return redirect()
            ->route('files.edit', $file)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, File $file)
    {
        $this->authorize('view', $file);

        return view('app.files.show', compact('file'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, File $file)
    {
        $this->authorize('update', $file);

        $documents = Document::pluck('name', 'id');

        return view('app.files.edit', compact('file', 'documents'));
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

        return redirect()
            ->route('files.edit', $file)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('files.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
