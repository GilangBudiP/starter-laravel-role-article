<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            //
            'name' => 'required|string|max:255|unique:categories,name,' . $this->category->id,
            'slug' => [
                'nullable',
                Rule::unique('categories', 'slug'),
                function ($attribute, $value, $fail) {
                    $slug = Str::slug($this->input('name'));
                    if (Category::where('slug', $slug)->exists()) {
                        $fail('The slug has already been taken.');
                    }
                }
            ],
            'description' => 'required',
        ];
    }
}
