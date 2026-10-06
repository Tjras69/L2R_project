<?php require 'config.php';$s=db()->prepare("SELECT * FROM items WHERE id=? AND type='download'");$s->execute([(int)($_GET['id']??0)]);$it=$s->fetch();
if(!$it||!$it['url']){http_response_code(404);exit('File not found.');}
try{db()->prepare('UPDATE items SET downloads=downloads+1 WHERE id=?')->execute([$it['id']]);}catch(Throwable $x){}
if(preg_match('~^https?://~',$it['url']))go($it['url']);
$p=realpath(__DIR__.'/'.$it['url']);$b=realpath(__DIR__.'/uploads');
if(!$p||!$b||strpos($p,$b)!==0||!is_file($p)){http_response_code(404);exit('File not found.');}
header('Content-Type: application/octet-stream');header('Content-Disposition: attachment; filename="'.basename($p).'"');header('Content-Length: '.filesize($p));readfile($p);
