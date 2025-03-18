<?php if (!empty($role->users)) : ?>
    <section class="content" id="footer-card-view">
        <div class="container-fluid">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6 order-2 order-md-1 mt-4">
                                <h3 class="card-title">
                                    <?= __('Usuários relacionados') ?>
                                </h3>
                            </div>
                            <div class="col-12 col-md-6 text-md-right order-1 order-md-2">
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" id="icon-dropdown" data-card-widget="collapse">
                                        <i class="fas fa-minus" data-collapsed-icon="fa-plus" data-expanded-icon="fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr />
                    </div>
                </div>
                <?php if (!empty($role->users)) : ?>
                    <div class="card-body table-responsive p-0" style="max-height: 400px; overflow-y: auto">
                        <div class="col-12 col-md-6 mb-2 mb-md-2 mt-2">
                            <form class="form-inline w-100" method="get" action="<?= $this->Url->build() ?>">
                                <div class="input-group">
                                    <input id="UsersSearchInput" class="form-control col-12" type="search" placeholder="Pesquisar..." aria-label="Pesquisar" name="search" value="<?= $this->request->getQuery('search') ?>" />
                                </div>
                            </form>
                        </div>
                        <table id="UsersTable" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Nome') ?></th>
                                    <th><?= __('Email') ?></th>
                                    <th><?= __('Último login') ?></th>
                                    <th><?= __('Ativo') ?></th>
                                    <th class="actions"><?= __('Ações') ?></th>
                                </tr>
                            </thead>
                            <tbody id="UsersTableBody">
                                <?php foreach ($role->users as $user) : ?>
                                    <tr>
                                        <td>
                                            <?= h($user->id) ?>
                                        </td>
                                        <td>
                                            <?= h($user->name) ?>
                                        </td>
                                        <td>
                                            <?= h($user->email) ?>
                                        </td>
                                        <td>
                                            <?= h($user->last_login) ?: '-' ?>
                                        </td>
                                        <td>
                                            <?= h($user->active) ? 'Sim' : 'Não' ?>
                                        </td>
                                        <td class="actions">
                                            <?= $this->Html->link(
                                                '<i class="fas fa-eye"></i>',
                                                [
                                                    'controller' => 'Users',
                                                    'action' => 'view',
                                                    $role->id
                                                ],
                                                [
                                                    'class' => 'btn btn-view btn-sm',
                                                    'escape' => false
                                                ]
                                            ) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div id="UsersNoResultsMessage" style="display: none; text-align: center; padding: 10px">
                            <?= __('Nenhum resultado encontrado.') ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>