<?
include("opendata.php");
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
</head>

<body background="./image/backcolor.jpg">
<?
   require("class.tree/class.tree.php3");


   $tree=new Tree("class.tree");

   $tree->set_frame("_top");

   $root=$tree->open_tree("�^���߭���","../index.html","_top");

   $folder1=$tree->add_folder($root,"���ʬݪO","calend.php","mainFrame");

   $folder2=$tree->add_folder($root,"�{�Ѥ���","","");

   //$folder3=$tree->add_folder($root,"������y�I��T","communityframe.html");

   $folder4=$tree->add_folder($root,"������y�귽","","");


   $tree->add_document($root,"������y�I��T","communityframe.html","mainFrame");


   //$folder5=$tree->add_folder($root,"���ϰ��O�p��","/course/all.htm");

   //$tree->add_document($root,"���ϰ��O�p��","/course/all.htm","_blank");


   //$folder6=$tree->add_folder($root,"���y�p�����i","client/proposalbrowse.php");

   //$folder7=$tree->add_folder($root,"��y�Q�װ�","client/discuss/discuss.php");
   $tree->add_document($root,"��y�Q�װ�","client/discuss/discuss.php","mainFrame");

   //$folder8=$tree->add_folder($root,"�����s��","client/linkbrowse.php");

   $tree->add_document($root,"���߹q�l��","client/e-paper.php","mainFrame");

   $tree->add_document($root,"�����s��","client/linkbrowse.php","mainFrame");


   $tree->add_document($folder1,"�̷s����","client/newsbrowse.php?btype=0","mainFrame");

   $tree->add_document($folder1,"���߬��ʮ���","client/newsbrowse.php?btype=1","mainFrame");

   $tree->add_document($folder1,"���Ϭ��ʮ���","client/newsbrowse.php?btype=2","mainFrame");

   $tree->add_document($folder1,"���ʪᵶ","client/activebrowse.php?btype=titbits","mainFrame");


   $tree->add_document($folder2,"����²��","introduct.htm","mainFrame");

   $tree->add_document($folder2,"���ߤu�@���","client/center_teambrowse.php?btype=1","mainFrame");

   $tree->add_document($folder2,"�½�/���ɦѮv","client/center_teambrowse.php?btype=2","mainFrame");


   //$sql=Mysql_query("select * from family_class");
   //$i=1;

   //while($family=Mysql_fetch_array($sql,MYSQL_BOTH)){
   //   $tree->add_document($folder3,$family[1],"client/communitybrowse.php?btype=$family[0]");
   //   if($i==5) break;
   //   $i++;
   // }


   //$tree->add_document($folder4,"���ߪ��y����","client/activebrowse.php?btype=1");

   //$tree->add_document($folder4,"����p������","client/activebrowse.php?btype=3");

   $tree->add_document($folder4,"������y�Ӯ�","client/activebrowse.php?btype=case","mainFrame");

   $tree->add_document($folder4,"���y�ɧU��T","client/proposalbrowse.php","mainFrame");

   $tree->add_document($folder4,"���Ѥ��ɰ�","client/knowledge/knowledge.php","mainFrame");


   //$tree->add_document($folder5,"�ҵ{���i","browse.php?btype=5");

   //$tree->add_document($folder5,"���Ѥ��ɰ�","browse.php?btype=5");



   //$tree->add_document($folder7,"�a�ڥ�y","browse.php?btype=7&discusstype=1");

   //$tree->add_document($folder7,"������y����y","browse.php?btype=7&discusstype=2");

   //$tree->add_document($folder7,"���ϩ~����y","browse.php?btype=7&discusstype=3");

   //$tree->add_document($folder7,"���y���D�k�O�Ը�","browse.php?btype=7&discusstype=4");


   //$tree->add_document($folder8,"���Ϫ��y���ߺ���","client/linkbrowse.php?btype=1");

   //$tree->add_document($folder8,"������Ϻ���","client/linkbrowse.php?btype=3");

   //$tree->add_document($folder8,"�������y����","client/linkbrowse.php?btype=5");


   $tree->close_tree();


?>
<!--
<a href="../index.html" target="_top"><img src="./image/back.gif" border=0 align="center"></a>
!-->

</body>

</html>
