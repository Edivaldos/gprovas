<?= form_open('login-post', ['class' => "md-form col-8 mx-auto text-center p-5"])?>
    <p class="h4 mb-4">Entrar na minha conta</p>
    <div class="form-row ">
			<div class="col-8 mx-auto">
				<input type="email" id="user_email" class="form-control" required>
				<label>Meu e-mail</label>
			</div>
		</div>
    <div class="form-row mt-4">
			<div class="col-8 mx-auto ">
				<input type="password" id="user_pass" class="form-control" required>
				<label>Minha senha</label>
			</div>
		</div>
    <button class="btn btn-info my-4" type="submit">Entrar na minha conta</button>
    <!-- Register -->
    <p>Ainda não possui conta?
        <a href="<?=base_url()?>registrar">Me registrar</a>
    </p>
<?= form_close()?>

<script>
$(function (){
	resolver_labels_mdb();//Ver funcoes.js em include/js
});
</script>