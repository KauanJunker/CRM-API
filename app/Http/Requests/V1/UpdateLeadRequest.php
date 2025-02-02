<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if($method == "PUT") {
            return [
                "name" => ["required"],
                "email" => ["required", "email"],
                "phone" => ["nullable"],
                "status" => ["nullable"]
            ];
        } else {
            return [
                "name" => ["sometimes", "required"],
                "email" => ["sometimes", "required", "email"],
                "phone" => ["sometimes", "nullable"],
                "status" => ["sometimes", "nullable"]
            ];
        }
    }

    public function messages()
    {
       return ["email.email" => "E-mail incorreto."];
    }
}
