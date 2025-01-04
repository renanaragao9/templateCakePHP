<?php

use App\Utility\AccessChecker;

$loggedUserId = $this->request->getSession()->read('Auth.User.id');
$this->assign('title', 'Usuários');
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>">Início</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= __('Usuários') ?></li>
                    </ol>
                    <hr>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-s12">
                <h1 class="page-title m-0"><?= __('Usuários') ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <form class="form-inline w-100" method="get" action="<?= $this->Url->build() ?>">
                                <div class="input-group w-100">
                                    <input id="searchInput" class="form-control col-12" type="search" placeholder="Pesquisar..." aria-label="Pesquisar" name="search" value="<?= $this->request->getQuery('search') ?>">
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-md-6 text-md-right">
                            <?php if (AccessChecker::hasPermission($loggedUserId, 'Users/add')): ?>
                                <button type="button" class="btn btn-add btn-sm mb-2 mb-md-0 col-12 col-md-auto" data-toggle="modal" data-target="#addNewItemModal">
                                    <i class="fas fa-plus-circle"></i> Adicionar Usuário
                                </button>
                                <button type="button" class="btn btn-add btn-filter btn-sm mb-0 col-12 col-md-auto" data-toggle="modal" data-target="#filterModal">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                            <?php endif; ?>
                            <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-refresh btn-sm mb-0 col-12 col-md-auto text-dark dark-mode-text-white">
                                <i class="fas fa-sync-alt"></i> Atualizar
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;" id="refreshSpinner"></span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                                    <th><?= $this->Paginator->sort('name', 'Nome') ?></th>
                                    <th><?= $this->Paginator->sort('email', 'Email') ?></th>
                                    <th><?= $this->Paginator->sort('role_id', 'Perfil') ?></th>
                                    <th><?= $this->Paginator->sort('last_login', 'Último Login') ?></th>
                                    <th><?= $this->Paginator->sort('active', 'Ativo') ?></th>
                                    <th class="actions"><?= __('Ações') ?></th>
                                </tr>
                            </thead>
                            <tbody id="TableBody">
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $this->Number->format($user->id) ?></td>
                                        <td><?= h($user->name) ?></td>
                                        <td><?= h($user->email) ?></td>
                                        <td><?= $user->role_id ? h($user->role->name) : 'N/A' ?></td>
                                        <td><?= $user->last_login ? $user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss') : 'N/A' ?></td>
                                        <td><?= h($user->active ? 'Sim' : 'Não') ?></td>
                                        <td class="actions">
                                            <a href="#" class="btn btn-view btn-sm" data-toggle="modal" data-target="#detailsModal-<?= $user->id ?>"><i class="fas fa-eye"></i></a>
                                            <?php if (AccessChecker::hasPermission($loggedUserId, 'Users/edit')): ?>
                                                <a href="#" class="btn btn-edit btn-sm" data-toggle="modal" data-target="#editModal-<?= $user->id ?>"><i class="fas fa-edit"></i></a>
                                            <?php endif; ?>
                                            <?php if (AccessChecker::hasPermission($loggedUserId, 'Users/delete')): ?>
                                                <a href="#" class="btn btn-delete btn-sm" data-toggle="modal" data-target="#deleteModal-<?= $user->id ?>"><i class="fas fa-trash"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Incluir os modais de edição, visualização e exclusão -->
                                    <?php
                                    include __DIR__ . '/edit.php';
                                    include __DIR__ . '/view.php';
                                    ?>

                                    <div class="modal fade" id="deleteModal-<?= $user->id ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-<?= $user->id ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel-<?= $user->id ?>"><?= __('Confirmar Exclusão') ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?= __('Você tem certeza que deseja excluir # {0}?', $user->name) ?></p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn modalCancel" data-dismiss="modal">Cancelar</button>
                                                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $user->id], ['class' => 'btn modalDelete', 'id' => 'deleteButton' . $user->id, 'data-id' => $user->id]) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <?= $this->Paginator->first('<< ' . __('primeira')) ?>
                            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
                            <?= $this->Paginator->next(__('próxima') . ' >') ?>
                            <?= $this->Paginator->last(__('última') . ' >>') ?>
                        </ul>
                        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de um total de {{count}}')) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Filtragem e Geração de PDF -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Gerar Filtro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-lg">
                <form id="filterForm" method="get" action="<?= $this->Url->build(['action' => 'pdf']) ?>">
                    <div id="conditions-container">
                        <div class="form-group row condition-template">
                            <div class="col-md-2">
                                <label for="field">Campo</label>
                                <select class="form-control" name="fields[]" id="field" onchange="updateInputType(this)">
                                    <?php foreach ($fields as $field => $data): ?>
                                        <option value="<?= $field ?>" data-type="<?= $data['type'] ?>"><?= $data['label'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="condition">Condição</label>
                                <select class="form-control" name="conditions[]" id="condition" onchange="toggleBetweenInput(this)">
                                    <?php foreach ($conditions as $condition => $label): ?>
                                        <option value="<?= $condition ?>"><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="value">Valor</label>
                                <input type="text" class="form-control" name="values[]" id="value" placeholder="Valor">
                            </div>
                            <div class="col-md-3" style="display: none;" id="value2-container">
                                <label for="value2">Valor 2</label>
                                <input type="text" class="form-control" name="values2[]" id="value2" placeholder="Valor 2">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btnTrash btn-sm w-100 mt-4 mt-md-0" onclick="removeCondition(this)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btnConditions" id="add-condition">Adicionar Condição</button>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn modalCancel" data-dismiss="modal">Fechar</button>
                <div>
                    <button type="submit" class="btn btnPDF" id="applyPDF" form="filterForm">
                        <i class="fas fa-file-pdf"></i> Gerar PDF
                    </button>
                    <button type="button" class="btn btnCSV" id="applyCSV" onclick="applyCSV()">
                        <i class="fas fa-file-csv"></i> Gerar CSV
                    </button>
                    <button type="button" class="btn btnFilter" id="applyFilter" onclick="applyFilter()">
                        <i class="fas fa-filter"></i> Aplicar Filtro
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function searchTableBody(query) {
        $.ajax({
            url: '<?= $this->Url->build(['controller' => 'users', 'action' => 'index']) ?>',
            method: 'GET',
            data: {
                search: query
            },
            success: function(response) {
                var tableBody = $(response).find('#TableBody').html();
                if (tableBody.trim() === '') {
                    $('#TableBody').html('<tr><td colspan="9">Não foi possível encontrar resultados para "' + query + '".</td></tr>');
                } else {
                    $('#TableBody').html(tableBody);
                }
            },
            error: function() {
                console.log('Erro ao realizar a pesquisa.');
            }
        });
    }

    function applyFilter() {
        var form = document.getElementById("filterForm");
        form.action = "<?= $this->Url->build(['action' => 'index']) ?>";
        form.submit();
    }

    function applyCSV() {
        var form = document.getElementById("filterForm");
        form.action = "<?= $this->Url->build(['action' => 'csv']) ?>";
        form.submit();
    }

    (function() {
        Object.freeze(searchTableBody);
        Object.freeze(applyFilter);
        Object.freeze(applyCSV);
    })();
</script>

<?php include __DIR__ . '/add.php'; ?>