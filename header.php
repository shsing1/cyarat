<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta content="<?php echo $keywords;?>" name="keywords">
<meta content="<?php echo $description;?>" name="description">
<title><?php echo $page_title;?></title>

<!-- favicon 16x16 -->
<link rel="shortcut icon" href="images/default/favicon.ico">
<!-- apple touch icon 57x57 -->
<link rel="apple-touch-icon" href="images/default/apple-touch-icon.png">

<!-- CSS: implied media="all" -->
<link href="css/reset.css" rel="stylesheet" type="text/css">
<link href="css/common.css" rel="stylesheet" type="text/css">
<?php foreach ($css_ext as $v) {?>
<link href="<?php echo $v;?>" rel="stylesheet" type="text/css">
<?php }?>
<link href="css/chh.css" rel="stylesheet" type="text/css">

<!-- IE設定 -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<body>
<h1 class="webname"><?php echo $info['name']?></h1>
<div id="wrapper">