<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Label;

class LabelsController extends Controller
{
    public function index()
    {
        $labels = Label::all();
        return view('label.index', compact('labels'));
    }

    public function create()
    {
        Gate::authorize('authenticated-user');

        $label = new Label();
        return view('label.create', compact('label'));
    }

    public function store(Request $request)
    {
        Gate::authorize('authenticated-user');

        $data = $this->validate($request, [
            'name' => 'required|unique:labels',
        ]);

        Label::create($data);
        flash(__('flash.label.store.success'))->success();

        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        Gate::authorize('authenticated-user');

        return view('label.edit', compact('label'));
    }

    public function update(Request $request, Label $label)
    {
        Gate::authorize('authenticated-user');

        $data = $this->validate($request, [
            'name' => 'required|unique:labels,name,' . $label->id,
        ]);

        $label->update($data);
        flash(__('flash.label.update.success'))->success();

        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        $response = Gate::inspect('destroy', $label);

        if ($response->allowed()) {
            $label->delete();
            flash(__('flash.label.delete.success'))->success();
        } else {
            flash($response->message())->error();
        }

        return redirect()->route('labels.index');
    }
}
