<?php

namespace App\Http\Requests\Admin;

use App\Models\Testimonial;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    /**
     * Route middleware already checks the create / edit permission.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalises the checkboxes and optional numbers.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'rating' => $this->filled('rating') ? $this->input('rating') : Testimonial::MAX_RATING,
            'sort_order' => $this->filled('sort_order') ? $this->input('sort_order') : 0,
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
            'remove_image' => $this->boolean('remove_image'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
            'name_si' => ['nullable', 'string', 'max:255'],
            'position_si' => ['nullable', 'string', 'max:255'],
            'message_si' => ['nullable', 'string', 'max:1000'],
            'rating' => ['integer', 'min:'.Testimonial::MIN_RATING, 'max:'.Testimonial::MAX_RATING],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['boolean'],
            'sort_order' => ['integer', 'min:0', 'max:9999'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'rating' => 'star rating',
            'image' => 'photo',
            'name_si' => 'Sinhala customer name',
            'position_si' => 'Sinhala position',
            'message_si' => 'Sinhala message',
        ];
    }
}
