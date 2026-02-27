<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // only administrators may create/update menus
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
  public function rules()
{
    return [
        'name' => 'required|min:3|max:255',
        'description' => 'nullable',
        'price' => 'required|numeric|min:0',
        'category' => 'required|in:makanan,minuman,snack',
        'daily_quota' => 'required|integer|min:1',
        'is_available' => 'boolean',
        'image' => 'nullable|image|max:2048'
    ];
}
}
