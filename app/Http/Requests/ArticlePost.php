<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticlePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'seo_title' => 'SEO Title',
            'seo_description' => 'SEO Description',
            'seo_keywords' => 'SEO Keywords',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'news_title' => 'required|max:150',
            'date' => 'required|date',
            'news_image' => 'nullable|max:5000',
            'content' => 'required',
            'visibility' => '',
            'teaser' => 'required',
            'is_featured' => '',
            'seo_title' => 'max:60',
            'seo_description' => 'max:160',
            'seo_keywords' => 'max:160',
        ];
    }
}
