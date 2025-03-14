<?php

use App\Utility\AccessChecker;

$loggedUserId = $this->request->getSession()->read('Auth.User.id');
$this->assign('title', 'Titulo'); ?>

<div class="content mt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div
                                    class="col-12 col-md-6 order-2 order-md-1 mt-4"
                                >
                                    <h3 class="card-title">
                                        <?= __('Gerenciar users') ?>
                                    </h3>
                                </div>
                                <div
                                    class="col-12 col-md-6 text-md-right order-1 order-md-2"
                                >
                                    <nav aria-label="breadcrumb">
                                        <ol
                                            class="breadcrumb justify-content-md-end"
                                        >
                                            <li class="breadcrumb-item">
                                                <a
                                                    class="bread-crumb-home"
                                                    href="<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>"
                                                    ><i
                                                        class="fa-regular fa-house"
                                                    ></i>
                                                    Início</a
                                                >
                                            </li>
                                            <li
                                                class="breadcrumb-item active"
                                                aria-current="page"
                                            >
                                                <?= __('users') ?>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <hr />
                        </div>
                    </div>
                    <div
                        class="card-header d-flex justify-content-between align-items-center flex-wrap"
                    >
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <form
                                class="form-inline w-100"
                                method="get"
                                action="<?= $this->Url->build() ?>"
                                onsubmit="return false;"
                            >
                                <div class="input-group">
                                    <input
                                        id="searchInput"
                                        class="form-control col-12"
                                        type="search"
                                        placeholder="Pesquisar..."
                                        aria-label="Pesquisar"
                                        name="search"
                                        value="<?= $this->request->getQuery('search') ?>"
                                    />
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-md-6 text-md-right">
                            <?php if (AccessChecker::hasPermission($loggedUserId, 'users/add')): ?>
                            <button
                                type="button"
                                class="btn btn-add btn-sm mb-2 mb-md-0 col-12 col-md-auto"
                                data-toggle="modal"
                                data-target="#addNewItemModal"
                            >
                                Adicionar
                            </button>
                            <?php endif; ?>
                            <a
                                href="<?= $this->Url->build(['action' => 'index']) ?>"
                                class="btn btn-refresh btn-sm mb-0 col-12 col-md-auto text-dark dark-mode-text-white"
                                id="refreshButton"
                            >
                                <i
                                    class="fa-light fa-arrows-rotate"
                                    id="refreshIcon"
                                ></i>
                                Atualizar
                                <span
                                    class="spinner-border spinner-border-sm"
                                    role="status"
                                    aria-hidden="true"
                                    style="display: none"
                                    id="refreshSpinner"
                                ></span>
                            </a>
                            <a
                                href="<?= $this->Url->build(['action' => 'export']) ?>"
                                class="btn btn-export btn-sm mb-0 col-12 col-md-auto text-dark dark-mode-text-white"
                                id="exportButton"
                            >
                                <i class="fa-regular fa-file-csv"></i>
                                Exportar
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                                                        <th>
                                        <?= $this->Paginator->sort('id') ?>
                                    </th>
                                                                        <th>
                                        <?= $this->Paginator->sort('name') ?>
                                    </th>
                                                                        <th>
                                        <?= $this->Paginator->sort('email') ?>
                                    </th>
                                                                        <th>
                                        <?= $this->Paginator->sort('last_login') ?>
                                    </th>
                                                                        <th>
                                        <?= $this->Paginator->sort('login_count') ?>
                                    </th>
                                                                        <th>
                                        <?= $this->Paginator->sort('active') ?>
                                    </th>
                                                                        <th>
                                        <?= $this->Paginator->sort('role_id') ?>
                                    </th>
                                                                        <th>
                                        <?= $this->Paginator->sort('created') ?>
                                    </th>
                                                                        <th>
                                        <?= $this->Paginator->sort('modified') ?>
                                    </th>
                                                                        <th class="actions"><?= __('Ações') ?></th>
                                </tr>
                            </thead>
                            <tbody id="TableBody">
                                <?php foreach ($users as $user): ?>
                                <tr>
                                                                                 <td>
                                        <?= $this->Number->format($user->id) ?>
                                    </td>
                                                                                   <td>
                                        <?= h($user->name)
                                        ?>
                                    </td>
                                                                                   <td>
                                        <?= h($user->email)
                                        ?>
                                    </td>
                                                                                   <td>
                                        <?= h($user->last_login)
                                        ?>
                                    </td>
                                                                                   <td>
                                        <?= $this->Number->format($user->login_count) ?>
                                    </td>
                                                                                   <td>
                                        <?= h($user->active)
                                        ?>
                                    </td>
                                                                               <td>
                                        <?= $user->role
                                        ? h($user->role->name) : '-' ?>
                                    </td>
                                                                                     <td>
                                        <?= h($user->created)
                                        ?>
                                    </td>
                                                                                   <td>
                                        <?= h($user->modified)
                                        ?>
                                    </td>
                                                                           <td class="actions">
                                        <a
                                            href="#"
                                            class="btn btn-view btn-sm"
                                            data-toggle="modal"
                                            data-target="#detailsModal-<?= $user->id ?>"
                                            ><i class="fas fa-eye"></i
                                        ></a>
                                        <?php if (AccessChecker::hasPermission($loggedUserId, 'users/edit')): ?>
                                        <a
                                            href="#"
                                            class="btn btn-edit btn-sm"
                                            data-toggle="modal"
                                            data-target="#editModal-<?= $user->id ?>"
                                            ><i class="fas fa-edit"></i
                                        ></a>
                                        <?php endif; ?>
                                        <?php if (AccessChecker::hasPermission($loggedUserId, 'users/delete')): ?>
                                        <a
                                            href="#"
                                            class="btn btn-delete btn-sm"
                                            data-toggle="modal"
                                            data-target="#deleteModal-<?= $user->id ?>"
                                            ><i class="fas fa-trash"></i
                                        ></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- Incluir os modais de edição, visualização e exclusão -->
                                <?php
                                include __DIR__ . '/add.php';
                                include __DIR__ . '/edit.php';
                                #include __DIR__ . '/view.php';
                                ?>

                                <!-- Modal de Delete -->
                                <div
                                    class="modal fade"
                                    id="deleteModal-<?= $user->id ?>"
                                    tabindex="-1"
                                    role="dialog"
                                    aria-labelledby="deleteModalLabel-<?= $user->id ?>"
                                    aria-hidden="true"
                                >
                                    <div
                                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                        role="document"
                                    >
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5
                                                    class="modal-title"
                                                    id="deleteModalLabel-<?= $user->id ?>"
                                                >
                                                    <?= __('Confirmar Exclusão') ?>
                                                </h5>
                                                <button
                                                    type="button"
                                                    class="close"
                                                    data-dismiss="modal"
                                                    aria-label="Close"
                                                >
                                                    <span aria-hidden="true"
                                                        >&times;</span
                                                    >
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    <?= __('Você tem certeza que deseja excluir # {0}?', $user->name)
                                                    ?>
                                                </p>
                                            </div>
                                            <div
                                                class="modal-footer justify-content-between"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn modalCancel"
                                                    data-dismiss="modal"
                                                >
                                                    Cancelar
                                                </button>
                                                <?= $this->Form->postLink(__('Excluir'),
                                                ['action' => 'delete', $user->id], ['class' => 'btn
                                                modalDelete', 'id' =>
                                                'deleteButton-' . $user->id, 'data-id' => $user->id]) ?>
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
                            <?= $this->Paginator->first('<< ' . __('primeira'))
                            ?>
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

<!-- Modal de Detalhes -->
<div
    class="modal fade"
    id="detailsModal-<?= $user->id ?>"
    tabindex="-1"
    role="dialog"
    aria-labelledby="detailsModalLabel-<?= $user->id ?>"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="detailsModalLabel-<?= $user->id ?>"
                >
                    Visualizar
                    <?= h($user->name) ?>
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <ul class="list-group list-group-flush">
                                                                 <li class="list-group-item">
                                    <strong>Id:</strong>
                                    <span
                                        ><?= h($user->id)
                                        ?></span
                                    >
                                </li>
                                                                  <li class="list-group-item">
                                    <strong>Name:</strong>
                                    <span
                                        ><?= h($user->name)
                                        ?></span
                                    >
                                </li>
                                                                  <li class="list-group-item">
                                    <strong>Email:</strong>
                                    <span
                                        ><?= h($user->email)
                                        ?></span
                                    >
                                </li>
                                                                  <li class="list-group-item">
                                    <strong>Last Login:</strong>
                                    <span
                                        ><?= h($user->last_login)
                                        ?></span
                                    >
                                </li>
                                                                       </ul>
                            <hr />
                        </div>
                        <div class="col-12 col-md-6">
                            <ul class="list-group list-group-flush">
                                                                         <li class="list-group-item">
                                    <strong>Login Count:</strong>
                                    <span
                                        ><?= h($user->login_count)
                                        ?></span
                                    >
                                </li>
                                                                  <li class="list-group-item">
                                    <strong>Active:</strong>
                                    <span
                                        ><?= h($user->active)
                                        ?></span
                                    >
                                </li>
                                                                  <li class="list-group-item">
                                    <strong>Role Id:</strong>
                                    <span
                                        ><?= h($user->role_id)
                                        ?></span
                                    >
                                </li>
                                                                  <li class="list-group-item">
                                    <strong>Created:</strong>
                                    <span
                                        ><?= h($user->created)
                                        ?></span
                                    >
                                </li>
                                                                  <li class="list-group-item">
                                    <strong>Modified:</strong>
                                    <span
                                        ><?= h($user->modified)
                                        ?></span
                                    >
                                </li>
                                                             </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn modalView"
                    id="viewButton"
                    data-dismiss="modal"
                >
                    Fechar
                </button>
                <a
                    href="<?= $this->Url->build(['action' => 'view', $user->id]) ?>"
                    class="btn modalView"
                >
                    Ver Detalhes
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function searchTableBody(query) {
        $.ajax({
            url: '<?= $this->Url->build(['action' => 'index']) ?>',
            method: 'GET',
            data: {
                search: query
            },
            success: function(response) {
                var tableBody = $(response).find('#TableBody').html();
                if (tableBody.trim() === '') {
                    $('#TableBody').html('<tr><td colspan="9">Não foi possível encontrar resultados para "' + query + '"</td></tr>');
                } else {
                    $('#TableBody').html(tableBody);
                }
            },
            error: function() {
                console.log('Erro ao realizar a pesquisa.');
            }
        });
    }

    (function() {
        Object.freeze(searchTableBody);
    })();
</script>
