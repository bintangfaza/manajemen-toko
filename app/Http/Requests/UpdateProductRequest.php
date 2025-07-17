<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0|max:999999.99',
            'stock' => 'required|integer|min:0|max:9999',
            'barcode' => 'nullable|string|max:50|unique:products,barcode,' . $this->product->id,
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.max' => 'Nama produk maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'price.max' => 'Harga maksimal Rp 999.999,99.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
            'stock.max' => 'Stok maksimal 9999.',
            'barcode.unique' => 'Barcode sudah digunakan produk lain.',
            'barcode.max' => 'Barcode maksimal 50 karakter.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama produk',
            'description' => 'deskripsi',
            'price' => 'harga',
            'stock' => 'stok',
            'barcode' => 'barcode',
        ];
    }
}
