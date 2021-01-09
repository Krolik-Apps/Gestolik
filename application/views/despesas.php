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
            <h3>Nova Despesa</h3>
            <div class="separador"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-5">
            <form action="<?php echo site_url("gestor/criar"); ?>" method="post" id="frm_criar_atalho">

                <div class="row">
                    <div class="col-md-6">
                        <span>Nome</span>
                        <input type="text" name="nome_despesa" class="form-control" />
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <input type="submit" value="Adicionar" class="botao_green" />
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mt-3">
            <h3>Despesas</h3>
            <div class="separador"></div>
        </div>
    </div>

    <?php if(isset($despesas[0]['id_despesa'])): ?>
    
        <!-- Despesas -->
        <table class="table tabela_despesas text-center">
        
            <tr>
                <th>ID</a></th>
                <th>Nome</a></th>
                <!-- <th>Valor</a></th> -->
                <th>Ações</a></th>
            </tr>

            <?php foreach($despesas as $d): ?>
                <tr>
                    <td>
                        <span># <?php echo $d['id_despesa']; ?></span>
                    </td>
                    <td>
                        <span><?php echo $d['nome']; ?></span>
                    </td>
                    <!-- <td>
                        <span><?php echo $d['valor']; ?> €</span>
                    </td>               -->
                    <td>
                        <?php if($d['id_despesa'] > 0): ?>
                            <a href="<?php echo site_url("gestor/editar_despesa"); ?>?n=<?php echo $d['nome'] ?>" data-toggle="tooltip" data-placement="bottom" title="Editar"><img src="<?php echo base_url("assets/images/icons/editar.png"); ?>" width="20"></a>
                            <a href="<?php echo site_url("gestor/apagar_despesa"); ?>?n=<?php echo $d['nome'] ?>" data-toggle="tooltip" data-placement="bottom" title="Apagar" class="ml-2"><img src="<?php echo base_url("assets/images/icons/apagar.png"); ?>" width="20"></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php else: ?>

        <span>Lista de despesas sem registos.</span>

    <?php endif; ?>

</div>