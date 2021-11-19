<?php

namespace Modules\CoreCRM\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PipelineUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string',
            'status' => 'array',
            'ici' => 'required'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
