<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlunoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Por enquanto, vamos manter true.
        // Mais tarde, poderíamos verificar se o usuário está logado.
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
            'nome_aluno' => 'required|string|max:255',
            'nome_responsavel' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'turma_id' => 'nullable|exists:turmas,id',
            'numero_caixa' => 'nullable|string|max:50',
            'numero_pasta' => 'nullable|string|max:50',
            'obs' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome_aluno.required' => 'O campo "Nome do Aluno" é obrigatório.',
            'nome_aluno.max' => 'O nome do aluno não pode ter mais que 255 caracteres.',
            'nome_responsavel.required' => 'O campo "Nome do Responsável" é obrigatório.',
            'data_nascimento.required' => 'O campo "Data de Nascimento" é obrigatório.',
            'data_nascimento.date' => 'Insira uma data de nascimento válida.',
            'turma_id.exists' => 'A turma selecionada não existe.',
        ];
    }
}