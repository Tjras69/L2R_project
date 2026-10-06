<?php require 'layout.php'; head('Home','landing');?>
<?php if(user()):?><a class="acct rise" style="--i:0" href="dashboard.php"><?=e(user()['name'])?></a><?php endif;?>
<main class="land">
<img class="logo rise" style="--i:0" src="assets/L2R_Logo.jpg" alt="Left2Right">
<div class="badge rise" style="--i:1"><?=icon('star',12)?>Left2Right Education Hub</div>
<h1 class="rise" style="--i:2">Where <em class="b">curious minds</em>, <em class="r">warm families</em>,<br>and <em class="g">lifelong growth</em> meet.</h1>
<p class="lead rise" style="--i:3">One account for everything. Apply to L2R, sign in to your dashboard, or simply explore the Growth Hub &mdash; no account needed to read.</p>
<div class="three">
<a class="big y rise" style="--i:4" href="onboarding.php"><span class="bi"><?=icon('bulb',18)?></span><small>Apply</small><h2>Start the Discovery Journey</h2><p>Tell us your story. Save your answers with a free account at the very end &mdash; one account for parents and students.</p><span class="go">Begin the journey <?=icon('arrow',12)?></span></a>
<a class="big bl rise" style="--i:5" href="<?=user()?'dashboard.php':'login.php'?>"><span class="bi"><?=icon('signin',18)?></span><small>Sign in</small><h2>Return to your dashboard</h2><p>Already have an L2R account? Sign in to pick up where you left off, review your Compass, and tend your Living Tree.</p><span class="go"><?=user()?'Open dashboard':'Sign in'?> <?=icon('arrow',12)?></span></a>
<a class="big gr rise" style="--i:6" href="hub.php"><span class="bi"><?=icon('sprout',18)?></span><small>Explore</small><h2>Open the Growth Hub</h2><p>Browse articles, podcasts and public resources freely &mdash; no login required. Create an account later for bookmarks and personalized features.</p><span class="go">Explore the Hub <?=icon('arrow',12)?></span></a>
</div>
<div class="pills">
<a class="pill rise" style="--i:7" href="hub.php?s=articles"><span class="pi" style="background:#dfe8fa;color:#2f6fe0"><?=icon('book',14)?></span>Read articles<?=icon('arrow',12)?></a>
<a class="pill rise" style="--i:8" href="hub.php?s=podcasts"><span class="pi" style="background:#fbe6bd;color:#c08a1e"><?=icon('headphones',14)?></span>Listen to podcasts<?=icon('arrow',12)?></a>
<a class="pill rise" style="--i:9" href="compass.php"><span class="pi" style="background:#f9dede;color:#dc4a4a"><?=icon('compass',14)?></span>About the L2R Compass<?=icon('arrow',12)?></a>
</div>
<p class="fine rise" style="--i:10">Instructors join by invitation only. If you received an invite, open it from your email. <?=icon('bell',11)?></p>
</main><?php foot();
