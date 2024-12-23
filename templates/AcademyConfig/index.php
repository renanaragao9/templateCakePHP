<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=$this->Url->build(['controller' => 'Dashboard', 'action' => 'index'])?>" style="font-size: 1.25rem;">Início</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?=__('Configuração da Academia')?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-s12">
                <h1 class="page-title m-0 text-dark"><?=__('Configuração da Academia')?></h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <form class="form-inline w-100" method="get" action="<?=$this->Url->build()?>">
                                <div class="input-group w-100">
                                    <input id="searchInput" class="form-control col-12" type="search" placeholder="Pesquisar..." aria-label="Pesquisar" name="search" value="<?=$this->request->getQuery('search')?>">
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-md-6 text-md-right">
                            <button type="button" class="btn btn-add btn-sm mb-0 col-12 col-md-auto" data-toggle="modal" data-target="#addNewItemModal">
                                <i class="fas fa-plus-circle"></i> <strong>Adicionar Novo Item</strong>
                            </button>
                            <button type="button" class="btn btn-add btn-filter btn-sm mb-0 col-12 col-md-auto" data-toggle="modal" data-target="#filterModal">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th><?=$this->Paginator->sort('id')?></th>
                                    <th><?=$this->Paginator->sort('name', 'Nome')?></th>
                                    <th><?=$this->Paginator->sort('logo', 'Logo')?></th>
                                    <th><?=$this->Paginator->sort('motto', 'Lema')?></th>
                                    <th><?=$this->Paginator->sort('primary_color', 'Cor Primária')?></th>
                                    <th><?=$this->Paginator->sort('secondary_color', 'Cor Secundária')?></th>
                                    <th><?=$this->Paginator->sort('created', 'Criado')?></th>
                                    <th><?=$this->Paginator->sort('modified', 'Modificado')?></th>
                                    <th class="actions"><?=__('Ações')?></th>
                                </tr>
                            </thead>
                            <tbody id="academyConfigTableBody">
                                <?php if (!empty($academyConfig)): ?>
                                    <?php foreach ($academyConfig as $config): ?>
                                        <tr>
                                            <td><?=$this->Number->format($config->id)?></td>
                                            <td><?=h($config->name)?></td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#logoModal-<?=$config->id?>">
                                                    <?=$this->Html->image('logo/' . h($config->logo), ['alt' => h($config->name) . ' logo', 'class' => 'rounded-circle', 'style' => 'width: 50px; height: 50px;'])?>
                                                </a>
                                            </td>
                                            <td><?=h($config->motto)?></td>
                                            <td><?=h($config->primary_color)?></td>
                                            <td><?=h($config->secondary_color)?></td>
                                            <td><?=h($config->created)?></td>
                                            <td><?=h($config->modified)?></td>
                                            <td class="actions">
                                                <a href="#" class="btn btn-view btn-sm" data-toggle="modal" data-target="#detailsModal-<?=$config->id?>"><i class="fas fa-eye"></i></a>
                                                <a href="#" class="btn btn-edit btn-sm" data-toggle="modal" data-target="#editModal-<?=$config->id?>"><i class="fas fa-edit"></i></a>
                                                <a href="#" class="btn btn-delete btn-sm" data-toggle="modal" data-target="#deleteModal-<?=$config->id?>"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>

                                        <!-- Logo Modal -->
                                        <div class="modal fade" id="logoModal-<?=$config->id?>" tabindex="-1" role="dialog" aria-labelledby="logoModalLabel-<?=$config->id?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="logoModalLabel-<?=$config->id?>"><?=h($config->name)?> Logo</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <?=$this->Html->image('logo/' . h($config->logo), ['alt' => h($config->name) . ' logo', 'class' => 'img-fluid'])?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Incluir os modais de edição, visualização e exclusão -->
                                        <?php
include __DIR__ . '/edit.php';
include __DIR__ . '/view.php';
?>

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
                                    <?php endforeach;?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9"><?=__('Nenhuma configuração encontrada.')?></td>
                                    </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <?=$this->Paginator->first('<< ' . __('primeira'))?>
                            <?=$this->Paginator->prev('< ' . __('anterior'))?>
                            <?=$this->Paginator->next(__('próxima') . ' >')?>
                            <?=$this->Paginator->last(__('última') . ' >>')?>
                        </ul>
                        <p><?=$this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}} no total'))?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Filtragem e Geração de PDF -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Gerar Relatório PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="pdfForm" method="get" action="<?=$this->Url->build(['action' => 'gerarPdf'])?>">
                    <div id="conditions-container">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="field">Campo</label>
                                <select class="form-control" name="fields[]" id="field" onchange="updateInputType(this)">
                                    <?php foreach ($fields as $field => $label): ?>
                                        <option value="<?=$field?>" data-type="<?=in_array($field, $fields)?>"><?=$label?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="condition">Condição</label>
                                <select class="form-control" name="conditions[]" id="condition" onchange="toggleBetweenInput(this)">
                                    <?php foreach ($conditions as $condition => $label): ?>
                                        <option value="<?=$condition?>"><?=$label?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="value">Valor</label>
                                <input type="text" class="form-control" name="values[]" id="value" placeholder="Valor">
                            </div>
                            <div class="col-md-3" style="display: none;" id="value2-container">
                                <label for="value2">Valor 2</label>
                                <input type="text" class="form-control" name="values2[]" id="value2" placeholder="Valor 2">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm mt-4" onclick="removeCondition(this)">Excluir</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-condition">Adicionar Condição</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" form="pdfForm">Gerar PDF</button>
            </div>
        </div>
    </div>
</div>

<script>
    function searchAcademyConfig(query) {
        $.ajax({
            url: '<?=$this->Url->build(['controller' => 'AcademyConfig', 'action' => 'index'])?>',
            method: 'GET',
            data: {
                search: query
            },
            success: function(response) {
                var tableBody = $(response).find('#academyConfigTableBody').html();
                if (tableBody.trim() === '') {
                    $('#academyConfigTableBody').html('<tr><td colspan="9">Não foi possível encontrar resultados para "' + query + '".</td></tr>');
                } else {
                    $('#academyConfigTableBody').html(tableBody);
                }
            },
            error: function() {
                alert('Erro ao realizar a pesquisa.');
            }
        });
    }
</script>

<?php include __DIR__ . '/add.php';?>