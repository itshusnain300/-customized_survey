<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionStoreRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'type' => 'required|in:multiple_choice,yes_no,file,valid/invalid,text', 
            // 'description' => 'required|string', 
            'category' => 'required|string', 
            'weight' => 'nullable|in:0,1,2,3,4', 
            'vendor_id' => 'required|exists:vendors,id',
            'options.*.text' => 'nullable|string|max:255', // Validate the option text
            'options.*.weight' => 'nullable|in:0,1,2,3,4', 
        ];
    }
    
}
