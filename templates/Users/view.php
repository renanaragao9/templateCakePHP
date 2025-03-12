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
                        <li class="list-group-item"><strong>Name:</strong> <span><?= h($user->name) ?></span></li>
                        <li class="list-group-item"><strong>Email:</strong> <span><?= h($user->email) ?></span></li>
                        <li class="list-group-item"><strong>Last Login:</strong> <span><?= h($user->last_login) ?></span></li>
                        <li class="list-group-item"><strong>Login Count:</strong> <span><?= h($user->login_count) ?></span></li>
                        <li class="list-group-item"><strong>Active:</strong> <span><?= h($user->active) ?></span></li>
                        <li class="list-group-item"><strong>Role Id:</strong> <span><?= h($user->role_id) ?></span></li>
                        <li class="list-group-item"><strong>Created:</strong> <span><?= h($user->created) ?></span></li>
                        <li class="list-group-item"><strong>Modified:</strong> <span><?= h($user->modified) ?></span></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn modalView" id="viewButton" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>