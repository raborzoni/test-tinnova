@extends('layouts.app')

@section('title', 'Gerenciar Veículos')

@section('content')
<div class="main-content animate-fade-in">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-car me-2 text-primary"></i>
                Gerenciar Veículos
            </h2>
            <p class="text-muted mb-0">Cadastre, edite e gerencie seu catálogo de veículos</p>
        </div>
        <button class="btn btn-success" onclick="showAddModal()">
            <i class="fas fa-plus me-2"></i>
            Novo Veículo
        </button>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Marca</label>
                    <select id="filterMarca" class="form-select">
                        <option value="">Todas as marcas</option>
                        @foreach($marcasValidas as $marca)
                        <option value="{{ $marca }}">{{ $marca }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Ano</label>
                    <input type="number" id="filterAno" class="form-control" placeholder="Ex: 2020" min="1900" max="2025">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Cor</label>
                    <input type="text" id="filterCor" class="form-control" placeholder="Ex: Branco">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Todos</option>
                        <option value="false">Disponível</option>
                        <option value="true">Vendido</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" onclick="applyFilters()">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                        <button class="btn btn-outline-secondary" onclick="clearFilters()">
                            <i class="fas fa-times me-1"></i>Limpar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Info -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span id="resultsInfo" class="text-muted">Carregando veículos...</span>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <!-- Pagination Controls -->
            <div class="d-flex align-items-center gap-2 me-3">
                <small class="text-muted" id="paginationInfo">-</small>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary" id="prevPageBtn" onclick="changePage(-1)" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="btn btn-outline-secondary disabled-btn" id="currentPageDisplay">1</span>
                    <button type="button" class="btn btn-outline-secondary" id="nextPageBtn" onclick="changePage(1)" disabled>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Items per page -->
            <div class="d-flex align-items-center gap-2 me-3">
                <small class="text-muted">Por página:</small>
                <select id="itemsPerPage" class="form-select form-select-sm" onchange="changeItemsPerPage()" style="width: auto;">
                    <option value="6">6</option>
                    <option value="9" selected>9</option>
                    <option value="12">12</option>
                    <option value="18">18</option>
                    <option value="24">24</option>
                </select>
            </div>

            <!-- Existing buttons -->
            <button class="btn btn-outline-primary btn-sm" onclick="loadVehicles()">
                <i class="fas fa-sync-alt me-1"></i>Atualizar
            </button>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-sort me-1"></i>Ordenar
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="sortVehicles('created_at', 'desc')">Mais Recentes</a></li>
                    <li><a class="dropdown-item" href="#" onclick="sortVehicles('created_at', 'asc')">Mais Antigos</a></li>
                    <li><a class="dropdown-item" href="#" onclick="sortVehicles('veiculo', 'asc')">Nome A-Z</a></li>
                    <li><a class="dropdown-item" href="#" onclick="sortVehicles('marca', 'asc')">Marca A-Z</a></li>
                    <li><a class="dropdown-item" href="#" onclick="sortVehicles('ano', 'desc')">Ano (Mais Novo)</a></li>
                    <li><a class="dropdown-item" href="#" onclick="sortVehicles('ano', 'asc')">Ano (Mais Antigo)</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Vehicles List -->
    <div id="vehiclesList">
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-3">Carregando veículos...</p>
        </div>
    </div>

    <!-- Bottom Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4" id="bottomPagination" style="display: none !important;">
        <div>
            <small class="text-muted" id="bottomPaginationInfo">-</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- Jump to page -->
            <div class="d-flex align-items-center gap-2 me-3">
                <small class="text-muted">Ir para:</small>
                <input type="number" id="jumpToPage" class="form-control form-control-sm" style="width: 70px;" min="1" onkeypress="handlePageJump(event)">
            </div>

            <!-- Full pagination buttons -->
            <div class="btn-group btn-group-sm" role="group" id="paginationButtons">
                <button type="button" class="btn btn-outline-secondary" onclick="goToPage(1)" id="firstPageBtn">
                    <i class="fas fa-angle-double-left"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="changePage(-1)" id="prevPageBtnBottom">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="btn btn-primary disabled-btn" id="currentPageBottom">1</span>
                <button type="button" class="btn btn-outline-secondary" onclick="changePage(1)" id="nextPageBtnBottom">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="goToLastPage()" id="lastPageBtn">
                    <i class="fas fa-angle-double-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Vehicle Modal -->
<div class="modal fade" id="vehicleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fas fa-plus me-2"></i>
                    Adicionar Veículo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="vehicleForm">
                    <input type="hidden" id="vehicleId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Veículo *</label>
                            <input type="text" class="form-control" id="veiculo" name="veiculo" placeholder="Ex: Civic, Corolla..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Marca *</label>
                            <select class="form-select" id="marca" name="marca" required>
                                <option value="">Selecione a marca</option>
                                @foreach($marcasValidas as $marca)
                                <option value="{{ $marca }}">{{ $marca }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ano *</label>
                            <input type="number" class="form-control" id="ano" name="ano" min="1900" max="2025" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cor</label>
                            <input type="text" class="form-control" id="cor" name="cor" placeholder="Ex: Branco, Preto...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="vendido" name="vendido">
                                <option value="false">Disponível</option>
                                <option value="true">Vendido</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descrição *</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4" placeholder="Descreva o estado do veículo, características especiais, etc." required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="saveButton" onclick="saveVehicle()">
                    <i class="fas fa-save me-2"></i>
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este veículo?</p>
                <div class="alert alert-warning">
                    <strong id="deleteVehicleName"></strong><br>
                    <small class="text-muted">Esta ação não pode ser desfeita.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton" onclick="confirmDelete()">
                    <i class="fas fa-trash me-2"></i>
                    Excluir
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Vehicle Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>
                    Detalhes do Veículo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewModalBody">
                <!-- Content loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="editFromViewButton">
                    <i class="fas fa-edit me-2"></i>
                    Editar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentVehicles = [];
    let allVehicles = [];
    let currentSort = {
        field: 'created_at',
        direction: 'desc'
    };
    let vehicleToDelete = null;
    let isEditing = false;

    let pagination = {
        currentPage: 1,
        itemsPerPage: 9,
        totalItems: 0,
        totalPages: 0
    };

    document.addEventListener('DOMContentLoaded', function() {
        loadVehicles();
    });

    async function loadVehicles() {
        try {
            showLoading();

            let url = '/veiculos';
            const params = new URLSearchParams();

            const marca = document.getElementById('filterMarca').value;
            const ano = document.getElementById('filterAno').value;
            const cor = document.getElementById('filterCor').value;

            if (marca) params.append('marca', marca);
            if (ano) params.append('ano', ano);
            if (cor) params.append('cor', cor);

            if (params.toString()) {
                url += '?' + params.toString();
            }

            const response = await apiRequest(url);
            allVehicles = response.data;

            const statusFilter = document.getElementById('filterStatus').value;
            if (statusFilter !== '') {
                const isVendido = statusFilter === 'true';
                allVehicles = allVehicles.filter(v => v.vendido === isVendido);
            }

            sortAllVehicles();

            pagination.totalItems = allVehicles.length;
            pagination.totalPages = Math.ceil(allVehicles.length / pagination.itemsPerPage);

            pagination.currentPage = 1;

            displayCurrentPage();
            updatePaginationControls();
            updateResultsInfo();

            hideLoading();
        } catch (error) {
            hideLoading();
            console.error('Error loading vehicles:', error);
            showErrorToast('Erro ao carregar veículos');

            document.getElementById('vehiclesList').innerHTML = `
            <div class="text-center py-5 text-danger">
                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                <h5>Erro ao carregar veículos</h5>
                <p>${error.message}</p>
                <button class="btn btn-primary" onclick="loadVehicles()">
                    <i class="fas fa-redo me-2"></i>Tentar Novamente
                </button>
            </div>
        `;
        }
    }

    function displayCurrentPage() {
        const startIndex = (pagination.currentPage - 1) * pagination.itemsPerPage;
        const endIndex = Math.min(startIndex + pagination.itemsPerPage, pagination.totalItems);
        currentVehicles = allVehicles.slice(startIndex, endIndex);

        displayVehicles();
    }

    function displayVehicles() {
        const container = document.getElementById('vehiclesList');

        if (allVehicles.length === 0) {
            container.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-car fa-4x text-muted mb-4"></i>
                <h4 class="text-muted">Nenhum veículo encontrado</h4>
                <p class="text-muted mb-4">Que tal adicionar o primeiro veículo ao sistema?</p>
                <button class="btn btn-success btn-lg" onclick="showAddModal()">
                    <i class="fas fa-plus me-2"></i>Adicionar Veículo
                </button>
            </div>
        `;

            document.getElementById('bottomPagination').style.display = 'none';
            return;
        }

        document.getElementById('bottomPagination').style.display = 'flex';

        let html = '<div class="row g-4">';

        currentVehicles.forEach((vehicle, index) => {
            const statusClass = vehicle.vendido ? 'success' : 'primary';
            const statusText = vehicle.vendido ? 'Vendido' : 'Disponível';
            const statusIcon = vehicle.vendido ? 'check-circle' : 'car';

            const globalIndex = ((pagination.currentPage - 1) * pagination.itemsPerPage) + index + 1;

            html += `
            <div class="col-xl-4 col-lg-6">
                <div class="card h-100 vehicle-card animate-fade-in" data-id="${vehicle.id}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <small class="badge bg-light text-dark">#${globalIndex}</small>
                                    <h5 class="card-title mb-0">${vehicle.veiculo}</h5>
                                </div>
                                <h6 class="card-subtitle text-muted">${vehicle.marca} • ${vehicle.ano}</h6>
                            </div>
                            <span class="badge bg-${statusClass}">
                                <i class="fas fa-${statusIcon} me-1"></i>${statusText}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-palette me-1"></i>
                                ${vehicle.cor || 'Cor não informada'}
                            </small>
                        </div>
                        
                        <p class="card-text text-muted">
                            ${vehicle.descricao.length > 100 ? vehicle.descricao.substring(0, 100) + '...' : vehicle.descricao}
                        </p>
                        
                        <div class="text-muted small mb-3">
                            <i class="fas fa-calendar me-1"></i>
                            Cadastrado em ${formatDate(vehicle.created_at)}
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-info btn-sm" onclick="viewVehicle(${vehicle.id})" title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editVehicle(${vehicle.id})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-${vehicle.vendido ? 'secondary' : 'success'} btn-sm" 
                                    onclick="toggleVendido(${vehicle.id}, ${vehicle.vendido})" 
                                    title="${vehicle.vendido ? 'Marcar como Disponível' : 'Marcar como Vendido'}">
                                <i class="fas fa-${vehicle.vendido ? 'undo' : 'check'}"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteVehicle(${vehicle.id})" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        });

        html += '</div>';
        container.innerHTML = html;
    }

    function updatePaginationControls() {
        const {
            currentPage,
            totalPages,
            totalItems,
            itemsPerPage
        } = pagination;

        const startItem = totalItems === 0 ? 0 : ((currentPage - 1) * itemsPerPage) + 1;
        const endItem = Math.min(currentPage * itemsPerPage, totalItems);

        document.getElementById('paginationInfo').textContent = `${startItem}-${endItem} de ${totalItems}`;
        document.getElementById('bottomPaginationInfo').textContent = `Página ${currentPage} de ${totalPages} (${totalItems} veículos)`;

        document.getElementById('currentPageDisplay').textContent = currentPage;
        document.getElementById('currentPageBottom').textContent = currentPage;

        document.getElementById('jumpToPage').max = totalPages;
        document.getElementById('jumpToPage').value = '';

        const isFirstPage = currentPage <= 1;
        const isLastPage = currentPage >= totalPages;

        document.getElementById('prevPageBtn').disabled = isFirstPage;
        document.getElementById('nextPageBtn').disabled = isLastPage;
        document.getElementById('prevPageBtnBottom').disabled = isFirstPage;
        document.getElementById('nextPageBtnBottom').disabled = isLastPage;
        document.getElementById('firstPageBtn').disabled = isFirstPage;
        document.getElementById('lastPageBtn').disabled = isLastPage;
    }

    function updateResultsInfo() {
        const disponveis = allVehicles.filter(v => !v.vendido).length;
        const vendidos = allVehicles.filter(v => v.vendido).length;
        const total = allVehicles.length;

        document.getElementById('resultsInfo').innerHTML = `
        <strong>${total}</strong> veículo${total !== 1 ? 's' : ''} encontrado${total !== 1 ? 's' : ''} • 
        <span class="text-primary">${disponveis} disponível${disponveis !== 1 ? 'is' : ''}</span> • 
        <span class="text-success">${vendidos} vendido${vendidos !== 1 ? 's' : ''}</span>
    `;
    }

    function changePage(direction) {
        const newPage = pagination.currentPage + direction;

        if (newPage >= 1 && newPage <= pagination.totalPages) {
            pagination.currentPage = newPage;
            displayCurrentPage();
            updatePaginationControls();

            document.getElementById('vehiclesList').scrollIntoView({
                behavior: 'smooth'
            });
        }
    }

    function goToPage(page) {
        if (page >= 1 && page <= pagination.totalPages) {
            pagination.currentPage = page;
            displayCurrentPage();
            updatePaginationControls();

            document.getElementById('vehiclesList').scrollIntoView({
                behavior: 'smooth'
            });
        }
    }

    function goToLastPage() {
        goToPage(pagination.totalPages);
    }

    function handlePageJump(event) {
        if (event.key === 'Enter') {
            const page = parseInt(event.target.value);
            if (!isNaN(page)) {
                goToPage(page);
            }
        }
    }

    function changeItemsPerPage() {
        const newItemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
        pagination.itemsPerPage = newItemsPerPage;
        pagination.totalPages = Math.ceil(pagination.totalItems / pagination.itemsPerPage);

        if (pagination.currentPage > pagination.totalPages) {
            pagination.currentPage = pagination.totalPages || 1;
        }

        displayCurrentPage();
        updatePaginationControls();
    }

    function sortAllVehicles() {
        allVehicles.sort((a, b) => {
            let aVal = a[currentSort.field];
            let bVal = b[currentSort.field];

            if (typeof aVal === 'string') {
                aVal = aVal.toLowerCase();
                bVal = bVal.toLowerCase();
            }

            if (currentSort.direction === 'asc') {
                return aVal > bVal ? 1 : -1;
            } else {
                return aVal < bVal ? 1 : -1;
            }
        });
    }

    function sortVehicles(field, direction) {
        currentSort = {
            field,
            direction
        };
        sortAllVehicles();

        pagination.currentPage = 1;
        displayCurrentPage();
        updatePaginationControls();
    }

    function applyFilters() {
        loadVehicles();
    }

    function clearFilters() {
        document.getElementById('filterMarca').value = '';
        document.getElementById('filterAno').value = '';
        document.getElementById('filterCor').value = '';
        document.getElementById('filterStatus').value = '';
        loadVehicles();
    }

    function showAddModal() {
        isEditing = false;
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus me-2"></i>Adicionar Veículo';
        document.getElementById('saveButton').innerHTML = '<i class="fas fa-save me-2"></i>Salvar';
        document.getElementById('vehicleForm').reset();
        document.getElementById('vehicleId').value = '';

        const modal = new bootstrap.Modal(document.getElementById('vehicleModal'));
        modal.show();
    }

    async function editVehicle(id) {
        try {
            const vehicle = currentVehicles.find(v => v.id === id);
            if (!vehicle) {
                showErrorToast('Veículo não encontrado');
                return;
            }

            isEditing = true;
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Editar Veículo';
            document.getElementById('saveButton').innerHTML = '<i class="fas fa-save me-2"></i>Atualizar';

            document.getElementById('vehicleId').value = vehicle.id;
            document.getElementById('veiculo').value = vehicle.veiculo;
            document.getElementById('marca').value = vehicle.marca;
            document.getElementById('ano').value = vehicle.ano;
            document.getElementById('cor').value = vehicle.cor || '';
            document.getElementById('vendido').value = vehicle.vendido.toString();
            document.getElementById('descricao').value = vehicle.descricao;

            const modal = new bootstrap.Modal(document.getElementById('vehicleModal'));
            modal.show();

        } catch (error) {
            console.error('Error editing vehicle:', error);
            showErrorToast('Erro ao editar veículo');
        }
    }

    async function saveVehicle() {
        const form = document.getElementById('vehicleForm');
        const formData = new FormData(form);

        const data = {
            veiculo: formData.get('veiculo'),
            marca: formData.get('marca'),
            ano: parseInt(formData.get('ano')),
            cor: formData.get('cor'),
            descricao: formData.get('descricao'),
            vendido: formData.get('vendido') === 'true'
        };

        if (!data.veiculo || !data.marca || !data.ano || !data.descricao) {
            showErrorToast('Por favor, preencha todos os campos obrigatórios');
            return;
        }

        try {
            showLoading();

            let response;
            if (isEditing) {
                const id = document.getElementById('vehicleId').value;
                response = await apiRequest(`/veiculos/${id}`, {
                    method: 'PUT',
                    body: JSON.stringify(data)
                });
            } else {
                response = await apiRequest('/veiculos', {
                    method: 'POST',
                    body: JSON.stringify(data)
                });
            }

            hideLoading();
            showSuccessToast(isEditing ? 'Veículo atualizado com sucesso!' : 'Veículo cadastrado com sucesso!');

            const modal = bootstrap.Modal.getInstance(document.getElementById('vehicleModal'));
            modal.hide();

            await loadVehicles();

        } catch (error) {
            hideLoading();
            console.error('Error saving vehicle:', error);
            showErrorToast(error.message || 'Erro ao salvar veículo');
        }
    }

    async function toggleVendido(id, currentStatus) {
        try {
            showLoading();

            const response = await apiRequest(`/veiculos/${id}`, {
                method: 'PATCH',
                body: JSON.stringify({
                    vendido: !currentStatus
                })
            });

            hideLoading();
            showSuccessToast(`Veículo marcado como ${!currentStatus ? 'vendido' : 'disponível'}!`);

            const vehicle = currentVehicles.find(v => v.id === id);
            if (vehicle) {
                vehicle.vendido = !currentStatus;
                displayVehicles();
                updateResultsInfo();
            }

        } catch (error) {
            hideLoading();
            console.error('Error toggling vehicle status:', error);
            showErrorToast('Erro ao atualizar status do veículo');
        }
    }

    function deleteVehicle(id) {
        const vehicle = currentVehicles.find(v => v.id === id);
        if (!vehicle) {
            showErrorToast('Veículo não encontrado');
            return;
        }

        vehicleToDelete = id;
        document.getElementById('deleteVehicleName').textContent = `${vehicle.veiculo} - ${vehicle.marca} (${vehicle.ano})`;

        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    async function confirmDelete() {
        if (!vehicleToDelete) return;

        try {
            showLoading();

            await apiRequest(`/veiculos/${vehicleToDelete}`, {
                method: 'DELETE'
            });

            hideLoading();
            showSuccessToast('Veículo excluído com sucesso!');

            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();

            vehicleToDelete = null;

            await loadVehicles();

        } catch (error) {
            hideLoading();
            console.error('Error deleting vehicle:', error);
            showErrorToast('Erro ao excluir veículo');
        }
    }

    async function viewVehicle(id) {
        try {
            const vehicle = currentVehicles.find(v => v.id === id);
            if (!vehicle) {
                showErrorToast('Veículo não encontrado');
                return;
            }

            const statusBadge = vehicle.vendido ?
                '<span class="badge bg-success fs-6"><i class="fas fa-check-circle me-1"></i>Vendido</span>' :
                '<span class="badge bg-primary fs-6"><i class="fas fa-car me-1"></i>Disponível</span>';

            const modalBody = document.getElementById('viewModalBody');
            modalBody.innerHTML = `
            <div class="row g-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="mb-1">${vehicle.veiculo}</h4>
                            <h5 class="text-muted">${vehicle.marca}</h5>
                        </div>
                        ${statusBadge}
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Informações Básicas
                            </h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td><strong>Ano:</strong></td>
                                    <td>${vehicle.ano}</td>
                                </tr>
                                <tr>
                                    <td><strong>Cor:</strong></td>
                                    <td>${vehicle.cor || 'Não informado'}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>${vehicle.vendido ? 'Vendido' : 'Disponível'}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-calendar me-2 text-info"></i>
                                Datas
                            </h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td><strong>Cadastrado:</strong></td>
                                    <td>${formatDate(vehicle.created_at)}</td>
                                </tr>
                                <tr>
                                    <td><strong>Atualizado:</strong></td>
                                    <td>${formatDate(vehicle.updated_at)}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-file-text me-2 text-warning"></i>
                                Descrição
                            </h6>
                            <p class="mb-0">${vehicle.descricao}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

            document.getElementById('editFromViewButton').onclick = function() {
                const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewModal'));
                viewModal.hide();
                setTimeout(() => editVehicle(id), 300);
            };

            const modal = new bootstrap.Modal(document.getElementById('viewModal'));
            modal.show();

        } catch (error) {
            console.error('Error viewing vehicle:', error);
            showErrorToast('Erro ao visualizar veículo');
        }
    }
</script>
@endpush