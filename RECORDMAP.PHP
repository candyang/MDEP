<?
include("../opendata.php");
$positionv=$face_x.",".$face_y;
$sql="update community set map_position='$positionv' where community_no='$buildno'";
Mysql_query($sql);
?>
<script>
alert("«Ø¥ß§¹²¦!!")
window.parent.showbuild.location.replace("communitybrowse.php");
window.location.replace("buildmap.php")
</script>
