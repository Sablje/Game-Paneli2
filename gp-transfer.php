<?php
session_start();
include("includes.php");
$naslov = "Transfer";
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-transfer";
$gpr = "1";
$gps = "gp-transfer";

$basename = basename($_SERVER['REQUEST_URI']);




if(klijentServeri($_SESSION['klijentid']) == 0)
{
	$_SESSION['msg'] = $jezik['text300'];
	header("Location: index.php");
}


/*if($_SESSION['klijentid'] != 652)
{
	$_SESSION['msg'] = "Soon.";
	header("Location: index.php");
}*/

$serverid = mysql_real_escape_string($_GET['id']);

if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
}

if(!isset($_GET['id']) or !is_numeric($_GET['id']))
{
	$_SESSION['msg'] = $jezik['text311'];
	header("Location: gp-serveri.php");
	die();
}

if(query_numrows("SELECT `id` FROM `serveri` WHERE `user_id` = '".$_SESSION['klijentid']."' AND `id` = '".$serverid."'") == 0)
{
	$_SESSION['msg'] = $jezik['text312'];
	header("Location: gp-serveri.php");
	die();
}

$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '{$serverid}'");
$boxip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '{$server['ip_id']}'");


include("./assets/header.php");

$cg2 = new CSRFGuard();
?>
    <div class="main">
        <div class="panel">
             <div class="panel-nav">
                    <ul class="light-border">
                        <a href="gp-server.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-server") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-flag"></i> <?php echo $jezik['text20']; ?>
                            </li>
                        </a>
                        <a href="gp-webftp.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-webftp") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-folder-open"></i> <?php echo $jezik['text21']; ?>
                            </li>
                        </a>
<?php
                        if($server['igra'] == "1") {
?>
                        <a href="gp-admini.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-admini") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-group"></i> <?php echo $jezik['text22']; ?>
                            </li>
                        </a>
                        <a href="gp-plugins.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-plugins") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-gear"></i> <?php echo $jezik['text23']; ?>
                            </li>
                        </a>
<?php
                        }
?>
                        <a href="gp-modovi.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-modovi") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-gear"></i> <?php echo $jezik['text24']; ?>
                            </li>
                        </a>
                        <a href="gp-konzola.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-konzola") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-th-list"></i> Console
                            </li>
                        </a>
                        <!--<a href="gp-backup2.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-backup2") echo 'class="active"'; ?>>
                                <i class="icon-download"></i> Backup
                            </li>
                        </a>-->
                        <a href="gp-reinstall.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-reinstall") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-refresh"></i> <?php echo $jezik['text25']; ?>
                            </li>
                        </a>
                        <a href="gp-transfer.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-transfer") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-gear"></i> <?php echo "Transfer"; ?>
                            </li>
                        </a>



<?php
                        if($server['igra'] == "1") {
?>
                        <a href="gp-boost.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-boost") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-random"></i> <?php echo $jezik['text26']; ?>
                            </li>
                        </a>

<?php
                        }
?>
                                                <a href="gp-autorestart.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-autorestart") echo 'class="panel-nav-active"'; ?>><i class="icon-refresh"></i> AutoRR</li>
                        </a>


                    </ul>
                </div>


            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-red"><i class="fas fa-server"></i> Transfer</h4>
                        <p>Dodaj server na nekog drugog klijenta<br><font class="c-red">Pažnja!</font> Server će biti izbrisan s Vašeg računa ukoliko ga prebacite na drugog klijenta.</p>
                    </div>

               <div class="new-ticket">
        <form action="serverprocess.php" method="POST">              
            <input type="hidden" name="task" value="prebacisrv" />
            <input type="hidden" name="serverid" value="<?php echo mysql_real_escape_string($_GET['id']); ?>" />
            <div class="form-input">
                <label>* <?php echo "Unesite e-mail novog klijenta"; ?></label>
                <input name="email" type="text" placeholder="<?php echo "E-mail novog klijenta"; ?>" id="ki" /><br />
            </div>

            <div class="form-input">
                <button type="submit"><i class="icon-exchange"></i> <?php echo $jezik['text205']; ?></button>
          
            </div>
        </form>
		</div>
	</div>
</div>
</div>
</div>
<?php
include("./assets/footer.php");
?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
/* width */
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: orange; 
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: orange; 
}
</style>
</head>   


</html>