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
            <h3>Nova Receita</h3>
            <div class="separador"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-5">
            <form action="<?php echo site_url("gestor/criar_receita"); ?>" method="post" id="frm_criar_atalho">

                <div class="row">
                    <div class="col-md-6">
                        <span>Nome</span>
                        <input type="text" name="nome_receita" class="form-control" />
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
            <h3>Receitas</h3>
            <div class="separador"></div>
        </div>
    </div>

    <?php if(isset($receitas[0]['id_receita'])): ?>
    
        <!-- Receitas -->
        <table class="table tabela_despesas text-center">
        
            <tr>
                <th>ID</a></th>
                <th>Nome</a></th>
                <!-- <th>Valor</a></th> -->
                <th>Ações</a></th>
            </tr>

            <?php foreach($receitas as $r): ?>
                <tr>
                    <td>
                        <span># <?php echo $r['id_receita']; ?></span>
                    </td>
                    <td>
                        <span><?php echo $r['nome']; ?></span>
                    </td>
                    <!-- <td>
                        <span><?php echo $r['valor']; ?> €</span>
                    </td>               -->
                    <td>
                        <?php if($r['id_receita'] > 0): ?>
                            <a href="<?php echo site_url("gestor/editar_receita"); ?>?n=<?php echo $r['nome'] ?>" data-toggle="tooltip" data-placement="bottom" title="Editar"><img src="<?php echo base_url("assets/images/icons/editar.png"); ?>" width="20"></a>
                            <a href="<?php echo site_url("gestor/apagar_receita"); ?>?n=<?php echo $r['nome'] ?>" data-toggle="tooltip" data-placement="bottom" title="Apagar" class="ml-2"><img src="<?php echo base_url("assets/images/icons/apagar.png"); ?>" width="20"></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php else: ?>

        <span>Lista de receitas sem registos.</span>

    <?php endif; ?>

</div>