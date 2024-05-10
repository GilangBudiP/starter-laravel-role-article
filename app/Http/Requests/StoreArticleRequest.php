<?php

namespace App\Http\Requests;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreArticleRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required',
            // 'slug' => 'nullable|max:255|alpha_dash|unique:articles,slug',
            'body' => 'required',
            'status' => 'required',
        ];
    }
}
