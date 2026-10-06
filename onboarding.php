<?php require 'layout.php';
$P=[1=>['Family basics','Tell us about your household at a high level.',[['household','Family / household name','text',1,'The Garcia Household'],['email','Primary email','email',1,''],['phone','Primary phone','tel',0,''],['size','Household size','number',0,'4']]],
2=>['Your learners','Who will be learning with us?',[['learners','Number of students','number',1,'2'],['ages','Names and ages','textarea',0,'Mia (9), Leo (14)'],['stage','Current schooling','select',1,'',['Homeschool','Public school','Private school','Mixed or not sure']]]],
3=>['Learning goals','What would you like to see grow?',[['goals','Focus areas','checks',0,'',['Character development','Academics','Creativity','Faith and values','Life skills','Family communication']],['goal_note','Anything specific?','textarea',0,'']]],
4=>['Your story','Share a little so we can listen well.',[['story','What does a great year of learning look like for your family?','textarea',1,''],['challenge','What feels hardest right now?','textarea',0,'']]],
5=>['Save your journey','Create a free account to keep your answers and open your dashboard.',[['pname','Your name','text',1,''],['pass','Password (8+ characters)','password',1,'']]]];
$St=[1=>['About you','Tell us a little about yourself. Under 18? Ask a parent or guardian to help.',[['sname','Your first name','text',1,''],['email','Email','email',1,''],['age','Age or grade','text',0,'14, or 9th grade']]],
2=>['What you love','What do you enjoy learning about?',[['interests','Interests','checks',0,'',['Science','Art','Music','Writing','Building things','Sports','Technology','Nature']],['fav','Something you could talk about for hours','textarea',0,'']]],
3=>['Your strengths','Where do you shine, and where do you want to grow?',[['strong','What are you good at?','textarea',1,''],['grow','What would you like to get better at?','textarea',0,'']]],
4=>['Your story','Share a little so we can listen well.',[['story','What would make this year a great one for you?','textarea',1,''],['challenge','What feels hardest right now?','textarea',0,'']]],
5=>$P[5]];
$j=$_GET['j']??'';
if(!in_array($j,['parent','student'])){head('Onboarding','onb');?><header class="obtop"><div class="obrow"><a href="index.php" class="obback"><?=icon('arrow',13)?>Home</a><span class="stepchip">Discovery Journey</span></div><div class="prog"><b style="--w:0%;--from:0%"></b></div></header>
<main class="obmain" style="max-width:760px"><h1 class="h rise" style="--i:0">How would you like to begin?</h1><p class="sub rise" style="--i:1">Choose the path that fits you. Both end with one free account.</p>
<div class="choose"><a class="big y rise" style="--i:2" href="onboarding.php?j=parent"><span class="bi"><?=icon('home',18)?></span><small>Parent journey</small><h2>I'm a parent or guardian</h2><p>Share your family's story and goals.</p><span class="go">Begin <?=icon('arrow',12)?></span></a>
<a class="big gr rise" style="--i:3" href="onboarding.php?j=student"><span class="bi"><?=icon('bulb',18)?></span><small>Student journey</small><h2>I'm a student</h2><p>Tell us what you love and where you want to grow.</p><span class="go">Begin <?=icon('arrow',12)?></span></a></div></main><?php foot();exit;}
if(($_SESSION['obj']??'')!==$j){$_SESSION['ob']=[];$_SESSION['obj']=$j;}
$S=$j=='student'?$St:$P;
$_SESSION['ob']=$_SESSION['ob']??[];$ob=&$_SESSION['ob'];$n=max(1,min(5,(int)($_GET['step']??1)));
for($k=1;$k<$n;$k++)foreach($S[$k][2] as $f)if($f[3]&&empty($ob[$f[0]]))go('onboarding.php?j='.$j.'&step='.$k);
$err='';
if($_SERVER['REQUEST_METHOD']=='POST'){check_csrf();
 foreach($S[$n][2] as $f){$v=$f[2]=='checks'?array_map('strval',(array)($_POST[$f[0]]??[])):trim($_POST[$f[0]]??'');
  if($f[3]&&($v===''||$v===[]))$err='Please fill in the required fields.';elseif($f[2]=='email'&&!filter_var($v,FILTER_VALIDATE_EMAIL))$err='Enter a valid email address.';
  if($f[0]!='pass')$ob[$f[0]]=$v;else $pw=$v;}
 if(!$err&&$n<5)go('onboarding.php?j='.$j.'&step='.($n+1));
 if(!$err&&$n==5){if(strlen($pw)<8)$err='Use a password of at least 8 characters.';else{try{$em=strtolower($ob['email']);db()->prepare('INSERT INTO users(name,email,password) VALUES(?,?,?)')->execute([$ob['pname'],$em,password_hash($pw,PASSWORD_DEFAULT)]);$id=db()->lastInsertId();$d=$ob;$d['journey']=$j;unset($d['pname']);db()->prepare('INSERT INTO applications(user_id,data) VALUES(?,?)')->execute([$id,json_encode($d)]);session_regenerate_id(true);$_SESSION['user']=['id'=>$id,'name'=>$ob['pname'],'email'=>$em,'role'=>'family'];$_SESSION['ob']=[];go('dashboard.php?welcome=1');}catch(PDOException $x){$err='That email already has an account. Sign in instead.';}}}}
head('Discovery Journey','onb');[$t,$sub,$fs]=$S[$n];?>
<header class="obtop"><div class="obrow"><a href="<?=$n>1?'onboarding.php?j='.$j.'&step='.($n-1):'index.php'?>" class="obback"><?=icon('arrow',13)?>Onboarding</a><span class="stepchip"><?=ucfirst($j)?> journey &middot; Step <?=$n?> of 5</span></div><div class="prog"><b style="--w:<?=$n*20?>%;--from:<?=($n-1)*20?>%"></b></div></header>
<main class="obmain"><h1 class="h rise" style="--i:0"><?=$t?></h1><p class="sub rise" style="--i:1"><?=$sub?></p>
<form method="post" class="obcard rise" style="--i:2"><?=csrf()?><?php if($err):?><p class="err"><?=e($err)?></p><?php endif;?>
<?php $row=[];foreach($fs as $f):[$k,$lb,$ty,$rq,$ph]=$f;$v=$ob[$k]??'';$req=$rq?' <span class="req">*</span>':'';
 $half=in_array($k,['email','phone']);if($half&&$k=='email')echo '<div class="two">';
 echo '<label>'.$lb.$req;
 if($ty=='textarea')echo '<textarea name="'.$k.'" rows="3" placeholder="'.e($ph).'">'.e($v).'</textarea>';
 elseif($ty=='select'){echo '<select name="'.$k.'"><option value="">Choose one</option>';foreach($f[5] as $o)echo '<option'.($v==$o?' selected':'').'>'.e($o).'</option>';echo '</select>';}
 elseif($ty=='checks'){echo '<span class="checks">';foreach($f[5] as $o)echo '<span class="ck"><input type="checkbox" name="'.$k.'[]" value="'.e($o).'"'.(in_array($o,(array)$v)?' checked':'').'><i>'.e($o).'</i></span>';echo '</span>';}
 else echo '<input type="'.$ty.'" name="'.$k.'" value="'.($ty=='password'?'':e($v)).'" placeholder="'.e($ph).'"'.($ty=='number'?' min="1"':'').'>';
 echo '</label>';if($half&&$k=='phone')echo '</div>';endforeach;?>
<?php if($n==5):?><p class="note">Your account email will be <b><?=e($ob['email']??'')?></b>.</p><?php endif;?>
<div class="obnav" style="margin-top:22px"><a class="obprev" href="<?=$n>1?'onboarding.php?j='.$j.'&step='.($n-1):'index.php'?>"><?=icon('arrow',13)?>Back</a><button class="btn solid cont"><?=$n==5?'Create account':'Continue'?> <?=icon('arrow',14)?></button></div></form></main><?php foot();
