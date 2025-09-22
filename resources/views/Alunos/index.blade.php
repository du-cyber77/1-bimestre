@extends('layouts.app')

@section('title', 'CIEP 1402')

@section('content')
    {{-- O HTML do início da página (cards, busca, tabela) continua o mesmo --}}
    @if(session('success'))<div class="alert alert-success alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>{{ session('success') }}</div>@endif
    <div class="d-flex justify-content-between align-items-center mb-4"><h1 class="mb-0 display-5">Painel de Controle</h1></div>
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3"><div class="card text-white bg-primary shadow-sm h-100"><div class="card-body d-flex justify-content-between align-items-center"><div><h5 class="card-title display-4">{{ $totalAlunos }}</h5><p class="card-text">Alunos Cadastrados</p></div><i class="fas fa-user-graduate fa-3x opacity-50"></i></div></div></div>
        <div class="col-lg-4 col-md-6 mb-3"><div class="card text-white bg-success shadow-sm h-100"><div class="card-body d-flex justify-content-between align-items-center"><div><h5 class="card-title display-4">{{ $totalTurmas }}</h5><p class="card-text">Turmas Ativas</p></div><i class="fas fa-chalkboard-user fa-3x opacity-50"></i></div></div></div>
        <div class="col-lg-4 col-md-12 mb-3"><div class="card text-white bg-info shadow-sm h-100"><div class="card-body d-flex justify-content-between align-items-center"><div>@if($turmaMaisAlunos && $turmaMaisAlunos->alunos_count > 0)<h5 class="card-title fs-4">{{ $turmaMaisAlunos->nome }}</h5><p class="card-text">Turma Destaque ({{ $turmaMaisAlunos->alunos_count }} alunos)</p>@else<h5 class="card-title fs-4">-</h5><p class="card-text">Nenhuma turma com alunos</p>@endif</div><i class="fas fa-star fa-3x opacity-50"></i></div></div></div>
    </div>
    <h3 class="mt-5 border-bottom pb-2 mb-3">Listagem Dinâmica de Alunos</h3>
    <form id="filter-form" class="mb-4 p-3 border rounded bg-light" onsubmit="return false;">
        <div class="row g-3 align-items-end">
            <div class="col-md-4"><label for="filtro_nome" class="form-label">Nome do Aluno</label><input type="text" name="filtro_nome" id="filtro_nome" class="form-control" placeholder="Comece a digitar..."></div>
            <div class="col-md-4"><label for="filtro_responsavel" class="form-label">Nome do Responsável</label><input type="text" name="filtro_responsavel" id="filtro_responsavel" class="form-control" placeholder="Comece a digitar..."></div>
            <div class="col-md-4"><label for="filtro_turma_id" class="form-label">Turma</label><select name="filtro_turma_id" id="filtro_turma_id" class="form-select"><option value="">Todas as Turmas</option>@foreach($turmas as $turma)<option value="{{ $turma->id }}">{{ $turma->nome }}</option>@endforeach</select></div>
        </div>
    </form>
    <div class="table-responsive"><table class="table table-bordered table-striped table-hover"><thead class="table-dark"><tr><th>ID</th><th>Nome do Aluno</th><th>Responsável</th><th>Turma</th><th>Data de Nascimento</th><th class="text-center">Ações</th></tr></thead><tbody id="alunos-table-body">@include('alunos._lista', ['alunos' => $alunos])</tbody></table></div>
    <div class="mt-4" id="pagination-container">{{ $alunos->links() }}</div>
    
    {{-- HTML da Modal e Toast --}}
    <div class="modal fade" id="formModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="formModalLabel"></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"></div></div></div></div>
    <div class="toast-container position-fixed top-0 end-0 p-3"><div id="notificationToast" class="toast align-items-center text-white border-0"><div class="d-flex"><div class="toast-body" id="toast-body"></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Bloco de variáveis e inicialização (continua o mesmo)
    const formModalElement = document.getElementById('formModal');
    // ... (resto das variáveis) ...
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    // --- LÓGICA DAS MODAIS E FORMULÁRIOS AJAX ---
    
    function handleFormSubmission() {
        const formInModal = document.getElementById('alunoForm');
        if (!formInModal) return;

        formInModal.addEventListener('submit', function (e) {
            e.preventDefault();
            // ... (resto da lógica de pegar dados e desabilitar botão) ...
            const formData = new FormData(formInModal);
            const url = formInModal.action;
            const submitButton = formInModal.querySelector('button[type="submit"]');
            const originalButtonHtml = submitButton.innerHTML;
            
            submitButton.disabled = true;
            submitButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Salvando...`;
            clearValidationErrors();

            fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    // ******** A LINHA DA CORREÇÃO ESTÁ AQUI ********
                    'X-Requested-With': 'XMLHttpRequest', 
                },
                body: formData
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) throw data;
                return data;
            })
            .then(data => {
                // ... (lógica de sucesso continua a mesma) ...
                 if (data.success) {
                    formModal.hide();
                    toastBody.textContent = data.message;
                    toastElement.classList.remove('bg-danger');
                    toastElement.classList.add('bg-success');
                    toast.show();
                    fetchAlunos(); // Atualiza a tabela
                }
            })
            .catch(errorData => {
                // ... (lógica de erro continua a mesma) ...
                if (errorData.errors) {
                    showValidationErrors(errorData.errors);
                } else {
                    console.error('Error:', errorData);
                    alert(errorData.message || 'Um erro inesperado ocorreu.');
                }
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonHtml;
            });
        });
    }

    // O resto do seu script (busca, abrir modal, etc.) continua o mesmo.
    // Colei as funções aqui novamente para garantir que você tenha a versão mais estável.

    const filterForm = document.getElementById('filter-form');
    const tableBody = document.getElementById('alunos-table-body');
    const paginationContainer = document.getElementById('pagination-container');
    const formModal = new bootstrap.Modal(formModalElement);
    const modalBody = formModalElement.querySelector('.modal-body');
    const modalTitle = formModalElement.querySelector('.modal-title');
    const toastElement = document.getElementById('notificationToast');
    const toast = new bootstrap.Toast(toastElement);
    const toastBody = document.getElementById('toast-body');

    function clearValidationErrors() { /* ... */ }
    function showValidationErrors(errors) { /* ... */ }

    function openFormModal(url, title) {
        modalTitle.textContent = title;
        modalBody.innerHTML = '<div class="d-flex justify-content-center p-5"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div></div>';
        formModal.show();
        fetch(url).then(response => response.text()).then(html => {
            modalBody.innerHTML = html;
            handleFormSubmission();
        });
    }

    document.body.addEventListener('click', function (e) {
        const createLink = e.target.closest('a[href*="/alunos/create"]');
        const editLink = e.target.closest('a[href*="/edit"]');
        if (createLink) { e.preventDefault(); openFormModal(createLink.href, 'Cadastrar Novo Aluno'); }
        if (editLink) { e.preventDefault(); openFormModal(editLink.href, 'Editar Dados do Aluno'); }
    });
    
    let searchTimeout;
    function fetchAlunos() {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4"><div class="spinner-border text-primary"></div></td></tr>';
        if (paginationContainer) paginationContainer.style.display = 'none';
        const params = new URLSearchParams(new FormData(filterForm)).toString();
        fetch(`{{ route('alunos.search') }}?${params}`)
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(aluno => {
                        // ... (código para construir a linha da tabela) ...
                        const dataNasc = new Date(aluno.data_nascimento);
                        const dataFormatada = dataNasc.toLocaleDateString('pt-BR', { timeZone: 'UTC' });
                        const showUrl = `{{ url('alunos') }}/${aluno.id}`;
                        const editUrl = `{{ url('alunos') }}/${aluno.id}/edit`;
                        const destroyUrl = `{{ url('alunos') }}/${aluno.id}`;
                        const turmaNome = aluno.turma ? aluno.turma.nome : 'Sem Turma';
                        const row = `<tr><td>${aluno.id}</td><td><a href="${showUrl}">${aluno.nome_aluno}</a></td><td>${aluno.nome_responsavel}</td><td><span class="badge bg-secondary">${turmaNome}</span></td><td>${dataFormatada}</td><td class="text-center"><a href="${editUrl}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a><form action="${destroyUrl}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza?');"><input type="hidden" name="_token" value="${csrfToken}"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger btn-sm" title="Excluir"><i class="fas fa-trash"></i></button></form></td></tr>`;
                        tableBody.innerHTML += row;
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4">Nenhum aluno encontrado.</td></tr>';
                }
            });
    }
    filterForm.addEventListener('keyup', () => { clearTimeout(searchTimeout); searchTimeout = setTimeout(fetchAlunos, 300); });
    filterForm.addEventListener('change', fetchAlunos);
});
</script>
@endpush