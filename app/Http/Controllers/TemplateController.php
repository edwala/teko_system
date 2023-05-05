<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.templates.index', compact('templates', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Template::class);

        $companies = Company::pluck('company_name', 'id');

        return view('app.templates.create', compact('companies'));
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

        return redirect()
            ->route('templates.edit', $template)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Template $template
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Template $template)
    {
        $this->authorize('view', $template);

        return view('app.templates.show', compact('template'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Template $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Template $template)
    {
        $this->authorize('update', $template);

        $companies = Company::pluck('company_name', 'id');

        return view('app.templates.edit', compact('template', 'companies'));
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

        return redirect()
            ->route('templates.edit', $template)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('templates.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
