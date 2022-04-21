<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class userRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {

        // Validações do formulario
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:12|max:16',
        ];
        if ($this->method() == "POST") {
            $rules['password'] = 'required|string|min:3|max:100';
            $rules['picture'] = 'required|mimes:jpg,jpeg,png,bmp,svg,webp|max:5120';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'email' => 'E-mail',
            'phone' => 'Telefone',
            'password' => 'Senha',
            'picture' => 'Foto',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Este campo é obrigatorio.',
            'email.required' => 'Este campo é obrigatorio.',
            'password.required' => 'Este campo é obrigatorio.',
            'phone.required' => 'Este campo é obrigatorio.',
            'picture.required' => 'Este campo é obrigatorio.',
            'phone.min' => 'Você deve preencher um numero de no minimo de 12 caracteres.',
            'phone.max' => 'Você deve preencher um numero de no maximo de 16 caracteres.',
            'email.unique' => 'Este email já está cadastrado.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        // Retorno de erro das validações
        throw new HttpResponseException(response()->json([
            'data' => [
                'mensagem' => 'Ocorreu um erro de validação',
                'erro' => $validator->errors(),
            ]
        ], 400));
    }
}
