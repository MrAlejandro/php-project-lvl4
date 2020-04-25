<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelRequest extends FormRequest
{
    public function rules()
    {
        $label = $this->route('label');
        if ($label) {
            return [
                'name' => 'required|unique:labels,name,' . $label->id,
            ];
        }

        return [
            'name' => 'required|unique:labels',
        ];
    }
}
