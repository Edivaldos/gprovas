
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
 * Fun��es para o MDB
 */
function resolver_labels_mdb(){
  /*o mdb pede pra quando colocar os labels dos inputs, voc� tem que declarar o id do input dentro do for
  * Essa fun��o deixa automatizado o 'for' dos labels
  */
  $("label").each(function (){
    $(this).attr("for",$(this).prev().attr("id"));
  });
  //Triggers change quando o value for pr�-determinado
  $("input").each(function (){
    if ((this.value !== undefined && this.value.length > 0) || this.value !== "")
    {
      $(this).val(this.value).change();
    }
  });
}

function trigger_changes(){
  //Faz acontece a anima��o dos labels do mdb quando o campo for preenchido pelo javascript ou pelo pr�prio PHP
  $("input").each(function (e){
  $(this).val(this.value).change();
  });
}

/**
 * Fim das fun��es do MDB
 */