<?php
$page = $_GET['p'];
if (empty($page) || $page < 1) { $page = 1; }
$per_page = 30;
$dir = opendir('albums');
$all = array();
while ($file = readdir($dir)) {
  if (preg_match('/^\.{1,2}$/', $file)) continue;
  $all []= $file;
}
sort($all);
$start = ($page - 1) * $per_page;
$end = $start + $per_page;
$list = array_slice($all, $start, $per_page);
$ppage = $page - 1;
$npage = ($end > count($all)) ? 0 : $page + 1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Ragman Records Archives</title>
  <link rel="stylesheet" type="text/css" media="all" href="/style.css" />
</head>
<body>
<div id="wrap">
  <div id="side">
    <img src="ragman_logo.jpg" />
    <br />
    <h3>CONTACT</h3>
    c/o 
      <a href="http://centipedefarm.com">The Centipede Farm</a>
  </div>
  <div id="header">
    Ragman Records Archives
  </div>
  <div id="content">
    <div class="nav">
      <? if ($ppage != 0) : ?>
        <a href="?p=<?= $ppage ?>"><< Previous</a>
      <? endif ?> |
      <? if ($npage != 0) : ?>
        <a href="?p=<?= $npage ?>">Next >></a>
      <? endif ?>
    </div>
    <div id="albums">
      <table width="100%" border="1">
        <? foreach ($list as $i => $file) : ?>
          <? $base = preg_replace('/\.zip$/', '', $file); ?>
          <? if ($i % 3 == 0) : ?>
            <tr>
          <? endif; ?>
          <td>
            <a href="<?= "albums/$file" ?>">
              <? if (file_exists("covers/$base.jpg")) : ?>
                <? $imgname = "covers/$base.jpg" ?>
              <? else : ?>
                <? $imgname = "covers/default.jpg" ?>
              <? endif ?>
              <? $size = getimagesize($imgname); $width = $size [0]; $height = $size[1]; ?>
              <? if ($height > $width) : ?>
                <img src="<?= $imgname ?>" height="300" alt="<? $base ?>"><br />
              <? else : ?>
                <img src="<?= $imgname ?>" width="300" alt="<?= $base ?>"><br />
              <? endif; ?>
              <?= strtr($base, array('_' => ' ', '-' => ' - ')) ?>
            </a>
          </td>
          <? if (++$col % 3 == 0) : ?>
            </tr>
          <? endif; ?>
        <? endforeach; ?>
      </table>
    </div>
    <div class="nav">
      <? if ($ppage != 0) : ?>
        <a href="?p=<?= $ppage ?>"><< Previous</a>
      <? endif ?> |
      <? if ($npage != 0) : ?>
        <a href="?p=<?= $npage ?>">Next >></a>
      <? endif ?>
    </div>
  </div>
</div>
</body>
</html>
