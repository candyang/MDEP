<?
include("../opendata.php");
if($buildno!=""){
?>
<form name="mapposition" action="recordmap.php?buildno=<?=$buildno?>" method="post">
<input type=image name=face src="../image/3rdmap2.jpg" usemap="#buildmap" style="position:absolute; left:0; top:0">
</form>
<script>
alert("請點選左圖位置")
</script>
<?}else{?>
<html>
<body>
<map name="showmap">
<?
$rows=Mysql_query("select community_no,name,map_position,local_id from community");
while($row = mysql_fetch_array ($rows,MYSQL_BOTH) ){
  if($row["map_position"]!=""){
  $localsql="select local_name from local_class where local_id='".$row["local_id"]."'";
  $localinfo=Mysql_query($localsql);
  List($localname)=Mysql_fetch_row($localinfo);
  $mapposition=$row["map_position"].",8";
?>
  <area href="cbframe.php?communityno=<?=$row["community_no"]?>" shape="circle" coords="<?=$mapposition?>" target="_blank" alt="<?=$localname?><?=$row["name"]?>">
<?}}?>
</map>
<img src="../image/3rdmap2.jpg" usemap="#showmap" border="0" style="position:absolute; left:0; top:0">
<?}?>
</body>
</html>
