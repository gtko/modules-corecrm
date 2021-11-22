<?php

namespace Modules\CoreCRM\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 *
 */
class PipelineStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
