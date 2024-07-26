<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Traits\ResponseTraits;
use Illuminate\Validation\Rule;
use Facades\App\Http\Helpers\CredentialsHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserStoreRequest extends FormRequest
{
    use ResponseTraits;

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
        $user = CredentialsHelper::get_set_credentials();
        return [
            'username' => ['required'],
            'email' => ['required',Rule::unique('users')->ignore($this->edit_id)],
            'client_id' => !in_array('admin', $user['roles']) ? ['required'] : 'nullable',
            'role-ctr' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'FullName is required.',
            'email.required' => 'Email Address is required.',
            'email.unique' => 'Email Address is already exists.',
            'client_id.required' => 'Client is required.',
            'role-ctr.required' => 'Select atleast 1 Role.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = $this->failedValidationResponse($validator->errors());
        throw new HttpResponseException(response()->json($response, 200));
    }
}
