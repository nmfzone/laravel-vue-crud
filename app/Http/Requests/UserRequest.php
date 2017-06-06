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
                    'password' => '',
                ])->toArray();
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $validator->sometimes('password', 'string|min:6|confirmed', function ($input) {
                return ! is_null($input->password);
            });
        }
    }
}
