<?php

try {
    $pdo = new PDO("mysql:dbname=projeto_comentarios;host=localhost", "root", "");

} catch(PDOException $e) {
    echo "ERRO: ".$e->getMessage();
    exit;
}

if(empty($_POST['nome'])){
    $nome = 'Nome';
}
if(isset($_POST['nome']) && !empty($_POST['nome'])) {
    
    $nome = $_POST['nome'];
    $mensagem = $_POST['mensagem'];

    $sql = $pdo->prepare("INSERT INTO mensagens SET nome = :nome, msg = :msg, data_msg = NOW()");
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":msg", $mensagem);
    $sql->execute();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
<header>
    <div class="head">Messagem Zap</div>
</header>
    
    <br><br>
    <div class="box-msg">

<?php 
$sql = "SELECT * FROM mensagens ORDER BY data_msg DESC";
$sql = $pdo->query($sql);
if($sql->rowCount() > 0) {
    foreach($sql->fetchAll() as $mensagem):
        ?>
        <div class="mensagem-box">
    <strong><?php echo $mensagem['nome']; ?></strong><br>
    <?php echo $mensagem['msg']; ?>
    <br>
    </div>
    <br>
    <?php
    endforeach;

} else {
    echo "Não há mensagens";
}

?>
</div>

    <div class="msg-box">
        <form method="POST">
        <img src="assets/images/141.jpg" width="90px" height="auto" alt="">
            <input type="text" value="<?php echo $nome; ?>" class="nome" name="nome" placeholder="Nome"/>

            <textarea name="mensagem" class="text"  placeholder="Mensagem"></textarea>

            <input type="submit" class="submit" Value="Enviar" />
            <img src="assets/images/141.jpg" class="img2" width="90px" height="auto" alt="">

        </form>
    </div class="msg-box">
</body>
</html>