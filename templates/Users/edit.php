<div class="modal fade" id="editModal-<?= $user->id ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-<?= $user->id ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel-<?= $user->id ?>">
                    <?= __('Editar') ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create($user, ['url' => ['action' => 'edit', $user->id], 'id' => 'editForm-' . $user->id]) ?>
                <div class="row">
                    <div class="col-lg-6 col-s12">
                        <div class="form-group">
                            <?= $this->Form->control(
                                'name',
                                [
                                    'label' => __('Nome'),
                                    'class' => 'form-control'
                                ]
                            )
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-s12">
                        <div class="form-group">
                            <?= $this->Form->control(
                                'email',
                                [
                                    'label' => __('Email'),
                                    'class' => 'form-control'
                                ]
                            )
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-s12">
                        <div class="form-group">
                            <?= $this->Form->control(
                                'role_id',
                                [
                                    'label' => __('Perfil'),
                                    'options' => $roles,
                                    'class' => 'form-control'
                                ]
                            )
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-s12">
                    <div class="form-group">
                        <?= $this->Form->control(
                            'active',
                            [
                                'type' => 'checkbox',
                                'label' => __('Ativo'),
                                'class' => 'form-check-input'
                            ]
                        )
                        ?>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn modalCancel" id="cancelButton" data-dismiss="modal">Cancelar</button>
                    <?= $this->Form->button(
                        __('Editar'),
                        [
                            'class' => 'btn modalEdit',
                            'id' => 'editSaveButton' . $user->id,
                        ]
                    )
                    ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>