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
        <div class="col-md-12 mb-5">

            <form action="<?php echo site_url("balancos/pesquisar"); ?>" method="post" id="frm_criar_atalho">

                <h5>Data do Balanço</h5>
                <select name="combo_data_balanco" class="form-control">
                    <?php foreach($fecho_de_contas as $fecho): ?>
                        <option value="<?php echo $fecho['data_abertura'].' / '.$fecho['data_fecho']; ?>">
                            <?php echo $fecho['data_abertura'].' / '.$fecho['data_fecho']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Pesquisar" class="botao_blue mt-4" />

            </form>

        </div>
    </div>

    <div id="janela_balanco">

        <?php if(isset($dados_fecho_de_conta[0]['id_fecho'])): ?>

            <div class="row">
                <div class="col-md-12 mt-3">
                    <h4>Balanço de <?php echo $dados_fecho_de_conta[0]['data_abertura'].' / '.$dados_fecho_de_conta[0]['data_fecho']; ?></h4>
                    <div class="separador"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table border="1" class="table tabela_fecho_de_contas_balanco text-center">       
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Nome</th>
                            <th>Tipo</th>    
                            <th>Valor</th>                                                                
                        </tr>

                    <?php foreach($dados_fecho_de_conta as $fc): ?>
                        <tr>
                            <td>
                                <span>#<?php echo $fc['id_fecho']; ?></span>
                            </td>
                            <td>
                                <span><?php $data_formatada = strtotime($fc['data']); echo date('d-m-Y', $data_formatada); ?></span>
                            </td>
                            <td>
                                <span><?php echo $fc['nome']; ?></span>
                            </td>
                            <td>
                                <span><?php echo $fc['tipo']; ?></span>
                            </td>
                            <td>          
                                <?php                           
                                    if($fc['valor_despesa'] == null){
                                        echo '<span>'.$fc['valor_receita'].' €</span>';
                                    }
                                    else{
                                        echo '<span>'.$fc['valor_despesa'].' €</span>';
                                    }
                                ?>
                            </td>             
                        </tr>
                    <?php endforeach; ?>   
                    </table>

                    <table class="table tabela_fecho_de_contas text-center mt-5">       
                        <tr>
                            <td>
                                <div class="align-self-center d-flex justify-content-start pl-5">
                                    <span style="font-size: 20px;">Créditos:</span>
                                </div>
                            </td>
                            <td>
                                <div class="align-self-center d-flex justify-content-end pr-5">
                                    <span style="font-size: 20px; color: limegreen;"><?php echo number_format($total_receitas[0]['valor_receita'], 2); ?> €</span>
                                <div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="align-self-center d-flex justify-content-start pl-5">
                                    <span style="font-size: 20px;">Débitos:</span>
                                </div>
                            </td>
                            <td>
                                <div class="align-self-center d-flex justify-content-end pr-5">
                                    <span style="font-size: 20px; color: red;"><?php echo number_format($total_despesas[0]['valor_despesa'], 2); ?> €</span>
                                <div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="align-self-center d-flex justify-content-start pl-5">
                                    <span style="font-size: 20px;">Balanço:</span>  
                                </div>  
                            </td>
                            <td>
                                <div class="align-self-center d-flex justify-content-end pr-5">
                                    <?php 
                                        $balanco = $total_receitas[0]['valor_receita'] - $total_despesas[0]['valor_despesa'];

                                        if($balanco < 0)
                                        {
                                            echo '<span style="color: red; font-size: 20px;"> '.number_format($balanco, 2).' €</span>';
                                        } 
                                        else
                                        {
                                            echo '<span style="color: limegreen; font-size: 20px;"> '.number_format($balanco, 2).' €</span>';
                                        }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> <!-- Fim de Janela de Imprimir -->

        <div class="row">
            <div class="col-md-12 mb-5">
                
                <a href="<?php echo site_url('balancos/editar?da='.$dados_fecho_de_conta[0]['data_abertura'].'&df='.$dados_fecho_de_conta[0]['data_fecho']); ?>"><button class="botao_yellow" style="outline: none;" id="btn_editar">Editar Balanço</button></a>

                <button class="botao_blue" style="outline: none;" id="btn_imprimir" onclick="imprimir()">Imprimir</button>

                <button style="float: right;" class="botao_red" style="outline: none;" id="btn_eliminar" onclick="apagar_registo()">Eliminar Registo</button>

                <div id="frm_eliminar" style="display: none;">
                    <button class="botao_red" style="outline: none;" id="btn_cancelar" onclick="cancelar_registo()">Cancelar</button>
                    <a href="<?php echo site_url('balancos/eliminar?da='.$dados_fecho_de_conta[0]['data_abertura'].'&df='.$dados_fecho_de_conta[0]['data_fecho']); ?>"><button class="botao_green ml-1" style="outline: none;" id="btn_confirmar">Confirmar</button></a>
                </div>

            </div>
        </div>
                    
    <!-- <?php //else: ?>
        <span>Não existe nenhum balanço registado nesta data.</span> -->
    <?php endif; ?> 

</div>

<script>

    function cancelar_registo(){
        $("#frm_eliminar").css("display", "none");
        $("#btn_editar").css("display", "inline");
        $("#btn_imprimir").css("display", "inline");
        $("#btn_eliminar").css("display", "inline");
    }

    function apagar_registo(){
        $("#btn_eliminar").css("display", "none");
        $("#btn_editar").css("display", "none");
        $("#btn_imprimir").css("display", "none");
        $("#frm_eliminar").css("display", "inline");
    }

    function imprimir(){
        var janela_print = document.getElementById("janela_balanco").innerHTML;
        var janela = document.body.innerHTML;

        document.body.innerHTML = janela_print;

        window.print();

        document.body.innerHTML = janela;
    }

</script>