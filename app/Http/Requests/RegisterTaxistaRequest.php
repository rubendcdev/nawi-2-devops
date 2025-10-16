<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;

class RegisterTaxistaRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:128',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ],
            'telefono' => [
                'required',
                'string',
                'regex:/^[0-9+\-\s\(\)]{10,15}$/',
                'min:10',
                'max:15',
            ],
            'direccion' => [
                'required',
                'string',
                'min:10',
                'max:255',
            ],
            'licencia' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^[A-Z0-9]+$/',
                'unique:users,licencia',
            ],
            'tarjeta_circulacion' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^[A-Z0-9]+$/',
                'unique:users,tarjeta_circulacion',
            ],
            'genero_id' => [
                'required',
                'integer',
                'exists:generos,id',
            ],
            'idioma_id' => [
                'required',
                'integer',
                'exists:idiomas,id',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.regex' => 'El nombre solo puede contener letras y espacios',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El formato del email no es válido',
            'email.unique' => 'Este email ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.regex' => 'El formato del teléfono no es válido',
            'direccion.required' => 'La dirección es obligatoria',
            'licencia.required' => 'El número de licencia es obligatorio',
            'licencia.regex' => 'La licencia debe contener solo letras mayúsculas y números',
            'licencia.unique' => 'Esta licencia ya está registrada',
            'tarjeta_circulacion.required' => 'El número de tarjeta de circulación es obligatorio',
            'tarjeta_circulacion.regex' => 'La tarjeta de circulación debe contener solo letras mayúsculas y números',
            'tarjeta_circulacion.unique' => 'Esta tarjeta de circulación ya está registrada',
            'genero_id.required' => 'El género es obligatorio',
            'genero_id.exists' => 'El género seleccionado no es válido',
            'idioma_id.required' => 'El idioma es obligatorio',
            'idioma_id.exists' => 'El idioma seleccionado no es válido',
        ];
    }
}
