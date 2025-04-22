<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo un usuario autenticado puede actualizar su perfil
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|min:2|max:255',
            'descripcion' => 'nullable|string|max:500',
            'telefono' => ['nullable', 'string', 'regex:/^[0-9]{9}$/'],
            'ciudad' => 'nullable|string|min:2|max:100',
            'dni' => ['nullable', 'string', 'regex:/^[0-9]{8}[A-Za-z]$|^[XYZxyz][0-9]{7}[A-Za-z]$/'],
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cv_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'show_telefono' => 'nullable|boolean',
            'show_dni' => 'nullable|boolean',
            'show_ciudad' => 'nullable|boolean',
            'show_direccion' => 'nullable|boolean',
            'show_web' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres',
            'nombre.max' => 'El nombre no puede exceder los 255 caracteres',
            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres',
            'telefono.regex' => 'El teléfono debe contener 9 dígitos',
            'ciudad.min' => 'La ciudad debe tener al menos 2 caracteres',
            'ciudad.max' => 'La ciudad no puede exceder los 100 caracteres',
            'dni.regex' => 'El formato de DNI/NIE no es válido',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif o webp',
            'imagen.max' => 'La imagen no puede exceder los 2MB',
            'cv_pdf.mimes' => 'El archivo debe ser un PDF',
            'cv_pdf.max' => 'El CV no puede exceder los 5MB',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->ajax()) {
            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422)
            );
        }

        parent::failedValidation($validator);
    }
}
