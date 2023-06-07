<?php

    // connect database
    require_once 'db_connect.php';

    // start session
    session_start();

    // submit
    if(isset($_POST['btn-entrar'])):
        $erros = array();
        $login = mysqli_escape_string($connect, $_POST['login']);
        $senha = mysqli_escape_string($connect, $_POST['senha']);

        if(empty($login) or empty($senha)): 
            $erros[] = "<h5> O campo login/senha precisa ser preenchido </h5><br>";
        else:
            $sql = "SELECT * FROM usuarios WHERE `login` = '$login'";
            $resultado = mysqli_query($connect, $sql);

            if(mysqli_num_rows($resultado) > 0):

                $senha = md5($senha);
                $sql = "SELECT * FROM usuarios WHERE `login` = '$login' and senha = '$senha'";
                $resultado = mysqli_query($connect, $sql);

                if(mysqli_num_rows($resultado) == 1):
                    $dados = mysqli_fetch_array($resultado);
                    $_SESSION['logado'] = true;
                    $_SESSION['nome'] = $dados['nome'];
                    header('Location: home.php');
                else:
                    $erros[] = "<h5> Usuário e senha não conferem </h5><br>";
                endif;
            else:
                $erros[] = "<h5> Usuário inexistente </h5><br>";
            endif;

        endif;
            
    endif;
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth Login</title>
    <link rel="stylesheet" href="css/style.css">   
</head>
<body style="background-color: #F8F8F8;">
    <div class="container">
        <div class="box-form">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="titulo">Login</div><br>
                <?php  
                    if(!empty($erros)):
                        foreach($erros as $erro):
                            echo $erro;
                        endforeach;
                    endif;
                ?>
                <input type="text" name="login"><br><br>
                <input type="password" name="senha"><br><br>
                <button type="submit" name="btn-entrar" class="btn-login">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>