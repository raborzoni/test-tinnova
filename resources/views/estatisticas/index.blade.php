@extends('layouts.app')

@section('title', 'Estatísticas')

@section('content')
<div class="main-content animate-fade-in">
    <div class="text-center mb-5">
        <h2 class="mb-3">
            <i class="fas fa-chart-bar me-2 text-primary"></i>
            Estatísticas dos Veículos
        </h2>
        <p class="text-muted">Visualize dados estatísticos e relatórios do seu catálogo de veículos</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-number" id="totalVeiculos">
                    <i class="fas fa-spinner fa-pulse"></i>
                </div>
                <div class="stat-label">Total de Veículos</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-number" id="veiculosDisponiveis">
                    <i class="fas fa-spinner fa-pulse"></i>
                </div>
                <div class="stat-label">Disponíveis</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-number" id="veiculosVendidos">
                    <i class="fas fa-spinner fa-pulse"></i>
                </div>
                <div class="stat-label">Vendidos</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-number" id="ultimaSemana">
                    <i class="fas fa-spinner fa-pulse"></i>
                </div>
                <div class="stat-label">Última Semana</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        Veículos por Década
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center" id="decadeChartLoading">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2">Carregando dados...</p>
                    </div>
                    <canvas id="decadeChart" style="display: none;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-industry me-2 text-primary"></i>
                        Veículos por Fabricante
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center" id="brandChartLoading">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2">Carregando dados...</p>
                    </div>
                    <canvas id="brandChart" style="display: none;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>
                        Status dos Veículos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center" id="statusChartLoading">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2">Carregando dados...</p>
                    </div>
                    <canvas id="statusChart" style="display: none;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock me-2 text-primary"></i>
                            Veículos da Última Semana
                        </h5>
                        <div class="d-flex align-items-center gap-2">
                            <small class="text-muted" id="recentPaginationInfo">Carregando...</small>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-primary" id="prevPageBtn" onclick="changeRecentPage(-1)" disabled>
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="nextPageBtn" onclick="changeRecentPage(1)" disabled>
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="recentVehicles">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2">Carregando dados...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table me-2 text-primary"></i>
                        Estatísticas por Década
                    </h5>
                </div>
                <div class="card-body">
                    <div id="decadeTableLoading" class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2">Carregando dados...</p>
                    </div>
                    <div id="decadeTable" style="display: none;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table me-2 text-primary"></i>
                        Estatísticas por Fabricante
                    </h5>
                </div>
                <div class="card-body">
                    <div id="brandTableLoading" class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2">Carregando dados...</p>
                    </div>
                    <div id="brandTable" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-download me-2 text-primary"></i>
                        Exportar Dados
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <button class="btn btn-primary w-100" onclick="exportData('json')">
                                <i class="fas fa-file-code me-2"></i>
                                Exportar JSON
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success w-100" onclick="exportData('csv')">
                                <i class="fas fa-file-csv me-2"></i>
                                Exportar CSV
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-info w-100" onclick="printReport()">
                                <i class="fas fa-print me-2"></i>
                                Imprimir Relatório
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let chartInstances = {};
    let statisticsData = {};
    let recentVehiclesPagination = {
        currentPage: 1,
        itemsPerPage: 5,
        totalItems: 0,
        totalPages: 0,
        allVehicles: []
    };

    document.addEventListener('DOMContentLoaded', function() {
        loadAllStatistics();
    });

    async function loadAllStatistics() {
        try {
            await Promise.all([
                loadQuickStats(),
                loadDecadeStatistics(),
                loadBrandStatistics(),
                loadRecentVehicles()
            ]);
        } catch (error) {
            console.error('Error loading statistics:', error);
            showErrorToast('Erro ao carregar estatísticas');
        }
    }

    async function loadQuickStats() {
        try {
            const response = await apiRequest('/veiculos');
            const vehicles = response.data;

            const total = vehicles.length;
            const disponveis = vehicles.filter(v => !v.vendido).length;
            const vendidos = vehicles.filter(v => v.vendido).length;

            const lastWeekResponse = await apiRequest('/veiculos/ultima-semana');
            const lastWeek = lastWeekResponse.total;

            document.getElementById('totalVeiculos').textContent = total;
            document.getElementById('veiculosDisponiveis').textContent = disponveis;
            document.getElementById('veiculosVendidos').textContent = vendidos;
            document.getElementById('ultimaSemana').textContent = lastWeek;

            createStatusChart(disponveis, vendidos);

        } catch (error) {
            console.error('Error loading quick stats:', error);
            showErrorInStats();
        }
    }

    async function loadDecadeStatistics() {
        try {
            const response = await apiRequest('/veiculos/estatisticas/decadas');
            statisticsData.decades = response.data;

            createDecadeChart(response.data);
            createDecadeTable(response.data);

        } catch (error) {
            console.error('Error loading decade statistics:', error);
            document.getElementById('decadeChartLoading').innerHTML = `
            <div class="text-danger">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <p>Erro ao carregar dados</p>
            </div>
        `;
        }
    }

    async function loadBrandStatistics() {
        try {
            const response = await apiRequest('/veiculos/estatisticas/fabricantes');
            statisticsData.brands = response.data;

            createBrandChart(response.data);
            createBrandTable(response.data);

        } catch (error) {
            console.error('Error loading brand statistics:', error);
            document.getElementById('brandChartLoading').innerHTML = `
            <div class="text-danger">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <p>Erro ao carregar dados</p>
            </div>
        `;
        }
    }

    async function loadRecentVehicles() {
        try {
            const response = await apiRequest('/veiculos/ultima-semana');
            const vehicles = response.data;

            recentVehiclesPagination.allVehicles = vehicles;
            recentVehiclesPagination.totalItems = vehicles.length;
            recentVehiclesPagination.totalPages = Math.ceil(vehicles.length / recentVehiclesPagination.itemsPerPage);

            displayRecentVehiclesPaginated();

        } catch (error) {
            console.error('Error loading recent vehicles:', error);
            document.getElementById('recentVehicles').innerHTML = `
            <div class="text-danger text-center">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <p>Erro ao carregar dados</p>
                <button class="btn btn-outline-danger btn-sm" onclick="loadRecentVehicles()">
                    <i class="fas fa-redo me-1"></i>Tentar Novamente
                </button>
            </div>
        `;

            document.getElementById('recentPaginationInfo').textContent = 'Erro';
            document.getElementById('prevPageBtn').disabled = true;
            document.getElementById('nextPageBtn').disabled = true;
        }
    }

    function displayRecentVehiclesPaginated() {
        const {
            currentPage,
            itemsPerPage,
            totalItems,
            totalPages,
            allVehicles
        } = recentVehiclesPagination;
        const container = document.getElementById('recentVehicles');

        if (totalItems === 0) {
            container.innerHTML = `
            <div class="text-center text-muted">
                <i class="fas fa-calendar-times fa-3x mb-3"></i>
                <p>Nenhum veículo cadastrado na última semana</p>
            </div>
        `;

            document.getElementById('recentPaginationInfo').textContent = '0 de 0';
            document.getElementById('prevPageBtn').disabled = true;
            document.getElementById('nextPageBtn').disabled = true;
            return;
        }

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
        const currentVehicles = allVehicles.slice(startIndex, endIndex);

        document.getElementById('recentPaginationInfo').textContent =
            `${startIndex + 1}-${endIndex} de ${totalItems}`;

        document.getElementById('prevPageBtn').disabled = currentPage <= 1;
        document.getElementById('nextPageBtn').disabled = currentPage >= totalPages;

        let html = '<div class="list-group list-group-flush">';

        currentVehicles.forEach((vehicle, index) => {
            const statusBadge = vehicle.vendido ?
                '<span class="badge bg-success">Vendido</span>' :
                '<span class="badge bg-primary">Disponível</span>';

            const itemNumber = startIndex + index + 1;
            const daysSinceCreated = Math.floor((new Date() - new Date(vehicle.created_at)) / (1000 * 60 * 60 * 24));
            const timeAgo = daysSinceCreated === 0 ? 'Hoje' :
                daysSinceCreated === 1 ? '1 dia atrás' :
                `${daysSinceCreated} dias atrás`;

            html += `
            <div class="list-group-item border-0 px-0 animate-fade-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h6 class="mb-0">${vehicle.veiculo} - ${vehicle.marca}</h6>
                        </div>
                        <p class="mb-1 text-muted small">
                            <i class="fas fa-calendar me-1"></i>${vehicle.ano} • 
                            <i class="fas fa-palette me-1"></i>${vehicle.cor || 'Cor não informada'}
                        </p>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            ${timeAgo} • ${formatDate(vehicle.created_at)}
                        </small>
                    </div>
                    <div class="text-end">
                        ${statusBadge}
                        <div class="mt-1">
                            <button class="btn btn-outline-info btn-sm" 
                                    onclick="viewVehicleDetails(${vehicle.id})" 
                                    title="Ver detalhes">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        });

        html += '</div>';

        if (totalPages > 1) {
            html += `
            <div class="text-center mt-3 pt-3 border-top">
                <small class="text-muted">
                    Página ${currentPage} de ${totalPages}
                    <span class="mx-2">•</span>
                    <i class="fas fa-car me-1"></i>${totalItems} veículos na última semana
                </small>
            </div>
        `;
        }

        container.innerHTML = html;
    }

    function changeRecentPage(direction) {
        const {
            currentPage,
            totalPages
        } = recentVehiclesPagination;

        let newPage = currentPage + direction;

        if (newPage < 1) newPage = 1;
        if (newPage > totalPages) newPage = totalPages;

        if (newPage !== currentPage) {
            recentVehiclesPagination.currentPage = newPage;
            displayRecentVehiclesPaginated();
        }
    }

    async function viewVehicleDetails(vehicleId) {
        try {
            showLoading();

            const response = await apiRequest(`/veiculos/${vehicleId}`);
            const vehicle = response.data;

            hideLoading();

            const modalHtml = `
            <div class="modal fade" id="vehicleDetailsModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-car me-2"></i>
                                ${vehicle.veiculo} - ${vehicle.marca}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">Informações Gerais</h6>
                                        <span class="badge bg-${vehicle.vendido ? 'success' : 'primary'} fs-6">
                                            ${vehicle.vendido ? 'Vendido' : 'Disponível'}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Ano:</strong> ${vehicle.ano}
                                </div>
                                <div class="col-md-6">
                                    <strong>Cor:</strong> ${vehicle.cor || 'Não informada'}
                                </div>
                                <div class="col-md-6">
                                    <strong>Cadastrado:</strong> ${formatDate(vehicle.created_at)}
                                </div>
                                <div class="col-md-6">
                                    <strong>Atualizado:</strong> ${formatDate(vehicle.updated_at)}
                                </div>
                                <div class="col-12">
                                    <strong>Descrição:</strong>
                                    <p class="mt-2 p-3 bg-light rounded">${vehicle.descricao}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <a href="/veiculos" class="btn btn-primary">
                                <i class="fas fa-list me-1"></i>Ver Todos os Veículos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;

            const existingModal = document.getElementById('vehicleDetailsModal');
            if (existingModal) {
                existingModal.remove();
            }

            document.body.insertAdjacentHTML('beforeend', modalHtml);

            const modal = new bootstrap.Modal(document.getElementById('vehicleDetailsModal'));
            modal.show();

            document.getElementById('vehicleDetailsModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });

        } catch (error) {
            hideLoading();
            console.error('Error loading vehicle details:', error);
            showErrorToast('Erro ao carregar detalhes do veículo');
        }
    }

    function createDecadeChart(data) {
        const ctx = document.getElementById('decadeChart').getContext('2d');

        if (chartInstances.decadeChart) {
            chartInstances.decadeChart.destroy();
        }

        const labels = data.map(item => item.decada);
        const values = data.map(item => item.total);

        chartInstances.decadeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Quantidade de Veículos',
                    data: values,
                    backgroundColor: [
                        'rgba(37, 99, 235, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    borderColor: [
                        'rgba(37, 99, 235, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(139, 92, 246, 1)',
                        'rgba(236, 72, 153, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        document.getElementById('decadeChart').style.display = 'block';
        document.getElementById('decadeChart').style.height = '300px';
        document.getElementById('decadeChartLoading').style.display = 'none';
    }

    function createBrandChart(data) {
        const ctx = document.getElementById('brandChart').getContext('2d');

        if (chartInstances.brandChart) {
            chartInstances.brandChart.destroy();
        }

        const topBrands = data.slice(0, 10);
        const labels = topBrands.map(item => item.marca);
        const values = topBrands.map(item => item.total);

        const colors = [
            'rgba(37, 99, 235, 0.8)', 'rgba(16, 185, 129, 0.8)', 'rgba(245, 158, 11, 0.8)',
            'rgba(239, 68, 68, 0.8)', 'rgba(139, 92, 246, 0.8)', 'rgba(236, 72, 153, 0.8)',
            'rgba(59, 130, 246, 0.8)', 'rgba(34, 197, 94, 0.8)', 'rgba(251, 191, 36, 0.8)',
            'rgba(248, 113, 113, 0.8)'
        ];

        chartInstances.brandChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderColor: colors.map(color => color.replace('0.8', '1')),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1
                    }
                }
            }
        });

        document.getElementById('brandChart').style.display = 'block';
        document.getElementById('brandChart').style.height = '300px';
        document.getElementById('brandChartLoading').style.display = 'none';
    }

    function createStatusChart(disponveis, vendidos) {
        const ctx = document.getElementById('statusChart').getContext('2d');

        if (chartInstances.statusChart) {
            chartInstances.statusChart.destroy();
        }

        chartInstances.statusChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Disponíveis', 'Vendidos'],
                datasets: [{
                    data: [disponveis, vendidos],
                    backgroundColor: [
                        'rgba(37, 99, 235, 0.8)',
                        'rgba(16, 185, 129, 0.8)'
                    ],
                    borderColor: [
                        'rgba(37, 99, 235, 1)',
                        'rgba(16, 185, 129, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                const total = disponveis + vendidos;
                                const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                                return `${context.label}: ${context.raw} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        document.getElementById('statusChart').style.display = 'block';
        document.getElementById('statusChart').style.height = '300px';
        document.getElementById('statusChartLoading').style.display = 'none';
    }

    function createDecadeTable(data) {
        let html = `
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Década</th>
                        <th class="text-end">Quantidade</th>
                        <th class="text-end">Percentual</th>
                    </tr>
                </thead>
                <tbody>
    `;

        const total = data.reduce((sum, item) => sum + item.total, 0);

        data.forEach(item => {
            const percentage = total > 0 ? ((item.total / total) * 100).toFixed(1) : 0;
            html += `
            <tr>
                <td><strong>${item.decada}</strong></td>
                <td class="text-end">
                    <span class="badge bg-primary">${item.total}</span>
                </td>
                <td class="text-end">${percentage}%</td>
            </tr>
        `;
        });

        html += `
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th>Total</th>
                        <th class="text-end">
                            <span class="badge bg-success">${total}</span>
                        </th>
                        <th class="text-end">100%</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    `;

        document.getElementById('decadeTable').innerHTML = html;
        document.getElementById('decadeTable').style.display = 'block';
        document.getElementById('decadeTableLoading').style.display = 'none';
    }

    function createBrandTable(data) {
        let html = `
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Fabricante</th>
                        <th class="text-end">Quantidade</th>
                        <th class="text-end">Percentual</th>
                    </tr>
                </thead>
                <tbody>
    `;

        const total = data.reduce((sum, item) => sum + item.total, 0);

        data.forEach((item, index) => {
            const percentage = total > 0 ? ((item.total / total) * 100).toFixed(1) : 0;
            const badgeClass = index < 3 ? 'bg-success' : 'bg-primary';

            html += `
            <tr>
                <td>
                    <strong>${item.marca}</strong>
                    ${index < 3 ? '<i class="fas fa-star text-warning ms-1" title="Top 3"></i>' : ''}
                </td>
                <td class="text-end">
                    <span class="badge ${badgeClass}">${item.total}</span>
                </td>
                <td class="text-end">${percentage}%</td>
            </tr>
        `;
        });

        html += `
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th>Total</th>
                        <th class="text-end">
                            <span class="badge bg-success">${total}</span>
                        </th>
                        <th class="text-end">100%</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    `;

        document.getElementById('brandTable').innerHTML = html;
        document.getElementById('brandTable').style.display = 'block';
        document.getElementById('brandTableLoading').style.display = 'none';
    }

    function showErrorInStats() {
        const errorHtml = '<i class="fas fa-exclamation-triangle text-danger"></i>';
        document.getElementById('totalVeiculos').innerHTML = errorHtml;
        document.getElementById('veiculosDisponiveis').innerHTML = errorHtml;
        document.getElementById('veiculosVendidos').innerHTML = errorHtml;
        document.getElementById('ultimaSemana').innerHTML = errorHtml;
    }

    async function exportData(format) {
        try {
            showLoading();

            const response = await apiRequest('/veiculos');
            const vehicles = response.data;

            if (format === 'json') {
                const dataStr = JSON.stringify(vehicles, null, 2);
                downloadFile(dataStr, 'veiculos.json', 'application/json');
            } else if (format === 'csv') {
                const csvContent = convertToCSV(vehicles);
                downloadFile(csvContent, 'veiculos.csv', 'text/csv');
            }

            hideLoading();
            showSuccessToast(`Dados exportados em ${format.toUpperCase()} com sucesso!`);

        } catch (error) {
            hideLoading();
            console.error('Error exporting data:', error);
            showErrorToast('Erro ao exportar dados');
        }
    }

    function convertToCSV(data) {
        if (data.length === 0) return '';

        const headers = ['ID', 'Veículo', 'Marca', 'Ano', 'Cor', 'Vendido', 'Descrição', 'Cadastrado', 'Atualizado'];
        const csvRows = [headers.join(',')];

        data.forEach(vehicle => {
            const row = [
                vehicle.id,
                `"${vehicle.veiculo}"`,
                `"${vehicle.marca}"`,
                vehicle.ano,
                `"${vehicle.cor || ''}"`,
                vehicle.vendido ? 'Sim' : 'Não',
                `"${vehicle.descricao.replace(/"/g, '""')}"`,
                `"${formatDate(vehicle.created_at)}"`,
                `"${formatDate(vehicle.updated_at)}"`
            ];
            csvRows.push(row.join(','));
        });

        return csvRows.join('\n');
    }

    function downloadFile(content, filename, contentType) {
        const blob = new Blob([content], {
            type: contentType
        });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }

    function printReport() {
        const printWindow = window.open('', '_blank');
        const currentDate = new Date().toLocaleDateString('pt-BR');

        printWindow.document.write(`
        <html>
        <head>
            <title>Relatório de Veículos - ${currentDate}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; }
                .stats { display: flex; justify-content: space-around; margin: 20px 0; }
                .stat-box { text-align: center; padding: 15px; border: 1px solid #ddd; border-radius: 8px; }
                .stat-number { font-size: 2em; font-weight: bold; color: #2563eb; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                th { background-color: #f8f9fa; font-weight: bold; }
                .footer { margin-top: 40px; text-align: center; color: #6b7280; }
                @media print { body { margin: 0; } }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Sistema de Veículos</h1>
                <h2>Relatório Estatístico</h2>
                <p>Gerado em: ${currentDate}</p>
            </div>
            
            <div class="stats">
                <div class="stat-box">
                    <div class="stat-number">${document.getElementById('totalVeiculos').textContent}</div>
                    <div>Total de Veículos</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">${document.getElementById('veiculosDisponiveis').textContent}</div>
                    <div>Disponíveis</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">${document.getElementById('veiculosVendidos').textContent}</div>
                    <div>Vendidos</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">${document.getElementById('ultimaSemana').textContent}</div>
                    <div>Última Semana</div>
                </div>
            </div>
            
            <h3>Estatísticas por Década</h3>
            ${document.getElementById('decadeTable').innerHTML}
            
            <h3>Estatísticas por Fabricante</h3>
            ${document.getElementById('brandTable').innerHTML}
            
            <div class="footer">
                <p>Relatório gerado automaticamente pelo Sistema de Veículos</p>
            </div>
        </body>
        </html>
    `);

        printWindow.document.close();
        printWindow.focus();

        setTimeout(() => {
            printWindow.print();
        }, 250);
    }
</script>
@endpush