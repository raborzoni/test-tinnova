@extends('layouts.app')

@section('title', 'Teste')

@section('content')
<div class="hero-section animate-fade-in">
    <h1 class="hero-title">
        <i class="fas fa-car me-3"></i>
        Sistema de Veículos
    </h1>
    <p class="hero-subtitle">
        Gerencie seu catálogo de veículos de forma simples e eficiente com a Tinnova
    </p>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="{{ route('veiculos') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-car me-2"></i>
            Gerenciar Veículos
        </a>
        <a href="{{ route('estatisticas') }}" class="btn btn-stats colortext btn-lg">
            <i class="fas fa-chart-bar me-2"></i>
            Ver Estatísticas
        </a>
    </div>
</div>

<div class="row g-4 animate-slide-up">
    <!-- Quick Stats -->
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-number" id="totalVeiculos">
                <i class="fas fa-spinner fa-pulse"></i>
            </div>
            <div class="stat-label">Total de Veículos</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-number" id="veiculosDisponiveis">
                <i class="fas fa-spinner fa-pulse"></i>
            </div>
            <div class="stat-label">Disponíveis</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-number" id="veiculosVendidos">
                <i class="fas fa-spinner fa-pulse"></i>
            </div>
            <div class="stat-label">Vendidos</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-number" id="ultimaSemana">
                <i class="fas fa-spinner fa-pulse"></i>
            </div>
            <div class="stat-label">Última Semana</div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <!-- Recent Vehicles -->
    <div class="col-lg-8">
        <div class="card animate-slide-up">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2 text-primary"></i>
                    Veículos Recentes
                </h5>
            </div>
            <div class="card-body">
                <div id="recentVehicles">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2">Carregando veículos recentes...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card animate-slide-up">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2 text-primary"></i>
                    Ações Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <button class="btn btn-primary" onclick="loadStatistics()">
                        <i class="fas fa-sync-alt me-2"></i>
                        Atualizar Status
                    </button>
                    <button class="btn btn-success" onclick="showAddVehicleModal()">
                        <i class="fas fa-plus me-2"></i>
                        Adicionar Veículo
                    </button>
                    <a href="{{ route('veiculos') }}" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>
                        Buscar Veículos
                    </a>
                    <a href="{{ route('estatisticas') }}" class="btn btn-stats colortext">
                        <i class="fas fa-chart-pie me-2"></i>
                        Ver Relatórios
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Add Vehicle Modal -->
<div class="modal fade" id="quickAddModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>
                    Adicionar Veículo Rapidamente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="quickAddForm">
                    <div class="mb-3">
                        <label class="form-label">Veículo *</label>
                        <input type="text" class="form-control" name="veiculo" placeholder="Ex: Civic, Corolla..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Marca *</label>
                        <select class="form-select" name="marca" required>
                            <option value="">Selecione a marca</option>
                            <option value="Audi">Audi</option>
                            <option value="BMW">BMW</option>
                            <option value="Chevrolet">Chevrolet</option>
                            <option value="Citroën">Citroën</option>
                            <option value="Fiat">Fiat</option>
                            <option value="Ford">Ford</option>
                            <option value="Honda">Honda</option>
                            <option value="Hyundai">Hyundai</option>
                            <option value="Jeep">Jeep</option>
                            <option value="Kia">Kia</option>
                            <option value="Mitsubishi">Mitsubishi</option>
                            <option value="Nissan">Nissan</option>
                            <option value="Peugeot">Peugeot</option>
                            <option value="Renault">Renault</option>
                            <option value="Toyota">Toyota</option>
                            <option value="Volkswagen">Volkswagen</option>
                            <option value="Volvo">Volvo</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ano *</label>
                                <input type="number" class="form-control" name="ano" min="1900" max="2025" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cor</label>
                                <input type="text" class="form-control" name="cor" placeholder="Ex: Branco, Preto...">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição *</label>
                        <textarea class="form-control" name="descricao" rows="3" placeholder="Descreva o estado do veículo..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" onclick="submitQuickAdd()">
                    <i class="fas fa-save me-2"></i>
                    Salvar Veículo
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboardData();
    });

    async function loadDashboardData() {
        try {
            await loadStatistics();

            await loadRecentVehicles();
        } catch (error) {
            console.error('Error loading dashboard:', error);
            showErrorToast('Erro ao carregar dados do dashboard');
        }
    }

    async function loadStatistics() {
        try {
            const [allVehicles] = await Promise.all([
                apiRequest('/veiculos')
            ]);

            const vehicles = allVehicles.data;
            const total = vehicles.length;
            const disponveis = vehicles.filter(v => !v.vendido).length;
            const vendidos = vehicles.filter(v => v.vendido).length;

            const lastWeekResponse = await apiRequest('/veiculos/ultima-semana');
            const lastWeek = lastWeekResponse.total;

            document.getElementById('totalVeiculos').textContent = total;
            document.getElementById('veiculosDisponiveis').textContent = disponveis;
            document.getElementById('veiculosVendidos').textContent = vendidos;
            document.getElementById('ultimaSemana').textContent = lastWeek;

        } catch (error) {
            console.error('Error loading statistics:', error);
            document.getElementById('totalVeiculos').innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i>';
            document.getElementById('veiculosDisponiveis').innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i>';
            document.getElementById('veiculosVendidos').innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i>';
            document.getElementById('ultimaSemana').innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i>';
        }
    }

    async function loadRecentVehicles() {
        try {
            const response = await apiRequest('/veiculos');
            const vehicles = response.data.slice(0, 5);

            const container = document.getElementById('recentVehicles');

            if (vehicles.length === 0) {
                container.innerHTML = `
                <div class="text-center text-muted">
                    <i class="fas fa-car fa-3x mb-3"></i>
                    <p>Nenhum veículo cadastrado ainda.</p>
                    <button class="btn btn-primary" onclick="showAddVehicleModal()">
                        <i class="fas fa-plus me-2"></i>Adicionar Primeiro Veículo
                    </button>
                </div>
            `;
                return;
            }

            let html = '<div class="list-group list-group-flush">';

            vehicles.forEach(vehicle => {
                const statusBadge = vehicle.vendido ?
                    '<span class="badge bg-success">Vendido</span>' :
                    '<span class="badge bg-primary">Disponível</span>';

                html += `
                <div class="list-group-item border-0 px-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">${vehicle.veiculo} - ${vehicle.marca}</h6>
                            <p class="mb-1 text-muted">${vehicle.ano} • ${vehicle.cor || 'Cor não informada'}</p>
                            <small class="text-muted">Cadastrado em ${formatDate(vehicle.created_at)}</small>
                        </div>
                        <div class="text-end">
                            ${statusBadge}
                        </div>
                    </div>
                </div>
            `;
            });

            html += '</div>';

            if (vehicles.length === 5) {
                html += `
                <div class="text-center mt-3">
                    <a href="/veiculos" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>Ver Todos os Veículos
                    </a>
                </div>
            `;
            }

            container.innerHTML = html;

        } catch (error) {
            console.error('Error loading recent vehicles:', error);
            document.getElementById('recentVehicles').innerHTML = `
            <div class="text-center text-danger">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <p>Erro ao carregar veículos recentes</p>
                <button class="btn btn-outline-danger btn-sm" onclick="loadRecentVehicles()">
                    <i class="fas fa-redo me-1"></i>Tentar Novamente
                </button>
            </div>
        `;
        }
    }

    function showAddVehicleModal() {
        const modal = new bootstrap.Modal(document.getElementById('quickAddModal'));
        modal.show();
    }

    async function submitQuickAdd() {
        const form = document.getElementById('quickAddForm');
        const formData = new FormData(form);

        const data = {
            veiculo: formData.get('veiculo'),
            marca: formData.get('marca'),
            ano: parseInt(formData.get('ano')),
            cor: formData.get('cor'),
            descricao: formData.get('descricao'),
            vendido: false
        };

        try {
            showLoading();

            const response = await apiRequest('/veiculos', {
                method: 'POST',
                body: JSON.stringify(data)
            });

            hideLoading();
            showSuccessToast('Veículo cadastrado com sucesso!');

            const modal = bootstrap.Modal.getInstance(document.getElementById('quickAddModal'));
            modal.hide();

            form.reset();

            await loadDashboardData();

        } catch (error) {
            hideLoading();
            console.error('Error adding vehicle:', error);
            showErrorToast(error.message || 'Erro ao cadastrar veículo');
        }
    }
</script>
@endpush