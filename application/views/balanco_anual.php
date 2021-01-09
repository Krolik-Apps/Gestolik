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
            <form action="<?php echo site_url("balancos/pesquisa_anual"); ?>" method="post" id="frm_criar_atalho">

                <h5>Data do Balanço Anual</h5>
                <select name="combo_data_balanco_anual" class="form-control">
                    <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                    
                    <?php for($i = 2000; $i <= 2100; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>

                </select>

                <input type="submit" value="Pesquisar" class="botao_blue mt-4" name="submit" />

            </form>
        </div>
    </div>

    <div id="janela_balanco">

        <?php if(isset($total_despesas[0]['nome']) || isset($total_receitas[0]['nome'])): ?>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <h4>Balanço Anual de <?php echo $ano_balanco; ?></h4>
                    <div class="separador"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-3">
                    <h4>Despesas Anuais</h4>
                </div>
            </div>

            <!-- Tabela com as despesas -->
            <table class="table tabela_fecho_de_contas text-center mt-3">                
                <?php foreach ($total_despesas as $td): ?>
                    <tr>
                        <td>
                            <div class="align-self-center d-flex justify-content-start pl-5">
                                <span style="font-size: 20px;"><?php echo $td['nome']; ?>:</span>
                            </div>
                        </td>
                        <td>
                            <div class="align-self-center d-flex justify-content-end pr-5">
                                <span style="font-size: 20px; color: red;"><?php echo number_format($td['valor_despesa'], 2); ?> €</span>
                            <div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td>
                            <div class="align-self-center d-flex justify-content-start pl-5">
                                <span style="font-size: 20px;">Total Despesas:</span>
                            </div>
                        </td>
                        <td>
                            <div class="align-self-center d-flex justify-content-end pr-5">
                                <span style="font-size: 20px; color: red;"><?php echo number_format($soma_total_depesas, 2); ?> €</span>
                            <div>
                        </td>
                    </tr>
            </table>

            <div class="row">
                <div class="col-md-12 mt-5">
                    <h4>Receitas Anuais</h4>
                </div>
            </div>

            <!-- Tabela com as receitas -->
            <table class="table tabela_fecho_de_contas text-center mt-3">                
                <?php foreach ($total_receitas as $tr): ?>
                    <tr>
                        <td>
                            <div class="align-self-center d-flex justify-content-start pl-5">
                                <span style="font-size: 20px;"><?php echo $tr['nome']; ?>:</span>
                            </div>
                        </td>
                        <td>
                            <div class="align-self-center d-flex justify-content-end pr-5">
                                <span style="font-size: 20px; color: limegreen;"><?php echo number_format($tr['valor_receita'], 2); ?> €</span>
                            <div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td>
                            <div class="align-self-center d-flex justify-content-start pl-5">
                                <span style="font-size: 20px;">Total Receitas:</span>
                            </div>
                        </td>
                        <td>
                            <div class="align-self-center d-flex justify-content-end pr-5">
                                <span style="font-size: 20px; color: limegreen;"><?php echo number_format($soma_total_receitas, 2); ?> €</span>
                            <div>
                        </td>
                    </tr>
            </table>

        </div>

        <div class="row">
            <div class="col-md-12 mt-5">
                <h4>Balanço Anual</h4>
            </div>
        </div>

        <table class="table tabela_fecho_de_contas text-center mt-3">                
            <tr>
                <td>
                    <div class="align-self-center d-flex justify-content-start pl-5">
                        <span style="font-size: 20px;">Balanço Total:</span>
                    </div>
                </td>
                <td>
                    <div class="align-self-center d-flex justify-content-end pr-5">

                        <?php $balanco_anual = number_format($soma_total_receitas, 2) - number_format($soma_total_depesas, 2); ?>

                        <?php if($balanco_anual >= 0):?>
                            <span style="font-size: 20px;"><span style="color: limegreen;"><?php echo $balanco_anual; ?> €</span></span>                      
                        <?php else: ?>
                            <span style="font-size: 20px;"><span style="color: red;"><?php echo $balanco_anual; ?> €</span></span> 
                        <?php endif; ?>

                    <div>
                </td>
            </tr>
        </table>

        <button class="botao_blue mt-2 mb-5" style="outline: none;" id="btn_imprimir" onclick="imprimir()">Imprimir</button>

        <?php else: ?>
            <?php if(isset($_POST['submit'])): ?>
                <span>Não existe nenhum balanço registado nesta data.</span>
            <?php endif; ?>
        <?php endif; ?> 

    </div>
  
</div>


<script>

    function imprimir(){
        var janela_print = document.getElementById("janela_balanco").innerHTML;
        var janela = document.body.innerHTML;

        document.body.innerHTML = janela_print;

        window.print();

        document.body.innerHTML = janela;
    }

</script>