<?php
$breadcrumbLabel = 'Dashboard'; // Define a label específica para a página de dashboard
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-1">
            <div class="col-12">
                <?=$this->Breadcrumbs->render(['class' => 'float-sm-right', 'label' => $breadcrumbLabel])?>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>150</h3>
                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>