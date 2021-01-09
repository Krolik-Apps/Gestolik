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
        <div class="col-md-12 mt-3" style="background-color: rgb(30, 30, 30); padding: 10px; color: white;">

            <?php if($gestor[0]['saldo'] >= 0):?>
                <span style="font-size: 20px;">Saldo: <span style="color: limegreen;"><?php echo number_format($gestor[0]['saldo'], 2); ?> €</span></span>                      
            <?php else: ?>
                <span style="font-size: 20px;">Saldo: <span style="color: red;"><?php echo number_format($gestor[0]['saldo'], 2); ?> €</span></span> 
            <?php endif; ?>
            
        </div>       
    </div>

    <div class="row">
        <div class="col-md-12 mt-5">
            <h3>Alterar Saldo</h3>
            <div class="separador"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-5">
            <form action="<?php echo site_url("gestor/alterar_saldo"); ?>" method="post" id="frm_criar_atalho">

                <div class="row">
                    <div class="col-md-1">
                        <span>Saldo</span>
                        <input type="text" name="valor_saldo" class="form-control text-center" style="width: 90px;" />
                    </div>
                    <div class="col-md-1">
                        <br>
                        <span style="font-size: 25px;">€</span>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <input type="submit" value="Alterar Saldo Manualmente" class="botao_green" />
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>