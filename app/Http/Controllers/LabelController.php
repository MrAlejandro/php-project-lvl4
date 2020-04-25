<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
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
        $this->authorize($label);

        return view('label.create', compact('label'));
    }

    public function store(LabelRequest $request)
    {
        $label = Label::make();
        $this->authorize($label);

        $validatedData = $request->validated();
        $label->fill($validatedData)->save();

        flash(__('flash.label.store.success'))->success();

        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        $this->authorize($label);

        return view('label.edit', compact('label'));
    }

    public function update(LabelRequest $request, Label $label)
    {
        $this->authorize($label);
        $validatedData = $request->validated();

        $label->update($validatedData);
        flash(__('flash.label.update.success'))->success();

        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        $this->authorize($label);

        $label->delete();

        return redirect()->route('labels.index');
    }
}
