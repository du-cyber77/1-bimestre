<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Importante adicionar isso

class StoreTurmaRequest extends FormRequest
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
        $turmaId = $this->turma ? $this->turma->id : null;

        return [
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('turmas')->ignore($turmaId), // Regra 'unique' é importante
            ],
        ];
    }

    /**
     * ADICIONE ESTE MÉTODO
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O campo "Nome da Turma" é obrigatório.',
            'nome.unique' => 'Já existe uma turma cadastrada com este nome.',
            'nome.max' => 'O nome da turma não pode ter mais que 100 caracteres.',
        ];
    }
}