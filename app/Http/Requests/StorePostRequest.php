<?php

namespace App\Http\Requests;

use App\Rules\FutureDate;
use App\Rules\MaxWords;
use App\Rules\ValidSlug;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StorePostRequest extends FormRequest
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
            'title' => ['required ', 'string', 'max:255'],
            'slug' => ['required ', 'string', 'max:255', 'unique:posts,slug', new ValidSlug],
            'body' => ['required', 'string'],
            'is_published' => ['required', 'boolean'],
            'publish_date' => ['nullable', 'date', new FutureDate],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'keyword' => ['nullable', 'string', new MaxWords(10)],
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'the post title is required',
            'slug.unique' => 'the slug is already taken',
            'body.required' => 'the post content  can not be empty',
            'keyword.max_words' => 'The keywords field must not exceed :max words',
        ];
    }
    public function attributes(): array
    {
        return [
            'title' => 'post title',
            'slug' => 'post slug',
            'body' => 'post content',
            'keyword' => 'post keywords',
        ];
    }

    protected function prepareForValidation(): void
    {

        if (!$this->has('slug') || empty($this->slug)) {
            $this->merge([
                'slug' => Str::slug($this->title)
            ]);
        }

        if (!$this->has('meta_description') && $this->has('keyword')) {
            $this->merge([
                'meta_description' => substr($this->title . ' ' . $this->keyword, 0, 500),
            ]);
        }
    }
    protected function passedValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->slug),
        ]);
    }
    protected function failedValidation(Validator $validator)
    {

        throw new ValidationException($validator, response()->json([
            'success' => false,
            'message' => 'Validation Erorr',
            'errors' => $validator->errors(),
        ], 422));
    }
}
