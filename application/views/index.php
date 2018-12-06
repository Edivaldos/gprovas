<div class="view" style="background-image: url('<?=base_url()?>images/man-doing-test.jpg'); background-repeat: no-repeat; background-size: cover;height: 100vh;margin-top: -10px;">
<div class="mask rgba-black-light d-flex justify-content-center align-items-center">
	<div class="text-center white-text mx-5 wow fadeIn">
		<h1 class="mb-4">
			<strong>Seja bem vindo ao GProvas!!!</strong>
		</h1>

		<p class="mb-4 d-none d-md-block">
			<strong>Um novo sistema de gerência de provas!</strong>
		</p>
		<a href="<?=base_url()?>login" class="btn btn-outline-white btn-lg">Entrar na minha conta
			<i class="fa fa-graduation-cap ml-2"></i>
		</a>
		
		<a href="<?=base_url()?>registrar" class="btn btn-outline-white btn-lg">Quero criar uma conta
			<i class="fa fa-user-plus ml-2"></i>
		</a>
	</div>
</div>
</div>

<script>
$(function (){
	$(".view").parent().removeClass("container");//Um pequeno 'gato' pra poder deixar a imagem em tela cheia
});
</script>