import './bootstrap';

// Importamos a instância do 'bootstrap' (necessário para o JS do Bootstrap)
// Se não estiver importado automaticamente no seu './bootstrap.js',
// você pode precisar adicionar: import * as bootstrap from 'bootstrap';
// Mas o padrão do Laravel geralmente já cuida disso.

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

    // Pega o token CSRF do <meta> tag no app.blade.php
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let urlToDelete = null; // Variável para guardar a URL de exclusão
    let entityName = ''; // 'aluno' ou 'turma'

    // --- LÓGICA DE FILTRO DINÂMICO (Página de Alunos) ---
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
                
                // Pega a URL base do atributo data-filter-url que colocamos no form
                const url = filterForm.dataset.filterUrl + '?' + params.toString();

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
            }, 300); // 300ms de espera após o usuário parar de digitar
        });
    }


    // --- LÓGICA DAS MODAIS (CREATE / EDIT) ---
    
    // Listener global para pegar cliques em links que abrem a modal de formulário
    document.body.addEventListener('click', function (e) {
        const modalToggle = e.target.closest('[data-bs-toggle="modal"][data-bs-target="#formModal"]');
        if (modalToggle) {
            e.preventDefault(); // Impede o link de navegar
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

            // 2. Checa a validação nativa do HTML5 (campos 'required', etc)
            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated'); 
                return;
            }
            
            // 3. Envia o AJAX
            const formData = new FormData(form);
            const url = form.dataset.action;
            const method = form.dataset.method || 'POST';

            // Adiciona _method para PUT/PATCH, pois forms HTML só suportam POST/GET
            if (method.toUpperCase() !== 'POST') {
                formData.append('_method', method);
            }
            
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonHtml = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Salvando...';

            fetch(url, {
                method: 'POST', // Sempre POST aqui, o _method cuida da Rota
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (response.status === 422) { // Erro de Validação (StoreAlunoRequest falhou)
                    return response.json().then(data => Promise.reject(data));
                }
                if (!response.ok) { // Outros erros (500, 403, 404, etc)
                     return response.json().then(data => Promise.reject({ message: data.message || 'Erro no servidor' }));
                }
                return response.json(); // Sucesso (200 OK)
            })
            .then(data => {
                if (data.success) {
                    formModal.hide();
                    showToast(data.message, 'bg-success');

                    // Se a resposta do controller mandar a 'lista' e 'paginacao'
                    // (como fizemos no AlunoController), atualiza a tabela.
                    if (data.lista && data.paginacao) {
                        updateAlunosList(data.lista, data.paginacao);
                    } else {
                        // Se não (como no TurmaController), apenas recarrega a página.
                        window.location.reload(); 
                    }
                }
            })
            .catch(errorData => {
                if (errorData.errors) {
                    // Mostra erros de validação do Laravel
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

    
    // --- LÓGICA DE EXCLUSÃO (COM MODAL DE CONFIRMAÇÃO) ---
    
    // 1. Listener nos botões .btn-delete (que adicionamos nas listas)
    document.body.addEventListener('click', function(e) {
        const deleteButton = e.target.closest('.btn-delete');
        if (deleteButton) {
            // Guarda a URL e o tipo de entidade (aluno/turma)
            urlToDelete = deleteButton.dataset.urlDelete;
            entityName = deleteButton.dataset.entityName || 'item';
            if (deleteModal) {
                deleteModal.show();
            }
        }
    });

    // 2. Listener no botão "Excluir" de dentro da modal de confirmação
    if (btnConfirmDelete) {
        btnConfirmDelete.addEventListener('click', function() {
            if (!urlToDelete) return;

            // Adiciona o 'page' atual à URL de delete, para o controller saber
            // de qual página recarregar a lista.
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
                if (response.status === 422) { // Erro (ex: turma com alunos)
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
                    
                    if (entityName === 'aluno' && data.lista && data.paginacao) {
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
                urlToDelete = null; // Limpa a URL
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
            // Busca pelo div de feedback que criamos (data-field="nome_aluno")
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
        form.classList.remove('was-validated'); // Limpa validação HTML5
        // Limpa validação do Laravel
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    }

    // Mostra a notificação (toast)
    function showToast(message, bgClass) {
        if (!toast) return;
        toastBody.textContent = message;
        // Reseta as classes de cor/fundo e adiciona a nova
        toastElement.className = 'toast align-items-center text-white border-0 ' + bgClass;
        toast.show();
    }

});