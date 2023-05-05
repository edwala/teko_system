<?php

namespace App\Http\Controllers\Api;

use App\Models\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\TemplateResource;
use App\Http\Resources\TemplateCollection;
use App\Http\Requests\TemplateStoreRequest;
use App\Http\Requests\TemplateUpdateRequest;

class TemplateController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Template::class);

        $search = $request->get('search', '');

        $templates = Template::search($search)
            ->latest()
            ->paginate();

        return new TemplateCollection($templates);
    }

    /**
     * @param \App\Http\Requests\TemplateStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateStoreRequest $request)
    {
        $this->authorize('create', Template::class);

        $validated = $request->validated();
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $template = Template::create($validated);

        return new TemplateResource($template);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Template $template
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Template $template)
    {
        $this->authorize('view', $template);

        return new TemplateResource($template);
    }

    /**
     * @param \App\Http\Requests\TemplateUpdateRequest $request
     * @param \App\Models\Template $template
     * @return \Illuminate\Http\Response
     */
    public function update(TemplateUpdateRequest $request, Template $template)
    {
        $this->authorize('update', $template);

        $validated = $request->validated();

        if ($request->hasFile('file')) {
            if ($template->file) {
                Storage::delete($template->file);
            }

            $validated['file'] = $request->file('file')->store('public');
        }

        $template->update($validated);

        return new TemplateResource($template);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Template $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Template $template)
    {
        $this->authorize('delete', $template);

        if ($template->file) {
            Storage::delete($template->file);
        }

        $template->delete();

        return response()->noContent();
    }
}
