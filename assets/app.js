(function(){
var d=document,$=function(s){return d.querySelector(s)};
var nb=$('#navbtn'),sc=$('#scrim');
if(nb)nb.onclick=function(){d.body.classList.toggle('nav-open')};
if(sc)sc.onclick=function(){d.body.classList.remove('nav-open')};
var g=$('#goog');if(g)g.onclick=function(){$('#gnote').hidden=false};
var mb=$('#mailbtn');
if(mb){var f=$('#mailform'),m=$('#mode'),sw=$('#swap'),sb=$('#submitbtn');
 function set(x){m.value=x;d.body.classList.toggle('mode-new',x==='new');sb.textContent=x==='new'?'Create account':'Sign in';sw.textContent=x==='new'?'Have an account? Sign in':'New here? Create an account'}
 set(window.AUTH_MODE||'in');
 mb.onclick=function(){f.classList.toggle('open')};
 sw.onclick=function(e){e.preventDefault();set(m.value==='new'?'in':'new')};}
var b=$('#bm');
if(b)b.onclick=function(){var fd=new FormData();fd.append('item_id',b.dataset.id);fd.append('csrf',b.dataset.t);
 fetch('bookmark.php',{method:'POST',body:fd}).then(function(r){if(r.status===401){location.href='login.php?next='+encodeURIComponent(location.pathname.split('/').pop()+location.search);return null}return r.json()})
 .then(function(j){if(!j)return;b.classList.toggle('on',j.on);b.querySelector('span').textContent=j.on?'Saved':'Save';b.classList.remove('pop');void b.offsetWidth;b.classList.add('pop')});};

var a=$('#aud');
if(a){var pl=$('#player'),pp=$('#pp'),sk=$('#pseek'),tm=$('#ptime'),sp=$('#pspeed'),sps=[1,1.25,1.5,2,.75],si=0,cur=null;
function fmt(s){s=Math.floor(s||0);return Math.floor(s/60)+':'+('0'+s%60).slice(-2)}
function sync(){d.querySelectorAll('.playbtn[data-src]').forEach(function(x){x.classList.toggle('on',!a.paused&&x.dataset.src===cur)});pp.classList.toggle('on',!a.paused)}
d.querySelectorAll('.playbtn[data-src]').forEach(function(b){b.onclick=function(){if(cur===b.dataset.src){a.paused?a.play():a.pause()}else{cur=b.dataset.src;a.src=cur;a.playbackRate=sps[si];a.play();$('#ptitle').textContent=b.dataset.title;pl.hidden=false}}});
pp.onclick=function(){a.paused?a.play():a.pause()};
a.onplay=a.onpause=a.onended=sync;
a.ontimeupdate=function(){if(a.duration)sk.value=a.currentTime/a.duration*100;tm.textContent=fmt(a.currentTime)+' / '+fmt(a.duration)};
sk.oninput=function(){if(a.duration)a.currentTime=sk.value/100*a.duration};
sp.onclick=function(){si=(si+1)%sps.length;a.playbackRate=sps[si];sp.innerHTML=sps[si]+'&times;'};
$('#pclose').onclick=function(){a.pause();pl.hidden=true;cur=null;sync()};}
var vm=$('#vm');
if(vm){var vb=$('#vbody');function vc(){vb.innerHTML='';vm.hidden=true}
 d.querySelectorAll('.vcard[data-src]').forEach(function(c){c.onclick=function(){if(a)a.pause();var s=c.dataset.src;vb.innerHTML=c.dataset.file?'<video src="'+s+'" controls autoplay></video>':'<iframe src="'+s+'" allow="autoplay; encrypted-media; fullscreen" allowfullscreen></iframe>';vm.hidden=false}});
 vm.onclick=function(e){if(e.target===vm||e.target.className==='vx')vc()};d.addEventListener('keydown',function(e){if(e.key==='Escape')vc()});}
})();
