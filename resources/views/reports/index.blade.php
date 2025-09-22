@extends('layouts.app')

@section('title', 'Relatórios - CIEP 1402')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0 display-5">Relatórios Gerenciais</h1>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-chart-bar me-2"></i>
            Distribuição de Alunos por Turma
        </h5>
    </div>
    <div class="card-body">
        {{-- Verificamos se há dados ANTES de tentar renderizar o gráfico --}}
        @if($dadosGraficoTurmas->isNotEmpty())
            <canvas id="graficoAlunosPorTurma"></canvas>
        @else
            {{-- Mensagem amigável quando não há dados --}}
            <div class="text-center p-5">
                <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Não há dados para exibir.</h4>
                <p class="text-muted">O gráfico aparecerá aqui quando houver alunos cadastrados em turmas.</p>
            </div>
        @endif
    </div>
</div>

{{-- O script do Chart.js só precisa ser carregado se houver dados --}}
@if($dadosGraficoTurmas->isNotEmpty())
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const dadosDoBackend = @json($dadosGraficoTurmas);
        const labels = dadosDoBackend.map(item => item.nome);
        const data = dadosDoBackend.map(item => item.alunos_count);

        const ctx = document.getElementById('graficoAlunosPorTurma').getContext('2d');
        const graficoAlunosPorTurma = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nº de Alunos',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endif

@endsection