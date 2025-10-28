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
            
            // --- VARIÁVEIS GLOBAIS ---
            const formModalElement = document.getElementById('formModal');
            const formModal = formModalElement ? new bootstrap.Modal(formModalElement) : null;
            const modalBody = formModalElement ? formModalElement.querySelector('.modal-body') : null;
            const modalTitle = formModalElement ? formModalElement.querySelector('.modal-title') : null;
            
            const toastElement = document.getElementById('notificationToast');
            const toast = toastElement ? new bootstrap.Toast(toastElement, { delay: 3000 }) : null;
            const toastBody = document.getElementById('toast-body');

            // --- LÓGICA DA BUSCA DINÂMICA (Seu código original) ---
            const filterForm = document.getElementById('filter-form');
            if (filterForm) {
                let debounceTimer;
                filterForm.addEventListener('input', function(e) {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        const formData = new FormData(filterForm);
                        const params = new URLSearchParams(formData);
                        // Adiciona um parâmetro para identificar a requisição AJAX
                        params.append('ajax', '1'); 
                        
                        const url = window.location.pathname + '?' + params.toString();

                        fetch(url, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('alunos-table-body').innerHTML = data.lista;
                            document.getElementById('pagination-container').innerHTML = data.paginacao;
                        });
                    }, 300);
                });
            }

            // --- LÓGICA GLOBAL DAS MODAIS (Seu código original, com a correção do btn-edit-modal) ---
            document.body.addEventListener('click', function (e) {
                const createLink = e.target.closest('a[href*="/create"]');
                const editLink = e.target.closest('.btn-edit-modal'); // Usando a classe que adicionamos
                const addAlunoBtn = e.target.closest('#add-aluno-btn');

                if (createLink) {
                    e.preventDefault();
                    let title = createLink.href.includes('turmas') ? 'Cadastrar Nova Turma' : 'Cadastrar Novo Aluno';
                    openFormModal(createLink.href, title);
                } else if (editLink) {
                    e.preventDefault();
                    let title = editLink.href.includes('turmas') ? 'Editar Turma' : 'Editar Dados do Aluno';
                    openFormModal(editLink.href, title);
                } else if (addAlunoBtn) {
                    // ... (sua lógica para o botão de adicionar aluno na turma)
                }
            });

            // --- LÓGICA DE CONFIRMAÇÃO DE EXCLUSÃO (Que adicionamos) ---
            document.body.addEventListener('submit', function(e) {
                if (e.target.classList.contains('delete-form')) {
                    if (!confirm('Tem certeza que deseja excluir?')) {
                        e.preventDefault(); 
                    }
                }
            });

            // --- FUNÇÕES AUXILIARES ---

            function openFormModal(url, title) {
                if (!formModal) return;
                modalTitle.textContent = title;
                modalBody.innerHTML = '<div class="d-flex justify-content-center p-5"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div></div>';
                formModal.show();
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                        // Anexa o listener de submit AO FORMULÁRIO que acabou de ser carregado
                        handleFormSubmission(); 
                    });
            }

            /**
             * Anexa o listener de submit ao formulário dentro da modal
             */
            function handleFormSubmission() {
                const form = modalBody.querySelector('form');
                if (!form) return;

                form.addEventListener('submit', function (e) {
                    
                    // 1. Limpa erros de validação anteriores (do backend)
                    clearValidationErrors(form);

                    // ***** INÍCIO DA CORREÇÃO *****
                    // 2. Checa a validação nativa do HTML5 (campos 'required', 'type=date', etc.)
                    if (!form.checkValidity()) {
                        e.preventDefault();  // Impede o envio
                        e.stopPropagation(); // Para o evento

                        // Adiciona a classe do Bootstrap para MOSTRAR as mensagens de erro
                        form.classList.add('was-validated'); 
                        return; // Para a execução aqui, não envia o fetch.
                    }
                    // ***** FIM DA CORREÇÃO *****

                    // 3. Se a validação do HTML5 passou, envia o AJAX
                    e.preventDefault();
                    
                    const formData = new FormData(form);
                    const url = form.action;
                    const method = form.method;
                    const submitButton = form.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Salvando...';

                    fetch(url, {
                        method: method,
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            formModal.hide();
                            showToast(data.message, 'bg-success');
                            // Recarrega a página para ver as mudanças
                            window.location.reload(); 
                        }
                    })
                    .catch(error => {
                        error.json().then(data => {
                            if (data.errors) {
                                // Se for erro de validação do Laravel (422)
                                displayValidationErrors(form, data.errors);
                            } else {
                                // Outro erro (500, etc)
                                showToast('Ocorreu um erro inesperado.', 'bg-danger');
                            }
                        });
                    })
                    .finally(() => {
                        // Reabilita o botão
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<i class="fas fa-save me-1"></i>Salvar';
                    });
                });
            }

            /**
             * Mostra os erros de validação vindos do Laravel
             */
            function displayValidationErrors(form, errors) {
                for (const field in errors) {
                    const input = form.querySelector(`[name="${field}"]`);
                    const errorDiv = form.querySelector(`.invalid-feedback[data-field="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                    }
                    if (errorDiv) {
                        errorDiv.textContent = errors[field][0]; // Mostra o primeiro erro
                    }
                }
            }

            /**
             * Limpa as classes e mensagens de erro
             */
            function clearValidationErrors(form) {
                // Remove a classe de validação do HTML5
                form.classList.remove('was-validated'); 

                // Remove as classes de erro do Laravel
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            }

            /**
             * Mostra a notificação (toast)
             */
            function showToast(message, bgClass) {
                if (!toast) return;
                toastBody.textContent = message;
                toastElement.className = 'toast align-items-center text-white border-0 ' + bgClass; // Reseta as classes
                toast.show();
            }

        });
    </script>
</body>
</html>