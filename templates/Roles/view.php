<?php

use App\Utility\AccessChecker;

$loggedUserId = $this->request->getSession()->read('Auth.User.id');
$this->assign('title', 'Titulo'); ?>
<section class="content mt-4">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 order-2 order-md-1 mt-4">
                            <h3 class="card-title">
                                <?= __('Visualizar role') ?>
                            </h3>
                        </div>
                        <div
                            class="col-12 col-md-6 text-md-right order-1 order-md-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-md-end">
                                    <li class="breadcrumb-item">
                                        <a
                                            href="<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>"><i class="fa-regular fa-house"></i>
                                            Início</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a
                                            href="<?= $this->Url->build(['action' => 'index']) ?>">role</a>
                                    </li>
                                    <li
                                        class="breadcrumb-item active"
                                        aria-current="page">
                                        <?= __('Visualizar') ?>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <hr />
                </div>
            </div>
            <div class="card-body">
                <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label">
                        <?= __('Name'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label">
                        <?= h($role->name) ?>
                    </div>
                </div>
                <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label">
                        <?= __('Description'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label">
                        <?= h($role->description) ?>
                    </div>
                </div>
                <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label">
                        <?= __('Id'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label">
                        <?= $this->Number->format($role->id) ?> </div>
                </div>
                <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label">
                        <?= __('Created'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label">
                        <?= h($role->created) ?>
                    </div>
                </div>
                <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label">
                        <?= __('Modified'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label">
                        <?= h($role->modified) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($role->permissions)) : ?>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6 order-2 order-md-1 mt-4">
                                <h3 class="card-title">
                                    <?= __('Relacionado Permissions') ?>
                                </h3>
                            </div>
                            <div
                                class="col-12 col-md-6 text-md-right order-1 order-md-2">
                                <div class="card-tools">
                                    <button
                                        type="button"
                                        class="btn btn-tool"
                                        id="icon-dropdown"
                                        data-card-widget="collapse">
                                        <i
                                            class="fas fa-minus"
                                            data-collapsed-icon="fa-plus"
                                            data-expanded-icon="fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr />
                    </div>
                </div>
                <?php if (!empty($role->permissions)) : ?>
                    <div
                        class="card-body table-responsive p-0"
                        style="max-height: 400px; overflow-y: auto">
                        <div class="col-12 col-md-6 mb-2 mb-md-2 mt-2">
                            <form
                                class="form-inline w-100"
                                method="get"
                                action="<?= $this->Url->build() ?>">
                                <div class="input-group">
                                    <input
                                        id="PermissionsSearchInput"
                                        class="form-control col-12"
                                        type="search"
                                        placeholder="Pesquisar..."
                                        aria-label="Pesquisar"
                                        name="search"
                                        value="<?= $this->request->getQuery('search') ?>" />
                                </div>
                            </form>
                        </div>
                        <table
                            id="PermissionsTable"
                            class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Name') ?></th>
                                    <th><?= __('Group') ?></th>
                                    <th><?= __('Description') ?></th>
                                    <th><?= __('Created') ?></th>
                                    <th><?= __('Modified') ?></th>
                                    <th class="actions"><?= __('Ações') ?></th>
                                </tr>
                            </thead>
                            <tbody id="PermissionsTableBody">
                                <?php foreach (
                                    $role->permissions
                                    as $permissions
                                ) : ?>
                                    <tr>
                                        <td>
                                            <?= h($permissions->id) ?>
                                        </td>
                                        <td>
                                            <?= h($permissions->name) ?>
                                        </td>
                                        <td>
                                            <?= h($permissions->group) ?>
                                        </td>
                                        <td>
                                            <?= h($permissions->description) ?>
                                        </td>
                                        <td>
                                            <?= h($permissions->created) ?>
                                        </td>
                                        <td>
                                            <?= h($permissions->modified) ?>
                                        </td>
                                        <td class="actions">
                                            <?= $this->Html->link('<i class="fas fa-eye"></i
                                >', ['controller' => 'Permissions', 'action' => 'view', $role->id], [
                                                'class' => 'btn btn-view btn-sm',
                                                'escape' => false
                                            ]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div
                            id="PermissionsNoResultsMessage"
                            style="display: none; text-align: center; padding: 10px">
                            <?= __('Nenhum resultado encontrado.') ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <script>
            $("#PermissionsSearchInput").on("keyup", function() {
                var input, filter, table, tr, td, i, j, txtValue, found;
                input = $("#PermissionsSearchInput");
                filter = input.val().toUpperCase();
                table = $("#PermissionsTable");
                tr = table.find("tr");
                found = false;

                tr.each(function(index) {
                    if (index === 0) return;
                    $(this).hide();
                    td = $(this).find("td");
                    for (j = 0; j < td.length; j++) {
                        txtValue = td.eq(j).text();
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            $(this).show();
                            found = true;
                            break;
                        }
                    }
                });

                $("#PermissionsNoResultsMessage").toggle(!found);
            });
        </script>
    </section>
<?php endif; ?>

<?php if (!empty($role->users)) : ?>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6 order-2 order-md-1 mt-4">
                                <h3 class="card-title">
                                    <?= __('Relacionado Users') ?>
                                </h3>
                            </div>
                            <div
                                class="col-12 col-md-6 text-md-right order-1 order-md-2">
                                <div class="card-tools">
                                    <button
                                        type="button"
                                        class="btn btn-tool"
                                        id="icon-dropdown"
                                        data-card-widget="collapse">
                                        <i
                                            class="fas fa-minus"
                                            data-collapsed-icon="fa-plus"
                                            data-expanded-icon="fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr />
                    </div>
                </div>
                <?php if (!empty($role->users)) : ?>
                    <div
                        class="card-body table-responsive p-0"
                        style="max-height: 400px; overflow-y: auto">
                        <div class="col-12 col-md-6 mb-2 mb-md-2 mt-2">
                            <form
                                class="form-inline w-100"
                                method="get"
                                action="<?= $this->Url->build() ?>">
                                <div class="input-group">
                                    <input
                                        id="UsersSearchInput"
                                        class="form-control col-12"
                                        type="search"
                                        placeholder="Pesquisar..."
                                        aria-label="Pesquisar"
                                        name="search"
                                        value="<?= $this->request->getQuery('search') ?>" />
                                </div>
                            </form>
                        </div>
                        <table
                            id="UsersTable"
                            class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Name') ?></th>
                                    <th><?= __('Email') ?></th>
                                    <th><?= __('Password') ?></th>
                                    <th><?= __('Last Login') ?></th>
                                    <th><?= __('Login Count') ?></th>
                                    <th><?= __('Active') ?></th>
                                    <th><?= __('Role Id') ?></th>
                                    <th><?= __('Created') ?></th>
                                    <th><?= __('Modified') ?></th>
                                    <th class="actions"><?= __('Ações') ?></th>
                                </tr>
                            </thead>
                            <tbody id="UsersTableBody">
                                <?php foreach (
                                    $role->users
                                    as $users
                                ) : ?>
                                    <tr>
                                        <td>
                                            <?= h($users->id) ?>
                                        </td>
                                        <td>
                                            <?= h($users->name) ?>
                                        </td>
                                        <td>
                                            <?= h($users->email) ?>
                                        </td>
                                        <td>
                                            <?= h($users->password) ?>
                                        </td>
                                        <td>
                                            <?= h($users->last_login) ?>
                                        </td>
                                        <td>
                                            <?= h($users->login_count) ?>
                                        </td>
                                        <td>
                                            <?= h($users->active) ?>
                                        </td>
                                        <td>
                                            <?= h($users->role_id) ?>
                                        </td>
                                        <td>
                                            <?= h($users->created) ?>
                                        </td>
                                        <td>
                                            <?= h($users->modified) ?>
                                        </td>
                                        <td class="actions">
                                            <?= $this->Html->link('<i class="fas fa-eye"></i
                                >', ['controller' => 'Users', 'action' => 'view', $role->id], [
                                                'class' => 'btn btn-view btn-sm',
                                                'escape' => false
                                            ]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div
                            id="UsersNoResultsMessage"
                            style="display: none; text-align: center; padding: 10px">
                            <?= __('Nenhum resultado encontrado.') ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <script>
            $("#UsersSearchInput").on("keyup", function() {
                var input, filter, table, tr, td, i, j, txtValue, found;
                input = $("#UsersSearchInput");
                filter = input.val().toUpperCase();
                table = $("#UsersTable");
                tr = table.find("tr");
                found = false;

                tr.each(function(index) {
                    if (index === 0) return;
                    $(this).hide();
                    td = $(this).find("td");
                    for (j = 0; j < td.length; j++) {
                        txtValue = td.eq(j).text();
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            $(this).show();
                            found = true;
                            break;
                        }
                    }
                });

                $("#UsersNoResultsMessage").toggle(!found);
            });
        </script>
    </section>
<?php endif; ?>