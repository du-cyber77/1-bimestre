<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Exibe a página principal de relatórios.
     */
    public function index()
    {
        $turmasComContagem = Turma::withCount('alunos')->get();

        $dadosGraficoTurmas = $turmasComContagem->filter(function ($turma) {
            return $turma->alunos_count > 0;
        })
        ->sortByDesc('alunos_count')
        ->values(); // <-- A CORREÇÃO MÁGICA ESTÁ AQUI!

        return view('reports.index', [
            'dadosGraficoTurmas' => $dadosGraficoTurmas
        ]);
    }
}