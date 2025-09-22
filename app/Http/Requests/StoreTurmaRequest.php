<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTurmaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Alteramos para 'true' para permitir que qualquer usuário (autenticado ou não)
        // possa fazer esta requisição. Você pode adicionar lógicas de permissão aqui no futuro.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Pega a turma da rota, se estivermos na rota de 'update'.
        // Ex: /turmas/5
        $turmaId = $this->route('turma') ? $this->route('turma')->id : null;

        return [
            // A regra 'unique' foi aprimorada:
            // Ela vai garantir que o nome da turma seja único na tabela 'turmas'.
            // Ao ATUALIZAR, ela vai ignorar o ID da própria turma que estamos editando,
            // permitindo que a gente salve sem receber um erro de "nome já existe".
            'nome' => 'required|string|max:255|unique:turmas,nome,' . $turmaId,
        ];
    }
}
