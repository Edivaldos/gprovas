<script>
var url = "http://10.133.149.193/database/api/get-by-key/";
var key = "Name";
var cod = "m�e";
$.get( url,{key: key, cod: cod}).done(function( data ) {
  alert( "Data Loaded: " + data );
});
</script>