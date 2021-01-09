<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">

    <?php if(isset($tipo) && $tipo == "erro"): ?>

        <div class="mb-3" role="alert">
            <?php echo $mensagem; ?>
        </div>

        <?php elseif(isset($tipo) && $tipo == "sucesso"): ?>

        <div class="mb-3" role="alert">
            <?php echo $mensagem; ?>
        </div>

    <?php endif; ?>

    <div class="row">
        <div class="col-md-12 mt-5">
            <h3>Abrir Balanço</h3>
            <div class="separador"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-5">
            <form action="<?php echo site_url("gestor/abertura_balanco"); ?>" method="post" id="frm_criar_atalho">

            <div class="row">
                <div class="col-md-3 mb-4">

                    <span>Data de Abertura</span>
                    <input type="date" class="form-control" style="width: 190px;" name="data_abertura" value="<?php date_default_timezone_set('Europe/London'); echo date('Y-m-d'); ?>">

                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <input type="submit" value="Abrir Balanço" class="botao_green" />
                </div>
            </div>

            </form>
        </div>
    </div>

</div>