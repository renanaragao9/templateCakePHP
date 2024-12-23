<div class="modal fade" id="detailsModal-<?=$config->id?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel-<?=$config->id?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel-<?=$config->id?>"><?=h($config->name)?> Detalhes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>ID:</strong> <span><?=$this->Number->format($config->id)?></span></li>
                        <li class="list-group-item"><strong>Nome:</strong> <span><?=h($config->name)?></span></li>
                        <li class="list-group-item"><strong>Lema:</strong> <span><?=h($config->motto)?></span></li>
                        <li class="list-group-item"><strong>Cor Primária:</strong> <span style="color: <?=$config->primary_color?>;"><?=h($config->primary_color)?></span></li>
                        <li class="list-group-item"><strong>Cor Secundária:</strong> <span style="color: <?=$config->secondary_color?>;"><?=h($config->secondary_color)?></span></li>
                        <li class="list-group-item"><strong>Criado:</strong> <span><?=h($config->created)?></span></li>
                        <li class="list-group-item"><strong>Modificado:</strong> <span><?=h($config->modified)?></span></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>