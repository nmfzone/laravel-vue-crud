<?php

namespace App\Http\Requests;

class UserRequest extends FormRequest
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
        $user = $this->route('user');

        $rules = collect([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        switch ($this->method()) {
            case 'POST':
                return $rules->toArray();
            case 'PUT':
            case 'PATCH':
                return $rules->merge([
                    'email' => $rules->get('email') . ',email,' . $user->id,
                ])->toArray();
        }
    }
}
