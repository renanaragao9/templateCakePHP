<div class="modal fade" id="detailsModal-<?= $role->id ?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel-<?= $role->id ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel-<?= $role->id ?>"><?= h($role->name) ?> Detalhes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Id:</strong> <span><?= h($role->id) ?></span></li>
                        <li class="list-group-item"><strong>Name:</strong> <span><?= h($role->name) ?></span></li>
                        <li class="list-group-item"><strong>Description:</strong> <span><?= h($role->description) ?></span></li>
                        <li class="list-group-item"><strong>Created:</strong> <span><?= h($role->created) ?></span></li>
                        <li class="list-group-item"><strong>Modified:</strong> <span><?= h($role->modified) ?></span></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn modalView" id="viewButton" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>