<?php

namespace Modules\CoreCRM\Http\Requests;

use Modules\BaseCore\Http\Requests\PersonneStoreRequest;

class ClientStoreRequest extends PersonneStoreRequest
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
        return Parent::rules();
    }
}
