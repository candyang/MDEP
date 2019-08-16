<?
  include("../.././opendata.php");
  $handoutsql=Mysql_query("select * from handout where course_no=$courseno");
  if(Mysql_num_rows($handoutsql)!=0)
    $handoutinfo=Mysql_fetch_array($handoutsql,MYSQL_BOTH);
?>
<html>
<head>
<title>課後講義</title>
</head>
<body background="../../image/底圖52.gif">
<form method="POST" action=".././edit.php?id=8&courseno=<?=$courseno?>" enctype="multipart/form-data">
<div align="center">
  <center>
  <table border="1" width="733" height="258">
    <tr>
      <td width="124" height="18" align="center"></td>
      <td width="198" height="18" align="center">講義一</td>
      <td width="210" height="18" align="center">講義二</td>
      <td width="211" height="18" align="center">講義三</td>
    </tr>
    <tr>
      <td width="124" height="9" align="left">講義名稱</td>
      <td width="198" height="9" align="left"><input type="text" name=handout[1][1] size="27" value="<?=$handoutinfo["handout1_title"]?>"></td>
      <td width="210" height="9" align="left"><input type="text" name=handout[2][1] size="29" value="<?=$handoutinfo["handout2_title"]?>"></td>
      <td width="211" height="9" align="left"><input type="text" name=handout[3][1] size="29" value="<?=$handoutinfo["handout3_title"]?>"></td>
    </tr>
    <tr>
      <td width="124" height="9" align="left">上傳檔案</td>
      <td width="198" height="9" align="left"><input type="file" name=handout1>
      <?if($handoutinfo["handout1_link"]!="") echo "<br><input type=\"checkbox\" name=\"sourcef1\" checked value=\"yes\">"."原始檔案:".$handoutinfo["handout1_link"];?>
      </td>
      <td width="210" height="9" align="left"><input type="file" name=handout2>
      <?if($handoutinfo["handout2_link"]!="") echo "<br><input type=\"checkbox\" name=\"sourcef2\" checked value=\"yes\">"."原始檔案:".$handoutinfo["handout2_link"];?>
      </td>
      <td width="211" height="9" align="left"><input type="file" name=handout3>
      <?if($handoutinfo["handout3_link"]!="") echo "<br><input type=\"checkbox\" name=\"sourcef3\" checked value=\"yes\">"."原始檔案:".$handoutinfo["handout3_link"];?>
      </td>
    </tr>
    <tr>
      <td width="124" height="169" align="center">備註</td>
      <td width="198" height="169" align="center"><textarea rows="8" name=handout[1][2] cols="25"><?=$handoutinfo["handout1_note"]?></textarea></td>
      <td width="210" height="169" align="center"><textarea rows="8" name=handout[2][2] cols="26"><?=$handoutinfo["handout2_note"]?></textarea></td>
      <td width="211" height="169" align="center"><textarea rows="8" name=handout[3][2] cols="26"><?=$handoutinfo["handout3_note"]?></textarea></td>
    </tr>
    <tr>
      <td width="602" height="13" align="center" colspan="4"><input type="submit" value="確定送出" name="submit"><input type="reset" value="重新填寫" name="reset"></td>
    </tr>
  </table>
  </center>
</div>

</form>

</body>

</html>
