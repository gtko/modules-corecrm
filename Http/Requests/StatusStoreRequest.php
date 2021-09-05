<?php

namespace Modules\CoreCRM\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $label
 * @property int $weight
 * @property string $color
 */
class StatusStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label' => ['required', 'unique:statuses', 'max:255', 'string'],
            'weight' => ['numeric'],
            'color' => ['required', 'string']
        ];
    }
}
