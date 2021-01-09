<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header text-center">
                <a href="http://localhost"><h1>Gestolik</h1></a>
            </div>

            <ul class="list-unstyled text-center">
                <li>
                    <a href="<?php echo site_url('gestor/abrir_balanco'); ?>">Abrir Balanço</a>
                </li>
                <li>
                    <a href="<?php echo site_url('gestor/despesas'); ?>">Despesas</a>
                </li>
                <li>
                    <a href="<?php echo site_url('gestor/receitas'); ?>">Receitas</a>
                </li>
                <li>
                    <a href="<?php echo site_url('balancos/balanco'); ?>">Balanço</a>
                </li>
                <li>
                    <a href="<?php echo site_url('balancos'); ?>">Ver Balanços</a>
                </li>
                <li>
                    <a href="<?php echo site_url('balancos/balanco_anual'); ?>">Balanço Anual</a>
                </li>
                <li>
                    <a href="<?php echo site_url('gestor/saldo'); ?>">Saldo</a>
                </li>    
                <li>
                    <a href="https://raw.githubusercontent.com/KrolikPT/Gestolik/main/documentacao.txt" target="_blank" style="color: cyan;">Documentação</a>
                </li>  
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light barra-menu" style="border-radius: 10px 10px 10px 10px;">
                <div class="container-fluid">

                    <span id="data_hora"></span>

                    <!-- <div id="sidebarCollapse" class="btn btn-menu">
                        <i class="fa fa-align-left"></i>
                        <span>Menu</span>
                    </div> -->
                    
                   

                </div>
            </nav>

            <script>

                $(document).ready(() => {

                    setInterval(() => {

                        var data = new Date();

                        // document.getElementById("data_hora").innerHTML = data.getDate() + "/" + data.getUTCMonth() + "/" + data.getFullYear();
                        document.getElementById("data_hora").innerHTML = data.toLocaleString();
                    }, 100);

                });

            </script>

            