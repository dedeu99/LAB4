	

<?php
require_once "HTML/Template/IT.php";
include 'db.php';
// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);
 // criar query numa string
 $query = "SELECT * FROM microposts";
 // executar a query
 $result = @ mysql_query($query,$db ); 


// Cria um novo objecto template
 $template = new HTML_Template_IT('.'); 


 // Carrega o template Filmes2_TemplateIT.tpl
 $template->loadTemplatefile('index_template.html',true, true); 

$nrows = mysql_num_rows($result); 
for($i=0; $i<$nrows; $i++) {
 	$tuple = mysql_fetch_array($result,MYSQL_ASSOC);
 	// trabalha com o bloco FILMES do template
 	$template->setCurrentBlock("POSTS");



	$query = "SELECT nome FROM users where id=".$tuple['user_id'];
	$result2 = @mysql_query($query,$db ); 
	$tuple2 = mysql_fetch_array($result2,MYSQL_ASSOC);
 	$template->setVariable('USER', $tuple2['nome'] );



 	$template->setVariable('USERID', $tuple['user_id']);
 	$template->setVariable('UPDATED', $tuple['updated_at']);
	$template->setVariable('MICROPOST', $tuple['content']);
	// Faz o parse do bloco FILMES
 	$template->parseCurrentBlock();
} // end for
// Mostra a tabela 

  // Mostra a tabela
  $template->show();
 // fecha a ligação à base de dados
 mysql_close($db);
?>
