<div class="modal fade" id="deleteModal-<?=$config->id?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-<?=$config->id?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel-<?=$config->id?>"><?=__('Confirmar Exclusão')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?=__('Você tem certeza que deseja excluir # {0}?', $config->name)?></p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <?=$this->Form->postLink(__('Excluir'), ['action' => 'delete', $config->id], ['class' => 'btn btn-danger', 'id' => 'deleteButton-' . $config->id, 'data-id' => $config->id])?>
            </div>
        </div>
    </div>
</div>