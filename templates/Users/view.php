<?php

use App\Utility\AccessChecker;

$loggedUserId = $this->request->getSession()->read('Auth.User.id');
$this->assign('title', 'Titulo'); ?>     
<section class="content mt-3">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header" style="margin: 0 auto">
                <h3 class="card-title">Dados Detalhados</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <a
                        href="<?= $this->Url->build(['action' => 'index']) ?>"
                        class="btn btn-secondary btn-sm button-detail"
                    >
                        <?= __('Voltar') ?>
                    </a>
                </div>
                                  <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label"
                    >
                        <?= __('Name'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label"
                    >
                        <?= h($user->name) ?>
                    </div>
                </div>
                                  <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label"
                    >
                        <?= __('Email'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label"
                    >
                        <?= h($user->email) ?>
                    </div>
                </div>
                                   <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label"
                    >
                        <?= __('Role'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label"
                    >
                        <?= $user->has('role') ?
                        $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?>
                    </div>
                </div>
                                     <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label"
                    >
                        <?= __('Id'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label"
                    >
                                                 <?= $this->Number->format($user->id) ?>                     </div>
                </div>
                                <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label"
                    >
                        <?= __('Login Count'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label"
                    >
                                                 <?= $this->Number->format($user->login_count) ?>                     </div>
                </div>
                                   <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label"
                    >
                        <?= __('Last Login'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label"
                    >
                        <?= h($user->last_login) ?>
                    </div>
                </div>
                                <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label"
                    >
                        <?= __('Created'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label"
                    >
                        <?= h($user->created) ?>
                    </div>
                </div>
                                <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label"
                    >
                        <?= __('Modified'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label"
                    >
                        <?= h($user->modified) ?>
                    </div>
                </div>
                                   <div class="row item-row">
                    <label
                        class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label"
                    >
                        <?= __('Active'); ?>
                    </label>
                    <div
                        class="col-sm-9 col-md-9 col-lg-9 col-xl-9 control-label"
                    >
                        <?= $user->active ? __('Sim') :
                        __('Não'); ?>
                    </div>
                </div>
                             </div>
        </div>
    </div>
</section>
       
<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header" style="margin: 0 auto">
                <h3 class="card-title">
                    <?= __('Relacionado Collaborators') ?>
                </h3>
            </div>
            <?php if (!empty($user->collaborators)) : ?>
            <div
                class="card-body table-responsive p-0"
                style="max-height: 400px; overflow-y: auto"
            >
                <div class="col-12 col-md-6 mb-2 mb-md-2 mt-2">
                    <form
                        class="form-inline w-50"
                        method="get"
                        action="<?= $this->Url->build() ?>"
                    >
                        <div class="input-group w-100">
                            <input
                                id="CollaboratorsSearchInput"
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
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                                                        <th><?= __('Id') ?></th>
                                                        <th><?= __('Name') ?></th>
                                                        <th><?= __('Sexo') ?></th>
                                                        <th><?= __('Date') ?></th>
                                                        <th><?= __('Color') ?></th>
                                                        <th><?= __('Active') ?></th>
                                                        <th><?= __('User Id') ?></th>
                                                        <th><?= __('Created') ?></th>
                                                        <th><?= __('Modified') ?></th>
                                                        <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody id="CollaboratorsTableBody">
                        <?php foreach ($user->collaborators
                        as $collaborators) : ?>
                        <tr>
                                                        <td>
                                <?= h($collaborators->id) ?>
                            </td>
                                                        <td>
                                <?= h($collaborators->name) ?>
                            </td>
                                                        <td>
                                <?= h($collaborators->sexo) ?>
                            </td>
                                                        <td>
                                <?= h($collaborators->date) ?>
                            </td>
                                                        <td>
                                <?= h($collaborators->color) ?>
                            </td>
                                                        <td>
                                <?= h($collaborators->active) ?>
                            </td>
                                                        <td>
                                <?= h($collaborators->user_id) ?>
                            </td>
                                                        <td>
                                <?= h($collaborators->created) ?>
                            </td>
                                                        <td>
                                <?= h($collaborators->modified) ?>
                            </td>
                                                         <td class="actions">
                                <?= $this->Html->link('<i class="fas fa-eye"></i
                                >', ['controller' => 'Collaborators', 'action' => 'view', $user->id], [ 'class' => 'btn btn-view btn-sm',
                                'escape' => false ]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div
                    id="CollaboratorsNoResultsMessage"
                    style="display: none; text-align: center; padding: 10px"
                >
                    <?= __('Nenhum resultado encontrado.') ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <script>
        document
            .getElementById("CollaboratorsSearchInput")
            .addEventListener("keyup", function () {
                var input, filter, table, tr, td, i, j, txtValue, found;
                input = document.getElementById("CollaboratorsSearchInput");
                filter = input.value.toUpperCase();
                table = document.querySelector("table");
                tr = table.getElementsByTagName("tr");
                found = false;

                for (i = 1; i < tr.length; i++) {
                    tr[i].style.display = "none";
                    td = tr[i].getElementsByTagName("td");
                    for (j = 0; j < td.length; j++) {
                        if (td[j]) {
                            txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                                found = true;
                                break;
                            }
                        }
                    }
                }

                document.getElementById(
                    "CollaboratorsNoResultsMessage"
                ).style.display = found ? "none" : "block";
            });
    </script>
</section>
