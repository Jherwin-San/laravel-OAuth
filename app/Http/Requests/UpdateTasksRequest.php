<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTasksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user <> null && $user->tokenCan('update-tasks');
        //     return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method == "PUT") {
            return [
                "title" => ['required', 'string'],
                "description" => ['required', 'string'],
                "status" => ['required', Rule::in(['ongoing', 'done', 'submitted'])],
            ];
        } else {
            return [
                "title" => ['sometimes', 'required', 'string'],
                "description" => ['sometimes', 'required', 'string'],
                "status" => ['sometimes', 'required', Rule::in(['ongoing', 'done', 'submitted'])],
            ];
        }
    }
}
