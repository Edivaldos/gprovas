<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="ISO-8859-1">
        <meta name="viewport" content="width=device-width, inital-scale=1, shrink-to-fit=no">
        <?php $this->load->view('shared/css'); ?>
        <title>Gerador de Provas</title>
    </head>
    <body>
        <header>
            <?php $this->load->view('shared/navbar'); ?>
        </header> 
           <?php $this->load->view('shared/js'); ?>
         <div class="container mt-3">
            <?= $content ?>
            <div class="load-div row text-center" tabindex="-100" id="loaddiv">
                <div class="load-inner">
                    <div class="col-8 mx-auto">
                        <div class="lds-dual-ring"></div>
                    </div>
                    <div class="col-8 mx-auto">
                        <h1 class="text-white">Carregando...</h1>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <?php $this->load->view('shared/footer'); ?>
\        </footer>
        </div>
    </body>
</html>
