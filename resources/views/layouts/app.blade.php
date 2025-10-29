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
        .table-hover tbody tr:hover { background-color: rgba(0, 0, 0, 0.05); }
        .modal-header { background-color: #f1f1f1; }
        /* Para o spinner do filtro */
        #filter-form { position: relative; }
        #filter-spinner {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: none; /* Começa escondido */
        }
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
                
                {{-- BOTÕES ATUALIZADOS para apontar para as rotas da MODAL --}}
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" id="cadastroDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-plus me-2"></i>Cadastrar
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="cadastroDropdown">
                        <li>
                            <a class="dropdown-item" 
                               href="{{ route('alunos.modal.create') }}" 
                               data-bs-toggle="modal" 
                               data-bs-target="#formModal">
                                <i class="fas fa-user-graduate fa-fw me-2"></i>Novo Aluno
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" 
                               href="{{ route('turmas.modal.create') }}"
                               data-bs-toggle="modal" 
                               data-bs-target="#formModal">
                                <i class="fas fa-chalkboard-user fa-fw me-2"></i>Nova Turma
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <main class="container mt-4 mb-5">
        @yield('content')
    </main>

    {{-- 
      MODAL ATUALIZADA: 
      - O ID é 'formModal' (para bater com os data-bs-target)
      - O footer foi REMOVIDO, pois ele virá de dentro do _form.blade.php
    --}}
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Carregando...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center p-5">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
                    </div>
                </div>
                {{-- O modal-footer foi removido daqui --}}
            </div>
        </div>
    </div>

    {{-- HTML do Toast (sem alterações) --}}
    <div class="toast-container position-fixed top-0 end-0 p-3"><div id="notificationToast" class="toast align-items-center text-white border-0"><div class="d-flex"><div class="toast-body" id="toast-body"></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div></div>
    
    {{-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO (NOVA) --}}
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este item? Esta ação não pode ser desfeita.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btn-confirm-delete">Excluir</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // --- VARIÁVEIS GLOBAIS ---
            const formModalElement = document.getElementById('formModal');
            const formModal = formModalElement ? new bootstrap.Modal(formModalElement) : null;
            const modalBody = formModalElement ? formModalElement.querySelector('.modal-body') : null;
            const modalTitle = formModalElement ? formModalElement.querySelector('.modal-title') : null;
            
            const deleteModalElement = document.getElementById('deleteConfirmModal');
            const deleteModal = deleteModalElement ? new bootstrap.Modal(deleteModalElement) : null;
            const btnConfirmDelete = document.getElementById('btn-confirm-delete');

            const toastElement = document.getElementById('notificationToast');
            const toast = toastElement ? new bootstrap.Toast(toastElement, { delay: 3000 }) : null;
            const toastBody = document.getElementById('toast-body');

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let urlToDelete = null; // Variável para guardar a URL de exclusão
            let entityName = ''; // 'aluno' ou 'turma'

            // --- LÓGEICA DE FILTRO DINÂMICO (Seu código original, mas melhorado) ---
            const filterForm = document.getElementById('filter-form');
            if (filterForm) {
                let debounceTimer;
                const filterSpinner = document.getElementById('filter-spinner'); // Spinner
                
                filterForm.addEventListener('input', function(e) {
                    clearTimeout(debounceTimer);
                    if(filterSpinner) filterSpinner.style.display = 'block'; // Mostra spinner

                    debounceTimer = setTimeout(() => {
                        const formData = new FormData(filterForm);
                        const params = new URLSearchParams(formData);
                        const url = '{{ route("home") }}' + '?' + params.toString();

                        fetch(url, {
                            headers: { 
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                             }
                        })
                        .then(response => response.json())
                        .then(data => {
                            updateAlunosList(data.lista, data.paginacao);
                        })
                        .catch(console.error)
                        .finally(() => {
                            if(filterSpinner) filterSpinner.style.display = 'none'; // Esconde spinner
                        });
                    }, 300);
                });
            }


            // --- NOVA LÓGICA DAS MODAIS (CREATE / EDIT) ---
            document.body.addEventListener('click', function (e) {
                const modalToggle = e.target.closest('[data-bs-toggle="modal"][data-bs-target="#formModal"]');
                if (modalToggle) {
                    e.preventDefault();
                    openFormModal(modalToggle.getAttribute('href'));
                }
            });

            // Função para abrir e popular a modal de formulário
            function openFormModal(url) {
                if (!formModal) return;
                
                // 1. Reseta a modal para o estado de "Carregando"
                modalTitle.textContent = 'Carregando...';
                modalBody.innerHTML = '<div class="d-flex justify-content-center p-5"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div></div>';
                formModal.show();

                // 2. Busca o HTML do formulário
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                        const form = modalBody.querySelector('form');
                        
                        // 3. Atualiza o título da modal com o 'data-title' do form
                        if(form && form.dataset.title) {
                            modalTitle.textContent = form.dataset.title;
                        }

                        // 4. Anexa o listener de submit AO FORMULÁRIO que acabou de ser carregado
                        handleFormSubmission(form); 
                    })
                    .catch(err => {
                         modalBody.innerHTML = '<p class="text-danger">Erro ao carregar o formulário. Tente novamente.</p>';
                    });
            }

            // Função para lidar com o envio do formulário (AJAX)
            function handleFormSubmission(form) {
                if (!form) return;

                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    
                    // 1. Limpa erros de validação anteriores
                    clearValidationErrors(form);

                    // 2. Checa a validação nativa do HTML5
                    if (!form.checkValidity()) {
                        e.stopPropagation();
                        form.classList.add('was-validated'); 
                        return;
                    }
                    
                    // 3. Envia o AJAX
                    const formData = new FormData(form);
                    const url = form.dataset.action;
                    const method = form.dataset.method || 'POST';

                    // Adiciona _method para PUT/PATCH
                    if (method.toUpperCase() !== 'POST') {
                        formData.append('_method', method);
                    }
                    
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalButtonHtml = submitButton.innerHTML;
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Salvando...';

                    fetch(url, {
                        method: 'POST', // Formulários HTML só enviam POST ou GET
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => {
                        if (response.status === 422) { // Erro de Validação
                            return response.json().then(data => Promise.reject(data));
                        }
                        if (!response.ok) { // Outros erros (500, 403, etc)
                             return response.json().then(data => Promise.reject({ message: data.message || 'Erro no servidor' }));
                        }
                        return response.json(); // Sucesso
                    })
                    .then(data => {
                        if (data.success) {
                            formModal.hide();
                            showToast(data.message, 'bg-success');

                            // ATUALIZAÇÃO MÁGICA:
                            // Se a resposta contém a lista de alunos (página home)
                            if (data.lista && data.paginacao) {
                                updateAlunosList(data.lista, data.paginacao);
                            } else {
                                // Se for outra página (ex: turmas), apenas recarrega
                                window.location.reload(); 
                            }
                        }
                    })
                    .catch(errorData => {
                        if (errorData.errors) {
                            // Erros de validação do Laravel
                            displayValidationErrors(form, errorData.errors);
                            showToast('Verifique os erros no formulário.', 'bg-warning text-dark');
                        } else {
                            // Outro erro
                            showToast(errorData.message || 'Ocorreu um erro inesperado.', 'bg-danger');
                        }
                    })
                    .finally(() => {
                        // Reabilita o botão
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalButtonHtml;
                    });
                });
            }

            
            // --- NOVA LÓGICA DE EXCLUSÃO (COM MODAL DE CONFIRMAÇÃO) ---
            
            // 1. Listener nos botões .btn-delete
            document.body.addEventListener('click', function(e) {
                const deleteButton = e.target.closest('.btn-delete');
                if (deleteButton) {
                    urlToDelete = deleteButton.dataset.urlDelete;
                    entityName = deleteButton.dataset.entityName || 'item';
                    if (deleteModal) {
                        deleteModal.show();
                    }
                }
            });

            // 2. Listener no botão "Excluir" de dentro da modal
            if (btnConfirmDelete) {
                btnConfirmDelete.addEventListener('click', function() {
                    if (!urlToDelete) return;

                    // Adiciona o 'page' atual à URL de delete, para o controller saber
                    const params = new URLSearchParams(window.location.search);
                    const currentPage = params.get('page') || '1';
                    
                    const deleteUrlWithPage = new URL(urlToDelete);
                    deleteUrlWithPage.searchParams.append('page', currentPage);

                    fetch(deleteUrlWithPage.toString(), {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => {
                        if (response.status === 422) { // Erro de Validação (ex: turma com alunos)
                            return response.json().then(data => Promise.reject(data));
                        }
                        if (!response.ok) {
                             return response.json().then(data => Promise.reject({ message: data.message || 'Erro no servidor' }));
                        }
                        return response.json();
                    })
                    .then(data => {
                        if(data.success) {
                            showToast(data.message, 'bg-success');
                            
                            if (entityName === 'aluno') {
                                // Atualiza a lista de alunos
                                updateAlunosList(data.lista, data.paginacao);
                            } else {
                                // Para turmas, só recarrega a página
                                window.location.reload();
                            }
                        }
                    })
                    .catch(errorData => {
                         showToast(errorData.message || 'Não foi possível excluir.', 'bg-danger');
                    })
                    .finally(() => {
                        deleteModal.hide();
                        urlToDelete = null;
                        entityName = '';
                    });
                });
            }


            // --- FUNÇÕES AUXILIARES ---

            // Atualiza a tabela e a paginação de alunos
            function updateAlunosList(listaHtml, paginacaoHtml) {
                const tableBody = document.getElementById('alunos-table-body');
                const paginationContainer = document.getElementById('pagination-container');
                if (tableBody) tableBody.innerHTML = listaHtml;
                if (paginationContainer) paginationContainer.innerHTML = paginacaoHtml;
            }

            // Mostra os erros de validação vindos do Laravel
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

            // Limpa as classes e mensagens de erro
            function clearValidationErrors(form) {
                form.classList.remove('was-validated'); 
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            }

            // Mostra a notificação (toast)
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