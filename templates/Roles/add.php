<div class="modal fade" id="addNewItemModal" tabindex="-1" role="dialog" aria-labelledby="addNewItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewItemModalLabel"><?= __('Adicionar') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create(null, ['url' => ['action' => 'add']]) ?>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <?= $this->Form->control('description', ['class' => 'form-control', 'label' => 'Descrição']) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Permissões</label>
                            <div class="mb-2">
                                <label>
                                    <?= $this->Form->checkbox('select_all', ['id' => 'select-all']) ?> Todos
                                </label>
                            </div>
                            <div class="row">
                                <?php foreach ($permissions as $group => $groupPermissions): ?>
                                    <div class="col-lg-4 col-12 mb-3">
                                        <div class="border p-2">
                                            <strong><?= h($group) ?></strong>
                                            <div class="mb-2">
                                                <label>
                                                    <?= $this->Form->checkbox('select_group', ['class' => 'select-group', 'data-group' => $group]) ?> Todos
                                                </label>
                                            </div>
                                            <?php foreach ($groupPermissions as $permission): ?>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <?= $this->Form->checkbox('permissions[]', ['value' => $permission->id, 'class' => 'form-check-input permission-checkbox', 'data-group' => $group]) ?> <?= h($permission->description) ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn modalCancel" id="cancelButton" data-dismiss="modal">Cancelar</button>
                <?= $this->Form->button(__('Salvar'), ['class' => 'btn modalAdd', 'id' => 'saveButton', 'escape' => false]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php $this->Html->script('Roles/add.js', ['block' => true]); ?>