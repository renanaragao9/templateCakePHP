<div class="modal fade" id="detailsModal-<?= $user->id ?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel-<?= $user->id ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel-<?= $user->id ?>"><?= h($user->name) ?> Detalhes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Id:</strong> <span><?= h($user->id) ?></span></li>
                        <li class="list-group-item"><strong>Nome:</strong> <span><?= h($user->name) ?></span></li>
                        <li class="list-group-item"><strong>Email:</strong> <span><?= h($user->email) ?></span></li>
                        <li class="list-group-item"><strong>Perfil:</strong> <span><?= $user->role_id ? h($user->role->name) : 'N/A' ?></span></li>
                        <li class="list-group-item"><strong>Último Login:</strong> <span><?= $user->last_login ? h($user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss')) : 'N/A' ?></span></li>
                        <li class="list-group-item"><strong>Contagem de Logins:</strong> <span><?= h($user->login_count) ?></span></li>
                        <li class="list-group-item"><strong>Ativo:</strong> <span><?= h($user->active ? 'Sim' : 'Não') ?></span></li>
                        <li class="list-group-item"><strong>Criado:</strong> <span><?= h($user->created->i18nFormat('dd/MM/yyyy HH:mm:ss')) ?></span></li>
                        <li class="list-group-item"><strong>Modificado:</strong> <span><?= h($user->modified->i18nFormat('dd/MM/yyyy HH:mm:ss')) ?></span></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn modalView" id="viewButton" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>