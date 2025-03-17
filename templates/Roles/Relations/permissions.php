<?php if (!empty($role->permissions)) : ?>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6 order-2 order-md-1 mt-4">
                                <h3 class="card-title">
                                    <?= __('Permissões relacionadas') ?>
                                </h3>
                            </div>
                            <div
                                class="col-12 col-md-6 text-md-right order-1 order-md-2">
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
                <?php if (!empty($role->permissions)) : ?>
                    <div class="card-body table-responsive p-0" style="max-height: 400px; overflow-y: auto">
                        <div class="col-12 col-md-6 mb-2 mb-md-2 mt-2">
                            <form class="form-inline w-100" method="get" action="<?= $this->Url->build() ?>">
                                <div class="input-group">
                                    <input id="PermissionsSearchInput" class="form-control col-12" type="search" placeholder="Pesquisar..." aria-label="Pesquisar" name="search" value="<?= $this->request->getQuery('search') ?>" />
                                </div>
                            </form>
                        </div>
                        <table id="PermissionsTable" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Nome') ?></th>
                                    <th><?= __('Grupo') ?></th>
                                    <th><?= __('Descrição') ?></th>
                                    <th><?= __('Criado') ?></th>
                                    <th><?= __('Modificado') ?></th>
                                </tr>
                            </thead>
                            <tbody id="PermissionsTableBody">
                                <?php foreach ($role->permissions as $permissions) : ?>
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
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div id="PermissionsNoResultsMessage" style="display: none; text-align: center; padding: 10px">
                            <?= __('Nenhum resultado encontrado.') ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>