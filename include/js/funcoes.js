
/**
 * Tela de carregando
 */
function load_show(){
  $("#loaddiv").css("display","block");
}

function load_hide() {
  $("#loaddiv").css("display","none");
}
//Fim 


/**
 * Funções para o MDB
 */
function resolver_labels_mdb(){
  /*o mdb pede pra quando colocar os labels dos inputs, você tem que declarar o id do input dentro do for
  * Essa função deixa automatizado o 'for' dos labels
  */
  $("label").each(function (){
    $(this).attr("for",$(this).prev().attr("id"));
  });
  //Triggers change quando o value for pré-determinado
  $("input").each(function (){
    if ((this.value !== undefined && this.value.length > 0) || this.value !== "")
    {
      $(this).val(this.value).change();
    }
  });
}

function trigger_changes(){
  //Faz acontece a animação dos labels do mdb quando o campo for preenchido pelo javascript ou pelo próprio PHP
  $("input").each(function (e){
  $(this).val(this.value).change();
  });
}

/**
 * Fim das funções do MDB
 */