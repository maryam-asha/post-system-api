<?php

namespace App\Http\Requests;

use App\Rules\FutureDate;
use App\Rules\MaxWords;
use App\Rules\ValidSlug;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdatePostRequest extends FormRequest
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
            'title' => ['sometimes', 'string', 'max:255'],
            'slug' => ['sometimes', 'string', 'max:255', 'unique:postes,slug,' . $this->post->id, new ValidSlug],
            'body' => ['sometimes', 'string'],
            'is_published' => ['sometimes', 'boolean'],
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
            'title.max' => 'The post title must not exceed :max characters',
            'slug.unique' => 'the slug is already taken',
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
        if ($this->has('title') && (!$this->has('slug') || empty($this->slug))) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }
    }
    protected function passedValidation(): void
    {
        $this->merge([
            'slug' => $this->slug ? Str::slug($this->slug) : $this->post->slug,
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
