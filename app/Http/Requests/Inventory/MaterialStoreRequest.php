<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class MaterialStoreRequest extends FormRequest
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
    private const REQUIRED_MSG = 'El campo :attribute es obligatorio.';
    private const MAX_MSG = 'El campo :attribute no debe superar los :max caracteres.';
    private const INTEGER_MSG = 'El campo :attribute debe ser un número entero.';
    private const EXISTS_MSG = 'El campo :attribute seleccionado no es válido.';

    public function rules(): array
    {
        return [
            'id_company' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'unit_of_measure' => 'nullable|integer|max:10',
            'stock' => 'nullable|integer',
            'purchase_price' => 'required|integer',
            'low_stock_threshold' => 'nullable|integer',
            'description' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_company' => 'Empresa',
            'name' => 'Nombre',
            'type' => 'Tipo',
            'unit_of_measure' => 'Unidad de medida',
            'stock' => 'Stock',
            'purchase_price' => 'Precio de compra',
            'low_stock_threshold' => 'Stock mínimo',
            'description' => 'Descripción',
        ];
    }

    public function messages(): array
    {
        return [
            'id_company.required' => self::REQUIRED_MSG,
            'id_company.exists' => self::EXISTS_MSG,

            'name.required' => self::REQUIRED_MSG,
            'name.max' => self::MAX_MSG,

            'type.required' => self::REQUIRED_MSG,
            'type.max' => self::MAX_MSG,

            'unit_of_measure.required' => self::REQUIRED_MSG,
            'unit_of_measure.integer' => self::INTEGER_MSG,
            'unit_of_measure.max' => self::MAX_MSG,

            'stock.integer' => self::INTEGER_MSG,

            'purchase_price.required' => self::REQUIRED_MSG,
            'purchase_price.integer' => self::INTEGER_MSG,

            'low_stock_threshold.integer' => self::INTEGER_MSG,
        ];
    }
}
