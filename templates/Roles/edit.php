<div class="modal fade" id="editModal-<?= $role->id ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-<?= $role->id ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel-<?= $role->id ?>"><?= __('Editar') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create($role, ['url' => ['action' => 'edit', $role->id], 'id' => 'editForm-' . $role->id]) ?>
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
                                    <?= $this->Form->checkbox('select_all', ['id' => 'select-all-edit-' . $role->id]) ?> Todos
                                </label>
                            </div>
                            <div class="row">
                                <?php foreach ($permissions as $group => $groupPermissions): ?>
                                    <div class="col-lg-4 col-12 mb-3">
                                        <div class="border p-2">
                                            <strong><?= h($group) ?></strong>
                                            <div class="mb-2">
                                                <label>
                                                    <?= $this->Form->checkbox('select_group', ['class' => 'select-group-edit', 'data-group' => $group, 'data-role-id' => $role->id]) ?> Todos
                                                </label>
                                            </div>
                                            <?php foreach ($groupPermissions as $permission): ?>
                                                <?php $isChecked = in_array($permission->id, array_column($role->roles_permissions, 'permission_id')) ? 'checked' : ''; ?>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <?= $this->Form->checkbox('permissions[]', ['value' => $permission->id, 'class' => 'form-check-input permission-checkbox-edit', 'data-group' => $group, 'data-role-id' => $role->id, 'checked' => $isChecked]) ?> <?= h($permission->description) ?>
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
                <?= $this->Form->button(__('Editar'), ['class' => 'btn modalAdd', 'id' => 'editSaveButton' . $role->id, 'escape' => false]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
    $('#select-all-edit-<?= $role->id ?>').on('change', function() {
        $('.permission-checkbox-edit[data-role-id="<?= $role->id ?>"]').prop('checked', this.checked);
    });

    $('.select-group-edit[data-role-id="<?= $role->id ?>"]').on('change', function() {
        var group = $(this).data('group');
        $('.permission-checkbox-edit[data-group="' + group + '"][data-role-id="<?= $role->id ?>"]').prop('checked', this.checked);
    });
</script>