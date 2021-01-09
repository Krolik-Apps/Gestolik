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
        <div class="col-md-6 pl-4" style="background-color: rgb(30, 30, 30); padding: 10px; color: white; font-size: 20px;">
                 
        </div>
        <div class="col-md-6 pr-4 d-flex justify-content-end" style="background-color: rgb(30, 30, 30); padding: 10px; color: white; font-size: 20px;">
            <?php if($saldo[0]['saldo'] > 0):?>
                <span style="font-size: 20px;">Saldo: <span style="color: limegreen;"><?php echo number_format($saldo[0]['saldo'], 2); ?>€</span></span>                      
            <?php else: ?>
                <span style="font-size: 20px;">Saldo: <span style="color: red;"><?php echo number_format($saldo[0]['saldo'], 2); ?>€</span></span> 
            <?php endif; ?>
        </div>
    </div>

    <!-- Editar Balanço -->
    <div class="row">
        <div class="col-md-12 mt-4">
            <h3>Adicionar Despesa</h3>
            <div class="separador"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-5">
            
        <form action="<?php echo site_url("balancos/acrescentar_despesa_editar"); ?>" method="post" id="frm_criar_atalho">

            <div class="row">
                <div class="col-md-3 mb-4">

                    <span>Data de Registo</span>
                    <input type="date" class="form-control" style="width: 190px;" name="data_despesa" value="<?php date_default_timezone_set('Europe/London'); echo date('Y-m-d'); ?>">
                    <input type="hidden" value="<?php echo $_GET['da']; ?>" name="data_abertura" />
                    <input type="hidden" value="<?php echo $_GET['df']; ?>" name="data_fecho" />

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
                    <input type="submit" value="Adicionar" class="botao_green" name="frm_despesa" />
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
            
        <form action="<?php echo site_url("balancos/acrescentar_receita_editar"); ?>" method="post" id="frm_criar_atalho">

            <div class="row">
                <div class="col-md-3 mb-4">

                    <span>Data de Registo</span>
                    <input type="date" class="form-control" style="width: 190px;" name="data_receita" value="<?php date_default_timezone_set('Europe/London'); echo date('Y-m-d'); ?>">
                    <input type="hidden" value="<?php echo $_GET['da']; ?>" name="data_abertura" />
                    <input type="hidden" value="<?php echo $_GET['df']; ?>" name="data_fecho" />

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
                    <input type="submit" value="Adicionar" class="botao_green" name="frm_receita" />
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

        <?php if(isset($fecho_de_contas[0]['id_fecho'])): ?>
            <div class="row">
                <div class="col-md-12">
                    <table class="table tabela_balanco_editar text-center">       
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>

                    <?php foreach($fecho_de_contas as $fc): ?>
                        <form action="<?php echo site_url('balancos/gravar_linha'); ?>?id=<?php echo $fc['id_fecho']; ?>&da=<?php echo $_GET['da']; ?>&df=<?php echo $_GET['df']; ?>" method="post">

                            <tr>
                                <td>
                                    <span>#<?php echo $fc['id_fecho']; ?></span>
                                </td>
                                <td>
                                    <input type="text" value="<?php $data_formatada = strtotime($fc['data']); echo date('d-m-Y', $data_formatada); ?>" name="data_item" />
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $fc['nome']; ?>" name="nome_item" />
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $fc['tipo']; ?>" name="tipo_item" />
                                </td>
                                <td>

                                    <?php if($fc['valor_despesa'] == null): ?>
                                        <input type="text" value="<?php echo $fc['valor_receita']; ?>" name="valor_item" />
                                    <?php else: ?>
                                        <input type="text" value="<?php echo $fc['valor_despesa']; ?>" name="valor_item" />
                                    <?php endif; ?>
                                    
                                </td>              
                                <td>      
                                    <button type="submit" id="btn_editar_linha" style=" border: none;
                                                                                        background: none;
                                                                                        cursor: pointer;
                                                                                        margin: 0;
                                                                                        padding: 0;
                                                                                        cursor: pointer;">
                                        <img src="" alt=""><img src="<?php echo base_url("assets/images/icons/gravar.png"); ?>" width="20">
                                    </button>

                                    <a href="<?php echo site_url("balancos/apagar_editar"); ?>?id=<?php echo $fc['id_fecho']; ?>&da=<?php echo $_GET['da']; ?>&df=<?php echo $_GET['df']; ?>" data-toggle="tooltip" data-placement="bottom" title="Apagar" class="ml-2"><img src="<?php echo base_url("assets/images/icons/apagar.png"); ?>" width="20"></a>
                                </td>
                            </tr>
                        </form>
                    <?php endforeach; ?>    

                    </table>
                </div>
            </div>

            <form action="<?php echo site_url("balancos/guardar_balanco"); ?>?da=<?php echo $fecho_de_contas[0]['data_abertura']; ?>&df=<?php echo $fecho_de_contas[0]['data_fecho']; ?>" method="post" id="frm_criar_atalho">

                <div class="row">
                    <div class="col-md-12 mt-3">

                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <span>Data de Abertura</span>
                                <input type="date" class="form-control" style="width: 190px;" name="data_abertura" value="<?php echo $fecho_de_contas[0]['data_abertura']; ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <span>Data de Fecho</span>
                                <input type="date" class="form-control" style="width: 190px;" name="data_fecho" value="<?php echo $fecho_de_contas[0]['data_fecho']; ?>">
                            </div>
                        </div>

                        <div class="row mt-2 mb-5 mt-3">
                            <div class="col-md-12">
                                <input type="submit" value="Guardar Balanço" class="botao_green" />
                            </div>
                        </div>

                    </div>
                </div>

            </form>

    <?php else: ?>
        <span>Nenhuma linha registada.</span>
    <?php endif; ?>

</div>