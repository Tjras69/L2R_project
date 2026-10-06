<?php require 'config.php';header('Content-Type: application/json');
if(!user()){http_response_code(401);exit('{"login":true}');}
check_csrf();$u=user()['id'];$i=(int)($_POST['item_id']??0);
$s=db()->prepare('SELECT 1 FROM bookmarks WHERE user_id=? AND item_id=?');$s->execute([$u,$i]);
if($s->fetch()){db()->prepare('DELETE FROM bookmarks WHERE user_id=? AND item_id=?')->execute([$u,$i]);echo '{"on":false}';}
else{db()->prepare('INSERT INTO bookmarks(user_id,item_id) VALUES(?,?)')->execute([$u,$i]);echo '{"on":true}';}
