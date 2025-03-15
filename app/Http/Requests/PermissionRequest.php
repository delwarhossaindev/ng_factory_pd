<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->method() === 'POST' ?
            can_do('create-permission')
            : can_do('edit-permission');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:permissions,name,' . $this->permission?->id],
            'display_name' => ['required', 'unique:permissions,display_name,' . $this->permission?->id],
            'description' => 'required'
        ];
    }
}
