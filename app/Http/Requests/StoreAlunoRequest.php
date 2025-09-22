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
        // Alterado para true para permitir a requisição.
        // Você pode adicionar sua lógica de autorização aqui no futuro.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nome_aluno' => 'required|string|max:255',
            'nome_responsavel' => 'required|string|max:255',
            'numero_caixa' => 'required|string|max:50',
            'numero_pasta' => 'required|string|max:50',
            'data_nascimento' => 'required|date',
            'obs' => 'nullable|string',
            'turma_id' => 'nullable|exists:turmas,id',
        ];
    }
}