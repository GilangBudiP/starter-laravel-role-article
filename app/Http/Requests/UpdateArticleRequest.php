<?php

namespace App\Http\Requests;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'max:255',
                // Rule::unique('articles')->ignore($this->article->id),
            ],
            'description' => 'required',
            'category_id' => 'required',
            'body' => 'required',
            'status' => 'required',
        ];
    }
}
