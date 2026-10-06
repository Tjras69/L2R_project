<?php require 'layout.php';
$s=$_GET['s']??'featured';$map=['articles'=>['article','Articles','Read, learn and take it to the kitchen table.'],'podcasts'=>['podcast','Podcasts','Conversations to listen to on the way.'],'videos'=>['video','Videos','Short films for the whole family.'],'downloads'=>['download','Downloads','Printable resources, ready when you are.']];
if(!in_array($s,['featured','categories','search','bookmarks']+array_keys($map)))$s='featured';
if($s=='bookmarks')require_login();
hub_start(ucfirst($s),$s);
if($s=='featured'){$f=items('i.featured=1',[],1)[0]??null;$r=items('1',[],6);?>
<span class="eyebrow"><?=icon('star',12)?>Featured</span><h1 class="h">A library that grows with your family.</h1><p class="sub">Hand-picked articles, podcasts and printable resources to support parents, students and educators across every season of learning.</p>
<?php if($f)echo card($f,true);?><h2 class="h2">Recently added</h2><div class="grid"><?php foreach($r as $it)echo card($it);?></div>
<?php }elseif(isset($map[$s])){[$t,$ti,$su]=$map[$s];$cat=(int)($_GET['c']??0);$w='i.type=?';$p=[$t];if($cat){$w.=' AND i.category_id=?';$p[]=$cat;}$rows=items($w,$p);$cats=db()->query('SELECT * FROM categories')->fetchAll();?>
<h1 class="h"><?=$ti?></h1><p class="sub"><?=$su?></p>
<div class="chips"><a class="fc <?=$cat?'':'on'?>" href="hub.php?s=<?=$s?>">All</a><?php foreach($cats as $c):?><a class="fc <?=$cat==$c['id']?'on':''?>" href="hub.php?s=<?=$s?>&c=<?=$c['id']?>"><?=e($c['name'])?></a><?php endforeach;?></div>
<?php if(!$rows):?><div class="empty"><?=icon('sprout',28)?><p>Nothing here yet. New <?=strtolower($ti)?> are planted often, so check back soon.</p></div><?php else:render_list($t,$rows);endif;
}elseif($s=='categories'){$cats=db()->query('SELECT c.*,COUNT(i.id) n FROM categories c LEFT JOIN items i ON i.category_id=c.id GROUP BY c.id')->fetchAll();$c=(int)($_GET['c']??0);?>
<h1 class="h">Categories</h1><p class="sub">Find resources by what your family is growing right now.</p>
<?php if($c){$rows=items('i.category_id=?',[$c]);echo '<p><a class="back" href="hub.php?s=categories">Back to all categories</a></p>';echo $rows?'<div class="grid">':'<div class="empty"><p>No resources in this category yet.</p></div>';foreach($rows as $it)echo card($it);echo $rows?'</div>':'';}else{?>
<div class="grid"><?php foreach($cats as $k):?><a class="card catc" href="hub.php?s=categories&c=<?=$k['id']?>"><div class="cb"><span class="chip"><?=icon('tag',11)?><?=$k['n']?> resources</span><h3><?=e($k['name'])?></h3><p><?=e($k['blurb'])?></p></div></a><?php endforeach;?></div><?php }
}elseif($s=='search'){$q=trim($_GET['q']??'');?>
<h1 class="h">Search</h1><p class="sub">Search every article, podcast, video and download.</p>
<form class="sbox" method="get"><input type="hidden" name="s" value="search"><?=icon('search',16)?><input name="q" value="<?=e($q)?>" placeholder="Try &ldquo;curiosity&rdquo; or &ldquo;planner&rdquo;" autofocus><button class="btn solid sm">Search</button></form>
<?php if($q!==''){$l='%'.$q.'%';$rows=items('(i.title LIKE ? OR i.excerpt LIKE ? OR i.body LIKE ?)',[$l,$l,$l]);?><p class="count"><?=count($rows)?> result<?=count($rows)==1?'':'s'?> for &ldquo;<?=e($q)?>&rdquo;</p><?php if($rows):?><div class="grid"><?php foreach($rows as $it)echo card($it);?></div><?php else:?><div class="empty"><p>No matches. Try a shorter or different word.</p></div><?php endif;}
}else{$rows=items('i.id IN (SELECT item_id FROM bookmarks WHERE user_id=?)',[user()['id']]);?>
<h1 class="h">Bookmarks</h1><p class="sub">Everything you saved, in one place.</p>
<?php if(!$rows):?><div class="empty"><?=icon('bookmark',28)?><p>You have not saved anything yet. Open any resource and select the bookmark button.</p><a class="btn solid sm" href="hub.php?s=articles">Browse articles</a></div><?php else:?><div class="grid"><?php foreach($rows as $it)echo card($it);?></div><?php endif;}
hub_end();
