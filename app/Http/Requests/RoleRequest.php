<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->method() === 'POST' ?
            can_do('create-role')
            : can_do('edit-role');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:roles,name,' . $this->role?->id],
            'display_name' => ['required', 'unique:roles,display_name,' . $this->role?->id]
        ];
    }
}
