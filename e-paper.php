<?
include("../opendata.php");
if($dba=="delete"){
  $sql=mysql_query("select Date_format(publish_date,'%Y-%m-%d'),picfile,mainfile from e_paper where no='$eno'");
  $delv=Mysql_fetch_array($sql,MYSQL_BOTH);
  $delf="/mdepwww_data/epaper/".$delv["publish_date"]."/";
  if(File_exists($delf.$delv["mainfile"]) and !Is_dir($delf.$delv["mainfile"])) Unlink($delf.$delv["mainfile"]);
  $pagecut=explode(",",$delv["picfile"]);
  for($i=1;$i<=count($pagecut);$i++)
     if(File_exists($delf.$pagecut[$i-1]) and !Is_dir($delf.$pagecut[$i-1])) Unlink($delf.$pagecut[$i-1]);
  rmdir($delf);
  Mysql_query("delete from e_paper where no='$eno'");
}

if($dba=="look"){
  Mysql_query("update e_paper set look_num=look_num+1 where no='$eno'");
  $rows=Mysql_query("select mainfile,Date_format(publish_date,'%Y-%m-%d') from e_paper where no='$eno'");
  List($filev,$pubdate)=Mysql_fetch_row($rows);
  $mainpath="/mdepwww_data/epaper/".$pubdate."/".$filev;
?>
  <script>
    window.open("<?=$mainpath?>" );
  </script>
<?
}

//�e�q�l���{���}�l

function autosendepaper($myurl,$epaperno,$subject,$eeno){

  $sendcount=0;
  $myname = "�ĤT������y���߹q�l��";
  $myemail = "trina@mail.nsysu.edu.tw";

  $contactname = "��".$epaperno."���q�l��";

  $content_array = file($myurl);  // ��fileŪ�iarray,�@��@element
  $message = implode("", $content_array);

  $mailrows=mysql_query("select * from order_epaper");
  $countmail=mysql_num_rows($mailrows);

  for($i=1;$i<=$countmail;$i++){
     $mailaddr[$i]=mysql_result($mailrows,$i-1,"email");

     $headers .= "MIME-Version: 1.0\r\n";
     $headers .= "Content-type: text/html; charset=big5\r\n";
     $headers .= "From: ".$myname." <".$myemail.">\r\n";
     //$headers .= "To: ".$mailaddr[$i]."\r\n";
     $successv=mail($mailaddr[$i], $contactname, $message, $headers);

     if($successv)
       $sendcount++;
  }


if($sendcount>0)
  mysql_query("update e_paper set publish_num='$sendcount' where no=$eeno");


return $sendcount;
//�e�q�l���{������
}

if($dba=="sendcheck"){
  $pubcheckrow=Mysql_query("select Date_format(publish_date,'%Y-%m-%d'),published,mainfile,epaper_no,subject from e_paper where no=$eno");
  List($pubdate,$publishedv,$filev,$epaper_no,$subject)=Mysql_fetch_row($pubcheckrow);
  $checkedv=($publishedv=='Y')? 'N' : 'Y';
  mysql_query("update e_paper set published='$checkedv' where no=$eno");
  if($publishedv=='N'){
    $mainpath="/mdepwww_data/epaper/".$pubdate."/".$filev;


    $re_success=autosendepaper($mainpath,$epaper_no,$subject,$eno);
 $msg=($re_success>0) ? "�v�}���[�ݨðe�X�q�l��" : "ĵ�i:���e�X�q�l��!!�Ь��{���޲z��";


  }else{
	$msg="���}���[��";
  }
?>
  <script>
    alert("<?=$msg?>");
  </script>
<?
}

if($dba=="order"){
if(Ereg("^[[:punct:][:alnum:]]+@[[:alnum:]]+\.[[:alnum:]]+",$reader_email)){
  if($order_p=="�h�q"){
    Mysql_query("delete from order_epaper where email='$reader_email'");
    $msgorder="�h�q����!!";
  }else{
    $ordered=mysql_query("select * from order_epaper where email='$reader_email'");
    if(mysql_num_rows($ordered)==0 and $reader_email!="��J�z��E-Mail")
      Mysql_query("insert into order_epaper (email) values ('$reader_email')");
    $msgorder="���±z���q�\,�z�N�|��U�������쥻���߹q�l��";
  }
}else{
   $msgorder="�п�J���T���q�l�l��!!";
}
?>
  <script>
    alert("<?=$msgorder?>");
  </script>
<?
}
?>
<html>
<head>
<style type="text/css">
body {  scrollbar-3d-light-color: #b4b46c;
	scrollbar-arrow-color: #6c0000;
	scrollbar-base-color: #FFFFFF;
	scrollbar-dark-shadow-color: #FFFFFF;
	scrollbar-face-color: #b4b46c;
	scrollbar-highlight-color: #FFFFFF;
	scrollbar-shadow-color: #6c0000;
     }
a {text-decoration:none}
a:hover{position:relative;top:1px;left:1px;}
</style>
<script>
function changef(changm,changy){
  var idx=changm.selectedIndex+1
  window.location.replace("e-paper.php?this_m="+idx+"&this_y="+changy)
}

function changefy(changy,changm){
  var idx=2003+changy.selectedIndex
  window.location.replace("e-paper.php?this_y="+idx+"&this_m="+changm)
}

function delrecord(delval,recordno) { //�R��
   var return_value=confirm("�T�w�R��?")
   if (return_value)
     window.location.replace("e-paper.php?dba="+delval+"&eno="+recordno);
}

function sendcheck(sc,scno){
  window.location.replace("e-paper.php?dba="+sc+"&eno="+scno);
}
</script>
</head>

<body background="../image/backcolor.jpg" bgproperties="fixed">
<?
if($this_m=="") $this_m = date(  "m");
if($this_y=="") $this_y = date(  "Y");
$nowdate=date( "Y")."-".date( "m")."-".date( "d");
?>

<div align="center">
  <center>
  <table border="0" width="100%">
     <tr>
                    <td width="40%" colspan="3"><img src="../image/butt5.gif"></td>
<form action="e-paper.php?dba=order" method="post">
                    <td width="60%" colspan="4">
                      <font size="2"> �K�O�q�\
                        <input name="reader_email" size="12" value="��J�z��E-Mail"
			  		 onFocus="if (this.value=='��J�z��E-Mail') {this.value=''}"
					 onBlur="if(this.value=='')this.value='��J�z��E-Mail'">
                        <input type="submit" name="order_p" value="�q�\">
                        <input type="submit" name="order_p" value="�h�q">
                        </font>
                    </td>
</form>
    </tr>
    <tr>
      <td width="100%" colspan="7">
        <p align="center"><font size=2>��ܦ~���:
		<select size="1" name="yearv" onChange="changefy(this,<?=$this_m?>)">
<?
          for($j=2003;$j<=$nowdate=date( "Y");$j++){
            if($this_y==$j)
             echo "<option selected value=$j>$j</option>";
            else
             echo "<option value=$j>$j</option>";
          }

?>
        </select>�~
		<select size="1" name="monthv" onChange="changef(this,<?=$this_y?>)">
        <?
          for($i=1;$i<=12;$i++){
			if($this_m==$i)
             echo "<option selected value=$i>$i</option>";
            else
             echo "<option value=$i>$i</option>";
          }

         ?>
        </select>��</font></td>
    </tr>
    <?if($session_usrstatus=="���߹ζ�") $bgc="bgcolor=\"#800080\"";?>
    <tr>
    <td width="8%" align="center" bordercolor="#C6CE9C" <?=$bgc?>><?if($session_usrstatus=="���߹ζ�"){?><font size=2 color="white">�w�o��</font><?}?></td>
      <td width="10%" align="center" bordercolor="#C6CE9C" bgcolor="#800080"><font size=2 color="white">����</font></td>
      <td width="35%" height="20" align="center" bordercolor="#C6CE9C" bgcolor="#800080">
        <p align="center"><font size=2 color="white">�q�l���D�D</font></td>
      <td width="10%" align="center" bordercolor="#C6CE9C" bgcolor="#800080"><font size=2 color="white">�o���</font></td>
      <td width="10%" align="center" bordercolor="#C6CE9C" bgcolor="#800080"><font size=2 color="white">�o��q</font></td>
      <td width="10%" align="center" bordercolor="#C6CE9C" bgcolor="#800080"><font size=2 color="white">�I�\����</font></td>
      <td width="10%" align="center" bordercolor="#C6CE9C" <?=$bgc?>><font color="#FF0000"></font>      <?if($session_usrstatus=="���߹ζ�") echo"<a href=\"orderlist.php\" target=\"_blank\"><font size=2 color=\"red\">�q�\�W��</font></a>";?></td>
    </tr>
    <tr>
<?
     $days_in_month = date(  "t", mktime(0, 0, 0, $this_m, 1, $this_y));
     $day = date(  "w", mktime(0, 0, 0, $this_m, 1, $this_y));
            if ($day == 0 ) $day = 7 ;
            $day = 2-$day ;

            //����1�� �P���X(�Ʀr�A�鬰0)

            while($day <= $days_in_month)
	    {
              for ($j=1; $j<=7; $j++)
              {
	      $checkv="";
                if($j==5 && $day<=$days_in_month && $day>0){
				$publishdate=$this_y."-".$this_m."-".sprintf("%02d",$day);
				$sql=mysql_query("select * from e_paper where publish_date='$publishdate'");
				$rows=Mysql_fetch_array($sql,MYSQL_BOTH);
				if(mysql_num_rows($sql)!=0)
				  if($rows["published"]=='Y') $checkv="checked";
?>
      <td width="8%" align="center" bordercolor="#C6CE9C"><p align="center"><?if($session_usrstatus=="���߹ζ�"){?><?if(mysql_num_rows($sql)!=0) echo "<input name=\"publish\" type=\"checkbox\"".$checkv." onClick=\"javascript:sendcheck('sendcheck',".$rows["no"].")\">";?><?}?></td>
      <?if($rows["published"]=="Y" or $session_usrstatus=="���߹ζ�"){?><td width="10%" align="center" bordercolor="#C6CE9C"><p align="center"><font size=2><?if(mysql_num_rows($sql)!=0) echo $rows["epaper_no"]?></font></td><?}else{ echo "<td></font></td>";}?>
      <td width="35%" height="30" align="center" bordercolor="#C6CE9C"><p align="center"><font size=2>
      <?if($session_usrstatus=="���߹ζ�"){?>
          <a href="../manager/e-paper.php?pd=<?=$publishdate?>&eno=<?=$rows["no"]?>&picchange=1"><?echo ($rows["subject"]!="") ? $rows["subject"]."<a href=\"javascript:delrecord('delete',".$rows["no"].")\"><font size=2 color=\"red\">[�R��]</font></a>" : "�ХZ";?></a></td>
      <?}else{
          if($rows["subject"]!="" and $rows["published"]=="Y")
	    echo $rows["subject"];
          else
	   echo ($publishdate<$nowdate) ? "<font color=\"red\">���X�Z" : "<font color=\"red\">�|���X�Z";
        }?>
      </font></td>
      <td width="10%" align="center" bordercolor="#C6CE9C"><p align="center"><font size=2><?=$publishdate?></font></td>
      <?if($rows["published"]=="Y"){?>
      <td width="10%" align="center" bordercolor="#C6CE9C"><p align="center"><font size=2><?if(mysql_num_rows($sql)!=0) echo $rows["publish_num"]?></font></td>
      <td width="10%" align="center" bordercolor="#C6CE9C"><p align="center"><font size=2><?if(mysql_num_rows($sql)!=0) echo $rows["look_num"]?></font></td>
      <td width="10%" align="center" bordercolor="#C6CE9C"><p align="center"><font size=2><?if(mysql_num_rows($sql)!=0) echo "<a href=\"e-paper.php?dba=look&eno=".$rows["no"]."\">�[��/�U��";?></a></font>
      </td>
<?
      }else{
        echo "<td width=10%></td><td width=10%></td><td width=10%></td>";
      }
                }
                $day++;
              }
              echo "</tr>";
         }
?>
  </table>
  </center>
</div>

</body>

</html>
