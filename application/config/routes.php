<?php
defined('BASEPATH') OR exit('No direct script access allowed');

##############################################################################################################
################################ ROTAS DO CONTROLE DE ACESSO  ################################################

$route['default_controller'] = 'Home_c';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

################################ ROTAS DE FUN��ES DE USU�RIO ################################################
$route['login'] = "Usuario_c/login";
$route['login-post'] = "Usuario_c/login_post";
$route['registrar'] = "Usuario_c/registrar";
$route['registrar-post'] = "Usuario_c/registrar_post";

