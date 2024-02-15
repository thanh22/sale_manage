<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'              => 'required|string|min:1|max:30',
            'email'             => [
                'required',
                'email',
                'max:50',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('email', request()->email);
                })->whereNull('deleted_at'),
            ]
        ];
    }

    /**
     * @return [type]
     */
    public function attributes()
    {
        return [];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'       => __('message.MSG_001', ['attribute' => 'name']),
            'name.min'            => __('message.MSG_002', ['attribute' => 'name', "min" => 1, "max" => 30]),
            'name.max'            => __('message.MSG_002', ['attribute' => 'name', "min" => 1, "max" => 30]),
            'email.required'      => __('message.MSG_001', ['attribute' => 'email']),
            'email.email'         => __('message.MSG_009'),
            'email.max'           => __('message.MSG_006', ['attribute' => 'email', "max" => 50]),
            'email.unique'        => __('message.MSG_010'),
        ];
    }
}
