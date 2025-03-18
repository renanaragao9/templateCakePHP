<?php

use App\Utility\AccessChecker;

$loggedUserId = $this->request->getSession()->read('Auth.User.id');
$this->assign('title', 'Usuários');
?>

<div class="content mt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6 order-2 order-md-1 mt-4">
                                    <h3 class="card-title">
                                        <?= __('Gerenciar usuários') ?>
                                    </h3>
                                </div>
                                <div class="col-12 col-md-6 text-md-right order-1 order-md-2">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb justify-content-md-end">
                                            <li class="breadcrumb-item">
                                                <a class="bread-crumb-home"
                                                    href="<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>"><i
                                                        class="fa-regular fa-house"></i>
                                                    Início
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                <?= __('Usuários') ?>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <hr />
                        </div>
                    </div>
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <form class="form-inline w-100" method="get" action="<?= $this->Url->build() ?>" onsubmit="return false;">
                                <div class="input-group">
                                    <input id="searchInput" class="form-control col-12" type="search" placeholder="Pesquisar..." aria-label="Pesquisar" name="search" value="<?= $this->request->getQuery('search') ?>" />
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-md-6 text-md-right">
                            <?php if (AccessChecker::hasPermission($loggedUserId, 'users/add')): ?>
                                <button type="button" class="btn btn-add btn-sm mb-2 mb-md-0 col-12 col-md-auto" data-toggle="modal" data-target="#addNewItemModal">
                                    Adicionar
                                </button>
                            <?php endif; ?>
                            <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-refresh btn-sm mb-0 col-12 col-md-auto text-dark dark-mode-text-white" id="refreshButton">
                                <i class="fa-light fa-arrows-rotate" id="refreshIcon"></i>
                                Atualizar
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none" id="refreshSpinner"></span>
                            </a>
                            <a href="<?= $this->Url->build(['action' => 'export']) ?>" class="btn btn-export btn-sm mb-0 col-12 col-md-auto text-dark dark-mode-text-white" id="exportButton">
                                <i class="fa-regular fa-file-csv"></i>
                                Exportar
                            </a>
                            <button type="button" class="btn btn-filter btn-sm mb-2 mb-md-0 col-12 col-md-auto" data-toggle="modal" data-target="#filterModal">
                                <i class="fa-regular fa-filter-list"></i>
                                Filtrar
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        <?= $this->Paginator->sort('id', 'ID') ?>
                                    </th>
                                    <th>
                                        <?= $this->Paginator->sort('name', 'Nome') ?>
                                    </th>
                                    <th>
                                        <?= $this->Paginator->sort('email', 'Email') ?>
                                    </th>
                                    <th>
                                        <?= $this->Paginator->sort('last_login', 'Último Login') ?>
                                    </th>
                                    <th>
                                        <?= $this->Paginator->sort('active', 'Ativo') ?>
                                    </th>
                                    <th>
                                        <?= $this->Paginator->sort('role_id', 'Função') ?>
                                    </th>
                                    <th class="actions">
                                        <?= __('Ações') ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="TableBody">
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td>
                                            <?= $this->Number->format($user->id) ?>
                                        </td>
                                        <td>
                                            <?= h($user->name) ?>
                                        </td>
                                        <td>
                                            <?= h($user->email) ?>
                                        </td>
                                        <td>
                                            <?= h($user->last_login) ? h($user->last_login) : '-' ?>
                                        </td>
                                        <td>
                                            <?= h($user->active) ? 'Sim' : 'Não' ?>
                                        </td>
                                        <td>
                                            <?= $user->role ? h($user->role->name) : '-' ?>
                                        </td>
                                        <td class="actions">
                                            <a href="#" class="btn btn-view btn-sm" data-toggle="modal" data-target="#detailsModal-<?= $user->id ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if (AccessChecker::hasPermission($loggedUserId, 'users/edit')): ?>
                                                <a href="#" class="btn btn-edit btn-sm" data-toggle="modal" data-target="#editModal-<?= $user->id ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (AccessChecker::hasPermission($loggedUserId, 'users/delete')): ?>
                                                <a href="#" class="btn btn-delete btn-sm" data-toggle="modal" data-target="#deleteModal-<?= $user->id ?>">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <?php
                                    include __DIR__ . '/edit.php';
                                    include __DIR__ . '/delete.php';
                                    include __DIR__ . '/view_index.php';
                                    ?>

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
                        <p>
                            <?= $this->Paginator->counter(__('Página
                            {{page}} de {{pages}}, mostrando {{current}}
                            registro(s) de um total de {{count}}')) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include __DIR__ . '/add.php';
include __DIR__ . '/filter.php';
?>

<script>
    var searchUrl = '<?= $this->Url->build(['action' => 'index']) ?>';
</script>

<?php $this->Html->script('Global/index.js', ['block' => true]); ?>