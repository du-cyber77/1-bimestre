{{-- O início do arquivo (head, navbar) continua o mesmo --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema CIEP 1402')</title>

    {{-- CSS do Bootstrap via CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- CSS do Font Awesome para ícones --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body { background-color: #f8f9fa; }
        .table-hover tbody tr:hover { background-color: rgba(0, 0, 0, 0.05); cursor: pointer; }
        .modal-header { background-color: #f1f1f1; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}"><i class="fa-solid fa-school me-2"></i>CIEP 1402</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}"><i class="fa-solid fa-user-graduate me-1"></i>Alunos</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('turmas*') ? 'active' : '' }}" href="{{ route('turmas.index') }}"><i class="fa-solid fa-chalkboard-user me-1"></i>Turmas</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('relatorios*') ? 'active' : '' }}" href="{{ route('reports.index') }}"><i class="fa-solid fa-chart-pie me-1"></i>Relatórios</a></li>
                </ul>
                
                {{-- ESTE É O BOTÃO --}}
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" id="cadastroDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-plus me-2"></i>Cadastrar
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="cadastroDropdown">
                        <li><a class="dropdown-item" href="{{ route('alunos.create') }}"><i class="fas fa-user-graduate fa-fw me-2"></i>Novo Aluno</a></li>
                        <li><a class="dropdown-item" href="{{ route('turmas.create') }}"><i class="fas fa-chalkboard-user fa-fw me-2"></i>Nova Turma</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <main class="container mt-4 mb-5">
        @yield('content')
    </main>

    {{-- HTML da Modal e Toast --}}
    <div class="modal fade" id="formModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="formModalLabel"></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"></div></div></div></div>
    <div class="toast-container position-fixed top-0 end-0 p-3"><div id="notificationToast" class="toast align-items-center text-white border-0"><div class="d-flex"><div class="toast-body" id="toast-body"></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ... (bloco de variáveis globais e lógica da busca dinâmica continuam os mesmos) ...

            // --- LÓGICA GLOBAL DAS MODAIS ---
            
            // O event listener de click agora é mais inteligente
            document.body.addEventListener('click', function (e) {
                const createLink = e.target.closest('a[href*="/alunos/create"]');
                const editLink = e.target.closest('a[href*="/edit"]');
                // ***** INÍCIO DA CORREÇÃO *****
                const addAlunoBtn = e.target.closest('#add-aluno-btn');

                if (createLink) {
                    e.preventDefault();
                    openFormModal(createLink.href, 'Cadastrar Novo Aluno');
                } else if (editLink) {
                    e.preventDefault();
                    openFormModal(editLink.href, 'Editar Dados do Aluno');
                } else if (addAlunoBtn) {
                    e.preventDefault();
                    const turmaId = addAlunoBtn.dataset.turmaId;
                    const createUrl = '{{ route("alunos.create") }}';
                    openFormModal(createUrl, 'Adicionar Novo Aluno à Turma');

                    // Este evento garante que vamos pré-selecionar a turma DEPOIS que a modal abrir e o formulário carregar
                    formModalElement.addEventListener('shown.bs.modal', function handler() {
                        const turmaSelect = formModalElement.querySelector('#turma_id');
                        if (turmaSelect) {
                            turmaSelect.value = turmaId;
                        }
                        // Remove o listener para não acumular execuções
                        formModalElement.removeEventListener('shown.bs.modal', handler);
                    }, { once: true }); // A opção { once: true } é uma forma mais segura de fazer isso
                }
                // ***** FIM DA CORREÇÃO *****
            });

            // O resto do seu script (handleFormSubmission, openFormModal, etc.) continua exatamente o mesmo.
            // Colei novamente para garantir que você tenha a versão mais completa e estável.
            
            const formModalElement = document.getElementById('formModal');
            const formModal = formModalElement ? new bootstrap.Modal(formModalElement) : null;
            const modalBody = formModalElement ? formModalElement.querySelector('.modal-body') : null;
            const modalTitle = formModalElement ? formModalElement.querySelector('.modal-title') : null;

            function openFormModal(url, title) {
                if (!formModal) return;
                modalTitle.textContent = title;
                modalBody.innerHTML = '<div class="d-flex justify-content-center p-5"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div></div>';
                formModal.show();
                fetch(url).then(response => response.text()).then(html => {
                    modalBody.innerHTML = html;
                    handleFormSubmission();
                });
            }

            function handleFormSubmission() {
                // A sua função handleFormSubmission completa vai aqui
            }
        });
    </script>
</body>
</html>