<div
    class="modal fade"
    id="addNewItemModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="addNewItemModalLabel"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewItemModalLabel">
                    <?= __('Adicionar') ?>
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create(null, ['url' => ['action' => 'add']]) ?>
                <div class="row">
                                         <div class="col-lg-6 col-s12">
                        <div class="form-group">
                            <?= $this->Form->control('name', ['class' =>
                            'form-control']) ?>
                        </div>
                    </div>                     <div class="col-lg-6 col-s12">
                        <div class="form-group">
                            <?= $this->Form->control('sexo', ['class' =>
                            'form-control']) ?>
                        </div>
                    </div>                     <div class="col-lg-6 col-s12">
                        <div class="form-group">
                            <?= $this->Form->control('date', ['class' =>
                            'form-control']) ?>
                        </div>
                    </div>                     <div class="col-lg-6 col-s12">
                        <div class="form-group">
                            <?= $this->Form->control('color', ['class' =>
                            'form-control']) ?>
                        </div>
                    </div>                     <div class="col-lg-6 col-s12">
                        <div class="form-group">
                            <?= $this->Form->control('active', ['class' =>
                            'form-control']) ?>
                        </div>
                    </div>                     <div class="col-lg-6 col-s12">
                        <div class="form-group">
                            <?= $this->Form->control('user_id', ['options'
                            => $users, 'class' =>
                            'form-control']) ?>
                        </div>
                    </div>                   </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button
                    type="button"
                    class="btn modalCancel"
                    id="cancelButton"
                    data-dismiss="modal"
                >
                    Cancelar
                </button>
                <?= $this->Form->button(__('Salvar'), ['class' => 'btn
                modalAdd', 'id' => 'saveButton', 'escape' => false]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
