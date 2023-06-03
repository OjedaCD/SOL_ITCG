<?php  
    require "../../includes/funciones.php";  $auth = estaAutenticado();
    require "../../includes/config/database.php";
    if (!$auth) {
       header('location: /'); die();
    }
    
    inlcuirTemplate('header');
    
    if ($_SERVER['REQUEST_METHOD']=="POST"){
        
        include('RespaldoTools.php');
 
        $arrayDbConf['host'] = 'localhost';
        $arrayDbConf['user'] = 'sigacitc_sol_itcg';
        $arrayDbConf['pass'] = 'Solitcg2022';
        $arrayDbConf['name'] = 'sigacitc_sol_itcg';
        try {
            $bck = new MySqlBackupLite($arrayDbConf);
            $bck->backUp();
            $bck->downloadFile();            
        }
        catch(Exception $e) {
            echo $e; 
            
        }
        
    }
?>
<main class="RespaldoBDD">
    <section class="w80">
        <h1>Respaldar Base de Datos</h1>
        <form method="POST">
            <button><input type="submit" >Crear Respaldo</button>
        </form>
    </section>
    
</main>
<?php 
    inlcuirTemplate('footer');
?>