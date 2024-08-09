<?php

namespace App\Http\Requests;

use App\Traits\ResponseTraits;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventStoreRequest extends FormRequest
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
        return [
            'title' => ['required'],
            'description' => ['required'],
            'event_type' => ['required'],
            'start' => ['required'],
            'end' => ['required'],
            'color' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Event Title is required.',
            'description.required' => 'Event Description is required.',
            'event_type.required' => 'Event Type is required.',
            'start.required' => 'Start Day is required.',
            'end.required' => 'End Day is required.',
            'color.required' => 'Color is required.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = $this->failedValidationResponse($validator->errors());
        throw new HttpResponseException(response()->json($response, 200));
    }
}
