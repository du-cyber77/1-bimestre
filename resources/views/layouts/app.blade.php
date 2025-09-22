<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Meta para o token CSRF, essencial para o AJAX no Laravel --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistema CIEP 1402')</title>

    {{-- CSS do Bootstrap via CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- CSS do Font Awesome para ícones --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Estilos personalizados para melhorar a aparência */
        body {
            background-color: #f8f9fa;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.05);
            cursor: pointer;
        }
        .modal-header {
            background-color: #f1f1f1;
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
                    <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}"><i class="fa-solid fa-user-graduate me-1"></i>Alunos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('turmas.index') }}"><i class="fa-solid fa-chalkboard-user me-1"></i>Turmas</a></li>
                </ul>
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" id="cadastroDropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-plus me-2"></i>Cadastrar</button>
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

    {{-- JavaScript do Bootstrap (essencial para modals, dropdowns, etc.) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    {{-- Ponto de injeção para scripts das páginas filhas --}}
    @stack('scripts')
</body>
</html>