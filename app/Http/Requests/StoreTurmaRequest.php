<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        // 1. Obtém o objeto Turma da rota, que é injetado pelo Route Model Binding.
        // Se estivermos na rota 'store', $this->turma será null.
        // Se estivermos na rota 'update', $this->turma será o objeto App\Models\Turma.
        $turma = $this->route('turma'); 

        // 2. Cria a regra de unicidade
        $uniqueRule = Rule::unique('turmas', 'nome')
                          // O ignore() pode receber o ID ou o objeto Model
                          // Se $turma for null, o ignore() será ignorado.
                          ->ignore($turma); 

        return [
            // Agora usamos a sintaxe de array, passando o objeto Rule.
            'nome' => ['required', 'string', 'max:255', $uniqueRule],
        ];
    }
}
