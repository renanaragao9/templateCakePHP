<div class="modal fade" id="deleteModal-<?= $user->id ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-<?= $user->id ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel-<?= $user->id ?>">
                    <?= __('Confirmar Exclusão') ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <?= __('Você tem certeza que deseja excluir {0}?', $user->name) ?>
                </p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn modalCancel" data-dismiss="modal">
                    Cancelar
                </button>
                <?= $this->Form->postLink(
                    __('Excluir'),
                    [
                        'action' => 'delete',
                        $user->id
                    ],
                    [
                        'class' => 'btn modalDelete',
                        'id' => 'deleteButton-' . $user->id,
                        'data-id' => $user->id
                    ]
                )
                ?>
            </div>
        </div>
    </div>
</div>