<?= form_open('registrar-post', ['class' => "md-form col-8 mx-auto text-center p-5"])?>
    <p class="h4 mb-4">Registrar uma nova conta</p>
    <div class="form-row mt-3 justify-content-center">
		<div class="col-4">
			<input type="text" id="user_nome" class="form-control" required>
			<label>Primeiro nome</label>
		</div>
		<div class="col-4">
			<input type="text" id="user_sobrenome" class="form-control" required>
			<label>Sobrenome</label>
		</div>
	</div>
    <div class="form-row mt-3 justify-content-center">
		<div class="col-8">
			<input type="email" id="user_email" class="form-control" required>
			<label>Meu e-mail</label>
		</div>
	</div>
    <div class="form-row mt-3 justify-content-center">
		<div class="col-8">
			<input type="password" id="user_pass" class="form-control" required>
			<label>Minha senha</label>
		</div>
	</div>
    <button class="btn btn-info my-4" type="submit">Entrar na conta</button>

	<p>Já possui conta?
        <a href="<?=base_url()?>login">Entrar na minha conta</a>
    </p>
<?= form_close()?>

<script>
$(function (){
	resolver_labels_mdb();//Ver funcoes.js em include/js
});
</script>