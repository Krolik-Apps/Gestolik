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
        <div class="col-md-12 mt-3">
            <h3>Editar Despesa</h3>
            <div class="separador"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-5">
            <form action="<?php echo site_url('gestor/editar?n='.$despesas[0]['nome']); ?>" method="post" id="frm_criar_atalho">

                <div class="row">
                    <div class="col-md-6">
                        <span>Nome da Despesa</span>
                        <input type="text" name="nome_despesa" value="<?php echo $despesas[0]['nome']; ?>" class="form-control" />
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <a href="<?php echo site_url('gestor/despesas'); ?>"><span class="botao_red mr-3">Voltar</span></a>
                        <input type="submit" value="Editar Despesa" class="botao_green" />
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>