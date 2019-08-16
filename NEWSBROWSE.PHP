<?
  include("../opendata.php");

  if (isset($page)){ //判斷page是否有設定值
     $begin=($page-1)*7;
  }
  else{
     $begin=0;
     $page=1;
  }

?>


<script Language="JavaScript">

function jump() { //跳頁
   a=document.SelectForm.page.selectedIndex+1;
window.location.replace("newsbrowse.php?btype=<?=$btype?>&page="+a);
}

function next() { //下一頁
window.location.replace("newsbrowse.php?btype=<?=$btype?>&page=<?=$page+1?>");
}

function prev() { //上一頁
window.location.replace("newsbrowse.php?btype=<?=$btype?>&page=<?=$page-1?>");
}

function delrecord(deltype,delval,recordno) { //刪除
   var return_value=confirm("確定刪除?")
   if (return_value)
     var return_valuesub=confirm("保留上傳檔案?")

   if (return_value & return_valuesub)
     delval=delval+"root";

   if (return_value)
     window.location.replace("newsbrowse.php?btype="+deltype+"&send="+delval+"&delno="+recordno);
}

function editrecord(edittype,editno){ //修改試卷內容
window.location.replace("../manager/news.php?btype="+edittype+"&editno="+editno+"&dba=edit")
}
</script>

<?

 If($send=="delete"){ //判斷是否有要求異動
    $pathsql=Mysql_query("select link_path from news where new_no=$delno");
    $pathrow=Mysql_fetch_row($pathsql);
    if($pathrow[0]!="") unlink($pathrow[0]);
    $svsql="delete from news where new_no=".$delno;
    $rows=Mysql_query($svsql);
 }elseif($send=="deleteroot"){
    $svsql="delete from news where new_no=".$delno;
    $rows=Mysql_query($svsql);
 }


Switch($btype)
{
   case 0:
    $browsename="butt20.gif";
    $sqladd="=";
    break;
   case 1:
    $browsename="butt1.gif";
    $sqladd="=";
    break;
   case 2:
    $browsename="butt2.gif";
    $sqladd=">=";
    break;
}

$addrecordpath="../manager/news.php?btype=".$btype;

$sql1="select CEILING(count(*)/7) from news where classid='news' and link_id $sqladd '$btype'";
$rows=mysql_query($sql1);
$row=mysql_fetch_array($rows);
mysql_free_result($rows);
$MaxPage=$row[0];

$sql="select * from news where classid='news' and link_id $sqladd '$btype' order by datetime desc LIMIT $begin,7"; //秀資料
$rows=mysql_query($sql);

?>
<HTML>
<HEAD>
<style>
a {text-decoration:none}
a:hover{position:relative;top:1px;left:1px;}
</style>
</HEAD>
<BODY background="../image/12.jpg" bgproperties="fixed">
  <table width="100%">
    <tr>
      <td><img src="../image/<?=$browsename?>" border=0></td>
      <?if($session_usrstatus=="中心團隊"){?>
      <td align="center"><a href="../manager/news.php?btype=<?=$btype?>&dba=add">新增消息</a></td>
      <?}?>
      <td align="center"><font size=2>
        <?
   if($page>1){
        ?>
        <a href="javascript:prev()">上一頁</a>
        <?
   }
   else{
        ?>
        <font color="Silver">上一頁</font>
        <?
   }
        ?>
      </font></td>
      <td align="center"><font size=2>
        <?
   if($page<$MaxPage){
        ?>
        <a href="javascript:next()">下一頁</a>
        <?
   }
   else{
        ?>
        下一頁
        <?
   }
        ?>
      </font></td>
      <td align="center" valign="bottom"><font size=2>
        <form name="SelectForm">
         快速跳頁
          <select name="page" onchange="javascript:jump()">
                 <?
                    for($i=1;$i<=$MaxPage;$i++){
                              if($i==$page){
                                echo "<option selected>$i</option>";
                              }
                              else{
                                echo "<option>$i</option>";
                              }
                    }?>
          </select>
        </form>
      </font></td>
    </tr>
  </table>

<TABLE  border="0" width="102%" bordercolor="#800000" cellpadding="1" cellspacing="1" >
<tr><td></td><td colspan=60% align="center">消息內容</td><td colspan=40% align="right">公告日期</td>
<?if($session_usrstatus=="中心團隊"){?>
<td colspan=30%></td>
<?}?>
</tr>
<tr><td colspan=102%><hr></td></tr>
<form action="news.php?btype=<?=$btype?>" method=post name="news">
<?
   while($row = mysql_fetch_array ($rows,MYSQL_BOTH) ){
?>
<tr><td valign="top"><img border="0" src="../image/logo.gif" width="16"></td>
<td colspan=60% valign="top"><font size=2>
<?
  if($row["link_address"]<>""){
?>
     <a href="http://<?=$row["link_address"]?>" target="_blank">
<?}
  elseif($row["link_path"]<>""){
?>
     <a href="<?=$row["link_path"]?>" target="_blank">
<?}?>
<?=$row["contents"]?></a>
</font></td>
<td colspan=40% valign="top" align="right"><font size=2><?=substr($row["datetime"],0,10)?>
</font></td>
<?if($session_usrstatus=="中心團隊"){?>
<td colspan=15% valign="top"><font size=2><a href="javascript:editrecord(<?=$btype?>,<?=$row["new_no"]?>)">修改</a>
</font></td>
<td colspan=15% valign="top"><font size=2><a href="javascript:delrecord(<?=$btype?>,'delete',<?=$row["new_no"]?>)">刪除</a>
</font></td>
<?}}?>
</tr>
</table>
</form>
</body>
</html>
