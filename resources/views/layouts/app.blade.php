<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Veículos')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-color: #6161ff;
            --secondary-color: #64748b;
            --success-color: #059669;
            --danger-color: #dc2626;
            --warning-color: #d97706;
            --info-color: #0891b2;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --estatistics-color: #84ba3f;
        }

        body {
            background: #26295a;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            margin-bottom: 20px;
        }

        .navbar {
            background-color: #26295a;
            opacity: 0.9;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            color: var(--light-color) !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #01dcf6 !important;
            transform: translateY(-2px);
        }


        .navbar-logo:hover {
            transform: scale(1.05);
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .main-content {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
            margin: 2rem 0;
            padding: 2rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.5);
        }



        .btn {
            border-radius: 25px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), #3b82f6);
        }

        .btn-success {
            background: linear-gradient(45deg, var(--success-color), #10b981);
        }

        .btn-danger {
            background: linear-gradient(45deg, var(--danger-color), #f87171);
        }

        .btn-warning {
            background: linear-gradient(45deg, var(--warning-color), #fbbf24);
        }

        .btn-info {
            background: linear-gradient(45deg, var(--info-color), #06b6d4);
        }

        .btn-stats {
            background: linear-gradient(45deg, #db4793);

        }

        .colortext {
            color: #f8fafc;
        }

        .form-control,
        .form-select {
            border-radius: 15px;
            border: 2px solid #6161ff;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
            background: rgba(255, 255, 255, 0.95);
        }

        .table {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }

        .table thead {
            background: linear-gradient(45deg, var(--primary-color), #3b82f6);
            color: white;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(37, 99, 235, 0.1);
            transform: scale(1.01);
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(31, 38, 135, 0.5);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: #db4793;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            color: var(--secondary-color);
            font-weight: 600;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            border-radius: 25px;
            padding: 4rem 2rem;
            text-align: center;
            margin-bottom: 3rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .main-content {
                margin: 1rem 0;
                padding: 1rem;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
        }

        .disabled-btn {
            cursor: default !important;
            pointer-events: none;
        }

        .form-select-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        #jumpToPage {
            text-align: center;
        }

        .list-group-item {
            transition: all 0.2s ease;
        }

        .list-group-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
            transform: translateX(2px);
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-in;
        }

        .pagination-info {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .vehicle-card {
            transition: all 0.3s ease;
        }

        .vehicle-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(31, 38, 135, 0.4);
        }

        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
            }

            .pagination-info {
                margin-bottom: 0.5rem;
            }

            .navbar-logo {
                height: 32px;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .main-content {
                margin: 1rem 0;
                padding: 1rem;
            }

            #bottomPagination {
                flex-direction: column;
                gap: 1rem;
            }

            #bottomPagination .d-flex {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div id="loadingOverlay" class="loading-overlay" style="display: none;">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-3 fw-bold">Carregando...</p>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('logo-tinnova.png') }}" alt="Sistema de Veículos" class="navbar-logo me-2">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('veiculos*') ? 'active' : '' }}" href="{{ route('veiculos') }}">
                            <i class="fas fa-car me-1"></i> Veículos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('estatisticas*') ? 'active' : '' }}" href="{{ route('estatisticas') }}">
                            <i class="fas fa-chart-bar me-1"></i> Estatísticas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <span id="successMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>

        <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span id="errorMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const API_BASE_URL = '/api/v1';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        function showSuccessToast(message) {
            document.getElementById('successMessage').textContent = message;
            const toast = new bootstrap.Toast(document.getElementById('successToast'));
            toast.show();
        }

        function showErrorToast(message) {
            document.getElementById('errorMessage').textContent = message;
            const toast = new bootstrap.Toast(document.getElementById('errorToast'));
            toast.show();
        }

        async function apiRequest(url, options = {}) {
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            };

            const finalOptions = {
                ...defaultOptions,
                ...options
            };
            if (options.headers) {
                finalOptions.headers = {
                    ...defaultOptions.headers,
                    ...options.headers
                };
            }

            try {
                const response = await fetch(API_BASE_URL + url, finalOptions);
                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Erro na requisição');
                }

                return data;
            } catch (error) {
                console.error('API Error:', error);
                throw error;
            }
        }

        function formatCurrency(value) {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(value);
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('pt-BR');
        }
    </script>

    @stack('scripts')
</body>

</html>