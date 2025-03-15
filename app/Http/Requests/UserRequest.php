<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return isHQ();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'UserID' => ['required'],
            'UserName' => ['required'],
            'Password' => $this->method() === 'POST' ? 'required' : 'nullable',
            'SupervisorID' => ['required'],
            'Level' => ['required'],
        ];
    }
}
