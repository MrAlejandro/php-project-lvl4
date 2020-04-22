<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Label;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::all();
        return view('label.index', compact('labels'));
    }

    public function create()
    {
        $label = new Label();
        $this->authorize('create', $label);

        return view('label.create', compact('label'));
    }

    public function store(Request $request)
    {
        $this->authorize('store', Label::class);

        $data = $this->validate($request, [
            'name' => 'required|unique:labels',
        ]);

        Label::create($data);
        flash(__('flash.label.store.success'))->success();

        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        $this->authorize('store', $label);

        return view('label.edit', compact('label'));
    }

    public function update(Request $request, Label $label)
    {
        $this->authorize('update', $label);

        $data = $this->validate($request, [
            'name' => 'required|unique:labels,name,' . $label->id,
        ]);

        $label->update($data);
        flash(__('flash.label.update.success'))->success();

        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        $this->authorize('destroy', $label);

        $label->delete();

        return redirect()->route('labels.index');
    }
}
