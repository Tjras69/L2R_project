<?php
require_once __DIR__.'/config.php';
  function icon($n,$s=16){$s=round($s*4/3);static $I=[
  'home'=>'<path d="M3 11l9-8 9 8v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"/>',
  'compass'=>'<circle cx="12" cy="12" r="10"/><path d="M16 8l-2 6-6 2 2-6z"/>',
  'star'=>'<path d="M12 3l2 6 6 2-6 2-2 6-2-6-6-2 6-2z"/>',
  'book'=>'<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5z"/>',
  'headphones'=>'<path d="M3 14v-2a9 9 0 0 1 18 0v2M21 15a2 2 0 0 1-2 2h-1v-5h3zM3 15a2 2 0 0 0 2 2h1v-5H3z"/>',
  'video'=>'<rect x="2" y="6" width="13" height="12" rx="2"/><path d="M15 10l6-3v10l-6-3z"/>',
  'download'=>'<path d="M12 3v12m0 0l-4-4m4 4l4-4M4 21h16"/>',
  'tag'=>'<path d="M20 12l-8 8-9-9V3h8z"/><circle cx="7.5" cy="7.5" r="1"/>',
  'search'=>'<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>',
  'bookmark'=>'<path d="M6 3h12v18l-6-4-6 4z"/>',
  'arrow'=>'<path d="M5 12h14M13 6l6 6-6 6"/>',
  'logout'=>'<path d="M9 21H5V3h4M16 17l5-5-5-5M21 12H9"/>',
  'bulb'=>'<path d="M9 18h6M10 22h4M12 2a7 7 0 0 0-4 12.7c.6.5 1 1.3 1 2.3h6c0-1 .4-1.8 1-2.3A7 7 0 0 0 12 2z"/>',
  'signin'=>'<path d="M15 3h4v18h-4M10 17l5-5-5-5M15 12H3"/>',
  'sprout'=>'<path d="M12 22v-9M12 13c0-4 3-6 7-6 0 4-3 6-7 6zM12 15c0-3-2-5-6-5 0 3 2 5 6 5z"/>',
  'clock'=>'<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
  'panel'=>'<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M9 4v16"/>',
  'play'=>'<path d="M7 4l13 8-13 8z"/>','pause'=>'<path d="M7 4v16M17 4v16"/>','bell'=>'<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9M10 21a2 2 0 0 0 4 0"/>'];
return '<svg class="ic" width="'.$s.'" height="'.$s.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">'.($I[$n]??'').'</svg>';}

function head($title,$cls=''){?>
  <!doctype html>
  <html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?=e($title)?> | Left2Right</title>
  <link rel="icon" href="assets/L2R_Logo.jpg"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css"></head><body class="<?=e($cls)?>"><div class="bg"><i></i><i></i><i></i><i></i></div>
<?php }
function foot(){
  echo '    <script src="assets/app.js"></script>
          </body>
        </html>
      ';}

function hub_start($title,$active){
 head($title,'hub');
 $nav=[ ['hub.php?s=featured','star','Featured','featured'],
        ['hub.php?s=articles','book','Articles','articles'],
        ['hub.php?s=podcasts','headphones','Podcasts','podcasts'],
        ['hub.php?s=videos','video','Videos','videos'],
        ['hub.php?s=downloads','download','Downloads','downloads'],
        ['hub.php?s=categories','tag','Categories','categories'],
        ['hub.php?s=search','search','Search','search'],
        ['hub.php?s=bookmarks','bookmark','Bookmarks','bookmarks']];
 ?>
 <div class="shell">
    <aside class="side" id="side">
      <a class="brand" href="index.php">
        <img src="assets/L2R_Logo.jpg" alt="">
        <span>
          <small>L2R</small>
          <b>Education Hub</b>
        </span>
      </a>
      <div class="navl">Navigate</div>
      <a class="ni <?=$active=='home'?'on':''?>" href="index.php"><?=icon('home')?>Home</a>
      <a class="ni <?=$active=='compass'?'on':''?>" href="compass.php"><?=icon('compass')?>L2R Compass</a>
      <div class="navg"><?=icon('sprout',12)?>Family Growth Hub</div>
      
      <?php foreach($nav as $n):?>
          <a class="ni <?=$active==$n[3]?'on':''?>" href="<?=$n[0]?>">
            <?=icon($n[1])?><?=$n[2]?>
          </a>
        <?php endforeach;?>
        <div class="sidefoot">
          <?php if(user()):?>
            <small><?=e(user()['email'])?></small>
            <a class="ni" href="dashboard.php"><?=icon('compass')?>Dashboard</a>
            <a class="ni" href="logout.php"><?=icon('logout')?>Sign out</a>
          <?php else:?>
            <a class="ni" href="login.php"><?=icon('signin')?>Sign in</a>
          <?php endif;?>
        </div>
    </aside>
  <div class="scrim" id="scrim"></div>
  <div class="mainc">
    <header class="top">
      <button class="ghost" id="navbtn" aria-label="Toggle menu">
        <?=icon('panel')?>
      </button>
      <span class="tt"><?=icon('sprout',14)?>Family Growth Hub</span>
      <span class="hand">a shelf that grows with you</span>
    </header>
    <main class="wrap rise" style="--i:0">
<?php }
function hub_end(){
  echo '</main>
        </div>
        </div>
        <div class="player" id="player" hidden>
          <button class="playbtn sm" id="pp" aria-label="Play or pause">
          <span class="pl">'.icon('play',16).'</span><span class="pa">'.icon('pause',16).'
          </span>
          </button><div class="pinfo"><b id="ptitle"></b><input type="range" id="pseek" min="0" max="100" step="0.1" value="0" aria-label="Seek">
        </div>
        <span id="ptime" class="ptime">0:00
        </span><button class="pbtn" id="pspeed">1&times;</button>
        <button class="pbtn" id="pclose">Close</button>
        <audio id="aud" preload="none"></audio>
        </div>
        <div class="vmodal" id="vm" hidden>
          <div class="vbox">
            <button class="vx" aria-label="Close">&times;</button>
            <div id="vbody">
          </div>
        </div>
        </div>';
        foot();}

        function thumb($it,$cls='thumb'){
 $g=['article'=>'#cfe3d3,#9cc7a6','podcast'=>'#f6dba0,#eab76a','video'=>'#cddcf6,#8fb1ec','download'=>'#f3cfcf,#e49b9b'][$it['type']];
 $ic=['article'=>'book','podcast'=>'headphones','video'=>'video','download'=>'download'][$it['type']];
 $st=$it['image']?"background-image:url('".e($it['image'])."')":"background:linear-gradient(135deg,$g)";
 return '<div class="'.$cls.'" style="'.$st.'">'.($it['image']?'':icon($ic,34)).'</div>';}

function card($it,$big=false){
 return '<a class="card'.($big?' big':'').'" href="item.php?id='.$it['id'].'">'.thumb($it,$big?'thumb tall':'thumb').'<div class="cb"><span class="chip">'.icon('book',11).e($it['cat']??ucfirst($it['type'])).'</span><h3>'.e($it['title']).'</h3><p>'.e($it['excerpt']).'</p><div class="meta">'.e($it['author']).'<i></i>'.icon('clock',11).(int)$it['minutes'].' min '.($it['type']=='article'?'read':($it['type']=='download'?'print':'listen')).'</div></div></a>';}

function items($where='1',$p=[],$lim=60){$s=db()->prepare("SELECT i.*,c.name cat FROM items i LEFT JOIN categories c ON c.id=i.category_id WHERE $where ORDER BY i.featured DESC,i.created DESC,i.id DESC LIMIT $lim");$s->execute($p);return $s->fetchAll();}

function embed_url($u,$ap=false){if(preg_match('~(?:youtu\.be/|v=|embed/)([\w-]{11})~',$u,$m))return 'https://www.youtube.com/embed/'.$m[1].'?rel=0'.($ap?'&autoplay=1':'');return $u;}
function is_vfile($u){return (bool)preg_match('~\.(mp4|webm|ogv)$~i',(string)$u);}

function save_upload($k,$ext){
  if(empty($_FILES[$k]['name'])||$_FILES[$k]['error']!==0)
    return null;
  $x=strtolower(pathinfo($_FILES[$k]['name'],PATHINFO_EXTENSION));
  if(!in_array($x,$ext))
    return null;
  if(!is_dir(__DIR__.'/uploads'))
    mkdir(__DIR__.'/uploads',0755,true);
  $n=bin2hex(random_bytes(6)).'.'.$x;
  move_uploaded_file($_FILES[$k]['tmp_name'],__DIR__.'/uploads/'.$n);return 'uploads/'.$n;}

function render_list($t,$rows){
 if($t=='podcast'){
  echo '<div class="eps">';
  foreach($rows as $it){
    $ok=$it['url']?'data-src="'.e($it['url']).'" data-title="'.e($it['title']).'"':'disabled';
  echo '<div class="ep">
          <button class="playbtn" '.$ok.' aria-label="Play '.e($it['title']).'">
          <span class="pl">'.icon('play',18).'</span>
          <span class="pa">'.icon('pause',18).'</span>
          </button>
          <a class="epb" href="item.php?id='.$it['id'].'">
          <b>'.e($it['title']).'</b>
          <span>'.e($it['excerpt']).'</span></a>
          <em>'.($it['url']?(int)$it['minutes'].' min':'Coming soon').'
          </em></div>';}
          echo '</div>';}
 
elseif($t=='video'){
  echo '<div class="vgrid">';
  foreach($rows as $it){
    $f=is_vfile($it['url']);
  echo '<div class="card vcardw">
        <button class="vcard" '.($it['url']?'data-src="'.e($f?$it['url']:embed_url($it['url'],true)).'"'.($f?' data-file="1"':''):'disabled').'>'.thumb($it).($it['url']?
        '<span class="vplay">'.icon('play',24).'</span>':'').
        '</button><a class="cb" style="display:block" href="item.php?id='.$it['id'].'">
        <span class="chip">'.icon('video',11).e($it['cat']??'Video').'</span>
        <h3>'.e($it['title']).
        '</h3><p>'.e($it['excerpt']).
        '</p>
        <div class="meta">'.(int)$it['minutes'].' min</div>
        </a>
        </div>';}echo '
        </div>';}
 else{
    echo '<div class="eps">';
    foreach($rows as $it){
      $x=strtoupper(pathinfo(parse_url((string)
      $it['url'],PHP_URL_PATH)?:'',PATHINFO_EXTENSION))?:'FILE';
    echo '
      <div class="dl">
        <span class="ftype">'.e(substr($x,0,4)).'</span>
        <a class="epb" href="item.php?id='.$it['id'].'">
          <b>'.e($it['title']).'</b>
          <span>'.e($it['excerpt']).(isset($it['downloads'])&&$it['downloads']>0?' &middot; '.(int)$it['downloads'].' downloads':'').'</span>
        </a>'
        .($it['url']?'
        <a class="btn solid sm" href="download.php?id='.$it['id'].'">'.icon('download',14).'Download</a>'
        :'<em>Coming soon</em>').
        '</div>';}echo '</div>';
  }
}
