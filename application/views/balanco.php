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

    <?php if($gestor[0]['conta_aberta'] == 0): ?>
        <div class="row">
            <div class="col-md-12 pl-4 text-center" style="background-color: rgb(30, 30, 30); padding: 10px; color: white; font-size: 20px;">
                <span style="color: red;">Não está nenhum balanço aberto neste momento.</span>  
            </div>
        </div>  
    <?php else: ?>

        <div class="row">
            <div class="col-md-6 pl-4" style="background-color: rgb(30, 30, 30); padding: 10px; color: white; font-size: 20px;">
                <span>Balanço aberto a: </span><span style="color: limegreen;"><?php $data_formatada = date("d-m-Y", strtotime($gestor[0]['data_abertura'])); echo $data_formatada; ?></span>  
            </div>

            <div class="col-md-6 pr-4 d-flex justify-content-end" style="background-color: rgb(30, 30, 30); padding: 10px; color: white; font-size: 20px;">
                <?php if($saldo[0]['saldo'] >= 0):?>
                    <span style="font-size: 20px;">Saldo: <span style="color: limegreen;"><?php echo number_format($saldo[0]['saldo'], 2); ?> €</span></span>                      
                <?php else: ?>
                    <span style="font-size: 20px;">Saldo: <span style="color: red;"><?php echo number_format($saldo[0]['saldo'], 2); ?> €</span></span> 
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mt-4">
                <h3>Adicionar Despesa</h3>
                <div class="separador"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-5">
                
            <form action="<?php echo site_url("balancos/acrescentar_despesa"); ?>" method="post" id="frm_criar_atalho">

                <div class="row">
                    <div class="col-md-3 mb-4">

                        <span>Data de Registo</span>
                        <input type="date" class="form-control" style="width: 190px;" name="data_despesa" value="<?php date_default_timezone_set('Europe/London'); echo date('Y-m-d'); ?>">

                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3">
                        <span>Nome</span>
                        <select name="combo_despesa" class="form-control">
                            <?php foreach($despesas as $d): ?>
                                <option value="<?php echo $d['nome']; ?>"><?php echo $d['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <span>Valor</span>
                        <input type="text" name="valor_despesa" class="form-control text-center" style="width: 90px;">
                    </div>

                    <div class="col-md-1">      
                        <br>             
                        <span style="font-size: 22px;">€</span>
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <input type="submit" value="Adicionar" class="botao_green" />
                    </div>
                </div>

            </form>

            </div>
        </div>

        <!-- RECEITAS -->
        <div class="row">
            <div class="col-md-12 mt-4">
                <h3>Adicionar Receita</h3>
                <div class="separador"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-5">
                
            <form action="<?php echo site_url("balancos/acrescentar_receita"); ?>" method="post" id="frm_criar_atalho">

                <div class="row">
                    <div class="col-md-3 mb-4">

                        <span>Data de Registo</span>
                        <input type="date" class="form-control" style="width: 190px;" name="data_receita" value="<?php date_default_timezone_set('Europe/London'); echo date('Y-m-d'); ?>">

                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3">
                        <span>Nome</span>
                        <select name="combo_receita" class="form-control">
                            <?php foreach($receitas as $r): ?>
                                <option value="<?php echo $r['nome']; ?>"><?php echo $r['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <span>Valor</span>
                        <input type="text" name="valor_receita" class="form-control text-center" style="width: 90px;">
                    </div>

                    <div class="col-md-1">      
                        <br>             
                        <span style="font-size: 22px;">€</span>
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <input type="submit" value="Adicionar" class="botao_green" />
                    </div>
                </div>

            </form>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mt-2">
                <h3>Balanço</h3>
                <div class="separador"></div>
            </div>
        </div>

        <?php if(isset($balanco[0]['id_balanco'])): ?>
            <div class="row">
                <div class="col-md-12">
                    <table class="table tabela_balanco text-center">       
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>

                    <?php foreach($balanco as $bd): ?>
                        <tr>
                            <td>
                                <span># <?php echo $bd['id_balanco']; ?></span>
                            </td>
                            <td>
                                <span><?php $data_formatada = strtotime($bd['data']); echo date('d-m-Y', $data_formatada); ?></span>
                            </td>
                            <td>
                                <span><?php echo $bd['nome']; ?></span>
                            </td>
                            <td>
                                <span><?php echo $bd['tipo']; ?></span>
                            </td>
                            <td>
                                <span><?php echo $bd['valor']; ?> €</span>
                            </td>              
                            <td>                          
                                <a href="<?php echo site_url("balancos/apagar_linha"); ?>?id=<?php echo $bd['id_balanco']; ?>&d=<?php echo $bd['data']; ?>&n=<?php echo $bd['nome']; ?>&t=<?php echo $bd['tipo']; ?>&v=<?php echo $bd['valor']; ?>" data-toggle="tooltip" data-placement="bottom" title="Apagar" class="ml-2"><img src="<?php echo base_url("assets/images/icons/apagar.png"); ?>" width="20"></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>    

                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-3">

                    <form action="<?php echo site_url("balancos/fechar_conta"); ?>" method="post" id="frm_criar_atalho">

                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <span>Data de Fecho</span>
                                <input type="date" class="form-control" style="width: 190px;" name="data_fecho" value="<?php date_default_timezone_set('Europe/London'); echo date('Y-m-d'); ?>">
                            </div>
                        </div>
            
                        <div class="row mt-2 mb-5 mt-3">
                            <div class="col-md-12">
                                <input type="submit" value="Fechar Balanço" class="botao_red" />
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        <?php else: ?>
            <span>Nenhuma linha registada.</span>
        <?php endif; ?> 

    <?php endif; ?>     
</div>