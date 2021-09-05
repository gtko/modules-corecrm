<?php

namespace Modules\CoreCRM\Http\Requests;

use Illuminate\Validation\Rule;

class StatusUpdateRequest extends StatusStoreRequest
{
    public function rules()
    {
        return [
            'label' => ['required',  Rule::unique('statuses')->ignore($this->route()->status->id), 'max:255', 'string'],
            'weight' => ['numeric'],
            'color' => ['required', 'string']
        ];
    }
}
