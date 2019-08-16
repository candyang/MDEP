<?
include("../opendata.php"); 
?>
<html>

<head>
<title>³Ì·s®ø®§</title>
</head>

<body>
<?    
$newtype=1;
$newssql=Mysql_query("select * from news where link_id='$newtype'");   
      
while($newsinfo=Mysql_fetch_array($newssql,MYSQL_BOTH)){ 
?>        
<div align="center">  
  <center>  
  <table border="0" width="600" height="1" bgcolor="#C8C9FF">  
    <tr>  
      <td width="32" height="1">  
        <p align="center"><font" size="2"><img border="0" src="../image/logo.gif" width="18" height="17"></font></td> 
      <td width="433" height="1">
<?
  if($newsinfo["link_address"]<>""){
?>
     <a href="http://<?=$newsinfo["link_address"]?>">
<?}
  elseif($newsinfo["link_path"]<>""){
?>
     <a href="<?=$newsinfo["link_path"]?>">
<?}?>
<font" size="2"><?=$newsinfo["contents"]?></font></a>
</td> 
      <td width="109" height="1"><font color="Green" size="2""><?=substr($newsinfo["datetime"],0,10)?></font></td> 
    </tr> 
  </table> 
  </center> 
</div> 
<?}?> 
</body> 
</html> 
