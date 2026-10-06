<?php require 'layout.php';
$err='';$mode=($_GET['m']??'')=='new'?'new':'in';$next=preg_match('/^[a-z_]+\.php(\?.*)?$/',$_GET['next']??'')?$_GET['next']:'dashboard.php';
if($_SERVER['REQUEST_METHOD']=='POST'){check_csrf();$mode=$_POST['mode']=='new'?'new':'in';$em=strtolower(trim($_POST['email']??''));$pw=$_POST['password']??'';
 if(!filter_var($em,FILTER_VALIDATE_EMAIL))$err='Enter a valid email address.';
 elseif($mode=='in'){$s=db()->prepare('SELECT * FROM users WHERE email=?');$s->execute([$em]);$u=$s->fetch();
  if($u&&password_verify($pw,$u['password'])){session_regenerate_id(true);$_SESSION['user']=['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role']];go($next);}else $err='That email and password do not match.';}
 else{$nm=trim($_POST['name']??'');if($nm==='')$err='Enter your name.';elseif(strlen($pw)<8)$err='Use a password of at least 8 characters.';
  else{try{db()->prepare('INSERT INTO users(name,email,password) VALUES(?,?,?)')->execute([$nm,$em,password_hash($pw,PASSWORD_DEFAULT)]);$id=db()->lastInsertId();session_regenerate_id(true);$_SESSION['user']=['id'=>$id,'name'=>$nm,'email'=>$em,'role'=>'family'];go($next);}catch(PDOException $x){$err='An account with that email already exists. Sign in instead.';}}}}
head('Sign in','authpage');?>
<main class="authwrap"><div class="authcard rise" style="--i:0"><img src="assets/logo.svg" alt="" class="alogo"><h1>Welcome to Left2Right<br>Education Hub</h1><p class="tag">Growing learners. Strengthening families. Building futures.</p>
<button class="btn goog" type="button" id="goog"><svg width="16" height="16" viewBox="0 0 48 48"><path fill="#fff" d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37a13 13 0 1 1 8.4-22.9l6-6A21.5 21.5 0 0 0 24 2a22 22 0 1 0 22 22c0-1.3-.2-2.700-.5-4z"/></svg>Continue with Google</button>
<p class="note" id="gnote" hidden>Google sign-in needs OAuth keys. Add them in config.php, or continue with email.</p>
<button class="btn mail" type="button" id="mailbtn"><?=icon('bell',0)?><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>Continue with Email</button>
<form method="post" id="mailform" class="mailform <?=($err||isset($_GET['m'])||$_POST)?'open':''?>"><div><?=csrf()?><input type="hidden" name="mode" id="mode" value="<?=$mode?>">
<?php if($err):?><p class="err"><?=e($err)?></p><?php endif;?>
<label class="onlynew">Your name<input name="name" value="<?=e($_POST['name']??'')?>" autocomplete="name"></label>
<label>Email<input type="email" name="email" required value="<?=e($_POST['email']??'')?>" autocomplete="email"></label>
<label>Password<input type="password" name="password" required autocomplete="current-password"></label>
<button class="btn solid" type="submit" id="submitbtn">Sign in</button><p class="swap"><a href="#" id="swap">New here? Create an account</a></p></div></form>
<p class="fine2">By continuing you agree to L2R's <a href="terms.php">terms</a> and <a href="privacy.php">privacy practices</a>.</p><a class="ret" href="index.php">Return home</a></div></main>
<script>window.AUTH_MODE='<?=$mode?>';</script><?php foot();
