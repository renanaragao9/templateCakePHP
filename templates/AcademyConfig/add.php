<div class="modal fade" id="addNewItemModal" tabindex="-1" role="dialog" aria-labelledby="addNewItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewItemModalLabel"><?=__('Adicionar Novo Item')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?=$this->Form->create(null, ['url' => ['action' => 'add'], 'type' => 'file'])?>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="name">Nome <span class="text-danger" title="Campo obrigatório">*</span></label>
                            <?=$this->Form->control('name', ['label' => false, 'class' => 'form-control', 'required' => true])?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="logo_file">Logotipo <span class="text-danger" title="Campo obrigatório">*</span></label>
                            <?=$this->Form->control('logo_file', ['type' => 'file', 'label' => false, 'class' => 'form-control', 'required' => true])?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="motto">Lema <span class="text-danger" title="Campo obrigatório">*</span></label>
                            <?=$this->Form->control('motto', ['label' => false, 'class' => 'form-control', 'required' => true])?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="primary_color">Cor Primária <span class="text-danger" title="Campo obrigatório">*</span></label>
                            <?=$this->Form->control('primary_color', ['label' => false, 'class' => 'form-control', 'required' => true])?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="secondary_color">Cor Secundária <span class="text-danger" title="Campo obrigatório">*</span></label>
                            <?=$this->Form->control('secondary_color', ['label' => false, 'class' => 'form-control', 'required' => true])?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="user_id">Usuário</label>
                            <?=$this->Form->control('user_id', ['type' => 'hidden', 'value' => $this->request->getSession()->read('Auth.User.id')])?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <?=$this->Form->button(__('Salvar'), ['class' => 'btn btn-primary', 'id' => 'saveButton', 'style' => 'background-color: #013750; border-color: #013750;', 'escape' => false])?>
                </div>
                <?=$this->Form->end()?>
            </div>
        </div>
    </div>
</div>