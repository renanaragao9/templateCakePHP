<div class="modal fade" id="detailsModal-<?= $user->id ?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel-<?= $user->id ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel-<?= $user->id ?>">
                    Visualizar
                    <?= h($user->name) ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                    <span> <?= h($user->id) ?> </span>
                                </li>

                                <li class="list-group-item">
                                    <strong>Nome:</strong>
                                    <span> <?= h($user->name) ?> </span>
                                </li>

                                <li class="list-group-item">
                                    <strong>Email:</strong>
                                    <span> <?= h($user->email) ?> </span>
                                </li>

                                <li class="list-group-item">
                                    <strong>Último login:</strong>
                                    <span> <?= h($user->last_login) ? h($user->last_login) : '-' ?> </span>
                                </li>

                                <li class="list-group-item">
                                    <strong>Contagem de logins:</strong>
                                    <span><?= h($user->login_count) ?> </span>
                                </li>
                            </ul>
                            <hr />
                        </div>
                        <div class="col-12 col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Ativo:</strong>
                                    <span><?= h($user->active) ? 'Sim' : 'Não' ?> </span>
                                </li>

                                <li class="list-group-item">
                                    <strong>Perfil:</strong>
                                    <span><?= h($user->role ? h($user->role->name) : '-') ?> </span>
                                </li>

                                <li class="list-group-item">
                                    <strong>Criado:</strong>
                                    <span><?= h($user->created) ?> </span>
                                </li>

                                <li class="list-group-item">
                                    <strong>Modificado:</strong>
                                    <span><?= h($user->modified) ?> </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn modalView" id="viewButton" data-dismiss="modal">
                    Fechar
                </button>
                <a href="<?= $this->Url->build(['action' => 'view', $user->id]) ?>" class="btn modalView">
                    Ver Detalhes
                </a>
            </div>
        </div>
    </div>
</div>