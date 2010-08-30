<html>
<head><title>Gie Hybrid Cipher</title>
<?php
// By Panggi Libersa Jasri Akadol
// root@malcoder.info
// read GPL license 

?>

<style>
<!--
BODY {
	font-family: Tahoma, Verdana, sans-serif;
	font-size: 11px;
	font-weight: normal;
	text-decoration: none;
	color:#FF0000;
	background-color: #000000;
	cursor:crosshair;

}
TABLE {
border: 1px solid #cccccc;
font-size: 11px;
}

TD {
FONT-FAMILY: Tahoma, Verdana, sans-serif;
FONT-SIZE: 11px;
}
TEXTAREA {
FONT-FAMILY:  Tahoma, Verdana, sans-serif;
FONT-SIZE: 11px;
background-color : #FFCC00;
color : #000000;
font-weight : normal;
border-color : #333333;
border-top-width: 1px;
border-right-width: 1px;
border-bottom-width: 1px;
border-left-width: 1px;
text-indent : 2px;
}
INPUT, SELECT {
background-color : #FFCC00;
color : #000000;
font-family : Tahoma, Verdana, sans-serif;
font-size : 11px;
font-weight : normal;
border-color : #333333;
border-top-width : 1px;
border-right-width : 1px;
border-bottom-width : 1px;
border-left-width : 1px;
text-indent : 2px;
}

-->
</style>
</head>
<body>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<input type="text" name="kunci" />
<strong> KEY</strong> 
<br /><br />
<textarea name="plain" cols="70" rows="20"></textarea><br /><br />
<input type="submit" value="Encrypt" name="enkrip"/>&nbsp;&nbsp; <input type="submit" value="Decrypt" name="dekrip" />&nbsp;&nbsp; <input type="reset" value="Clear" />
</form>
<?php
//-------AWAL FUNGSI---------------------------------------------------------|
  function encrypt ($string, $key = '')
  {

    $result = '';
    $i = 0;
    while ($i < strlen ($string))
    {
      $char = substr ($string, $i, 1);
      $keychar = substr ($key, $i % strlen ($key) - 1, 1);
      $char = chr (ord ($char) + ord ($keychar));
      $result .= $char;
      ++$i;
    }

    return base64_encode ($result);
  }

  function decrypt ($string, $key = '')
  {

    $result = '';
    $string = base64_decode ($string);
    $i = 0;
    while ($i < strlen ($string))
    {
      $char = substr ($string, $i, 1);
      $keychar = substr ($key, $i % strlen ($key) - 1, 1);
      $char = chr (ord ($char) - ord ($keychar));
      $result .= $char;
      ++$i;
    }

    return $result;
  }
  function xencrypt ($ckey, $string)
  {
    $string = base64_encode ($string);
    $keys = array ();
    $c_key = base64_encode (sha1 (md5 ($ckey)));
    $c_key = substr ($c_key, 0, round (ord ($ckey[0]) / 5));
    $c2_key = base64_encode (md5 (sha1 ($ckey)));
    $last = strlen ($ckey) - 1;
    $c2_key = substr ($c2_key, 1, round (ord ($ckey[$last]) / 7));
    $c3_key = base64_encode (sha1 (md5 ($c_key) . md5 ($c2_key)));
    $mid = round ($last / 2);
    $c3_key = substr ($c3_key, 1, round (ord ($ckey[$mid]) / 9));
    $c_key = $c_key . $c2_key . $c3_key;
    $c_key = base64_encode ($c_key);
    $i = 0;
    while ($i < strlen ($c_key))
    {
      $keys[] = $c_key[$i];
      ++$i;
    }

    $i = 0;
    while ($i < strlen ($string))
    {
      $id = $i % count ($keys);
      $ord = ord ($string[$i]);
      ($ord = $ord OR ord ($keys[$id]));
      ++$id;
      ($ord = $ord AND ord ($keys[$id]));
      ++$id;
      $ord = $ord XOR ord ($keys[$id]);
      ++$id;
      $ord = $ord + ord ($keys[$id]);
      $string[$i] = chr ($ord);
      ++$i;
    }

    return base64_encode ($string);
  }

  function xdecrypt ($ckey, $string)
  {
    $string = base64_decode ($string);
    $keys = array ();
    $c_key = base64_encode (sha1 (md5 ($ckey)));
    $c_key = substr ($c_key, 0, round (ord ($ckey[0]) / 5));
    $c2_key = base64_encode (md5 (sha1 ($ckey)));
    $last = strlen ($ckey) - 1;
    $c2_key = substr ($c2_key, 1, round (ord ($ckey[$last]) / 7));
    $c3_key = base64_encode (sha1 (md5 ($c_key) . md5 ($c2_key)));
    $mid = round ($last / 2);
    $c3_key = substr ($c3_key, 1, round (ord ($ckey[$mid]) / 9));
    $c_key = $c_key . $c2_key . $c3_key;
    $c_key = base64_encode ($c_key);
    $i = 0;
    while ($i < strlen ($c_key))
    {
      $keys[] = $c_key[$i];
      ++$i;
    }

    $i = 0;
    while ($i < strlen ($string))
    {
      $id = $i % count ($keys);
      $ord = ord ($string[$i]);
      $ord = $ord XOR ord ($keys[$id]);
      ++$id;
      ($ord = $ord AND ord ($keys[$id]));
      ++$id;
      ($ord = $ord OR ord ($keys[$id]));
      ++$id;
      $ord = $ord - ord ($keys[$id]);
      $string[$i] = chr ($ord);
      ++$i;
    }

    return base64_decode ($string);
  }

//-------- AKHIR FUNGSI------------------------------------------------------|
?>

<?php
// Kalau Enkrip
if($_POST['enkrip']){
  $kunci    = htmlspecialchars(trim($_POST['kunci']));
  if(!empty($kunci)){
  $plain  = $_POST['plain'];

$acak = encrypt($plain,$kunci);
$encrypted = xencrypt($kunci,$acak);

?>
<textarea name="crypted" cols="70" rows="20" readonly="readonly" wrap="physical"><?php echo htmlspecialchars(trim($encrypted)); ?></textarea>
<?php
}
else { echo "Insert Key..."; }}
?>
<?php
// Kalau Dekrip
if($_POST['dekrip']){
  $kunci    = htmlspecialchars(trim($_POST['kunci']));
  if(!empty($kunci)){
  $plain  = $_POST['plain'];

$balik = xdecrypt($kunci,$plain);
$decrypted = decrypt($balik,$kunci);

?>
<textarea name="dcrypted" cols="70" rows="20" readonly="readonly" wrap="physical"><?php echo htmlspecialchars(trim($decrypted)); ?></textarea>
<?php
}
else { echo "Insert Key..."; }}
?>
</body>
</html>
