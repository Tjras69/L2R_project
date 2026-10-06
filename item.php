<?php require 'layout.php';$r=items('i.id=?',[(int)($_GET['id']??0)],1);if(!$r){http_response_code(404);hub_start('Not found','featured');echo '<div class="empty"><p>That resource could not be found.</p><a class="btn solid sm" href="hub.php">Back to the Hub</a></div>';hub_end();exit;}
$it=$r[0];$on=false;if(user()){$q=db()->prepare('SELECT 1 FROM bookmarks WHERE user_id=? AND item_id=?');$q->execute([user()['id'],$it['id']]);$on=(bool)$q->fetch();}
hub_start($it['title'],$it['type'].'s');?>
<p><a class="back" href="hub.php?s=<?=$it['type']?>s">Back to <?=$it['type']?>s</a></p>
<?=thumb($it,'thumb hero')?>
<div class="art"><span class="chip"><?=icon('tag',11)?><?=e($it['cat']?:ucfirst($it['type']))?></span><h1 class="h"><?=e($it['title'])?></h1>
<div class="meta big"><?=e($it['author'])?><i></i><?=icon('clock',12)?><?=(int)$it['minutes']?> min<i></i><?=date('M j, Y',strtotime($it['created']))?>
<button class="bm <?=$on?'on':''?>" id="bm" data-id="<?=$it['id']?>" data-t="<?=$_SESSION['csrf']??(csrf()&&0?'':$_SESSION['csrf'])?>"><?=icon('bookmark',15)?><span><?=$on?'Saved':'Save'?></span></button></div>
<?php if($it['type']=='video'&&$it['url']):?><?php if(is_vfile($it['url'])):?><video class="vfile" controls src="<?=e($it['url'])?>"></video><?php else:?><div class="embed"><iframe src="<?=e(embed_url($it['url']))?>" allowfullscreen loading="lazy"></iframe></div><?php endif;?>
<?php elseif($it['type']=='podcast'&&$it['url']):?><audio controls src="<?=e($it['url'])?>" style="width:100%;margin:14px 0"></audio><?php endif;?>
<div class="body"><?php foreach(preg_split('/\n{2,}/',$it['body']) as $para)echo '<p>'.nl2br(e($para)).'</p>';?></div>
<?php if($it['type']=='download'):?><?php if($it['url']):?><a class="btn solid" href="download.php?id=<?=$it['id']?>"><?=icon('download',15)?>Download</a><?php else:?><p class="note">The file for this download has not been added yet.</p><?php endif;endif;?></div>
<?php hub_end();
