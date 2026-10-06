<?php
require __DIR__.'/config.php';
try{
$p=new PDO('mysql:host='.DB_HOST.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$p->exec('CREATE DATABASE IF NOT EXISTS '.DB_NAME.' CHARACTER SET utf8mb4');$p->exec('USE '.DB_NAME);
$p->exec("CREATE TABLE IF NOT EXISTS users(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(120),email VARCHAR(190) UNIQUE,password VARCHAR(255),role ENUM('family','instructor','admin') DEFAULT 'family',created TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
$p->exec("CREATE TABLE IF NOT EXISTS categories(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(80),slug VARCHAR(80) UNIQUE,blurb VARCHAR(255))");
$p->exec("CREATE TABLE IF NOT EXISTS items(id INT AUTO_INCREMENT PRIMARY KEY,type ENUM('article','podcast','video','download') NOT NULL,title VARCHAR(200),excerpt VARCHAR(400),body TEXT,category_id INT NULL,author VARCHAR(80) DEFAULT 'L2R Admin',minutes INT DEFAULT 5,image VARCHAR(400) NULL,url VARCHAR(400) NULL,featured TINYINT DEFAULT 0,created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE SET NULL)");
$p->exec("CREATE TABLE IF NOT EXISTS bookmarks(user_id INT,item_id INT,created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY(user_id,item_id),FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,FOREIGN KEY(item_id) REFERENCES items(id) ON DELETE CASCADE)");
$p->exec("CREATE TABLE IF NOT EXISTS applications(id INT AUTO_INCREMENT PRIMARY KEY,user_id INT,data JSON,created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE)");
$p->exec("CREATE TABLE IF NOT EXISTS invites(id INT AUTO_INCREMENT PRIMARY KEY,email VARCHAR(190),token VARCHAR(64) UNIQUE,used TINYINT DEFAULT 0,created TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
if(!$p->query('SELECT COUNT(*) FROM users')->fetchColumn()){
$p->prepare("INSERT INTO users(name,email,password,role) VALUES('L2R Admin','admin@l2r.local',?, 'admin')")->execute([password_hash('admin123',PASSWORD_DEFAULT)]);
foreach([['Character Development','character','Habits, virtues and the inner life of a learner.'],['Parenting','parenting','Warm, practical help for the home.'],['Learning at Home','learning','Ideas for curious minds of any age.'],['Family Life','family','Rhythms, rest and relationships.']] as $c)$p->prepare('INSERT INTO categories(name,slug,blurb) VALUES(?,?,?)')->execute($c);
$ins=$p->prepare('INSERT INTO items(type,title,excerpt,body,category_id,minutes,url,featured) VALUES(?,?,?,?,?,?,?,?)');
$rows=[
['article','Welcome to Left2Right Edu Growth Hub!',"We're built on NPK. It might confuse you at first and that's exactly the point.","We're built on NPK. It might confuse you at first and that's exactly the point.\n\nA plant needs nitrogen, phosphorus and potassium to thrive, and a learner needs more than one kind of nourishment too. Here you will find articles, podcasts, videos and printable resources that feed the whole child and the whole family.\n\nStart anywhere. Bookmark what helps. Come back as the seasons change.",1,5,null,1],
['article','Raising curious learners at the kitchen table','Small daily questions beat big weekly lessons.',"Curiosity grows when questions are welcome. Try one open question a day at dinner: What surprised you? What would you change? What do you want to know more about?\n\nKeep it light, listen longer than you talk, and write the best questions on a shared board.",3,4,null,0],
['article','Building a family rhythm that bends','Routines should serve you, not the other way around.',"A rhythm is a gentle pattern, not a strict timetable. Pick three anchors for your day (morning start, midday reset, evening wind-down) and let everything else flex around them.",4,6,null,0],
['article','Praise that grows character','Notice effort and choices, not just results.',"Instead of 'You're so smart', try 'You kept going when it got hard.' Specific, honest praise teaches children what to repeat.",1,5,null,0],
['podcast','Growing Together: Episode 1','A first conversation about learning as a family.',"Listen to the first episode of the Growing Together podcast.\n\nAdd your own audio link in the admin panel to play it here.",2,28,null,0],
['podcast','Growing Together: Episode 2','Mealtimes, mornings and meaningful moments.',"Episode two explores the small moments that shape a home.",4,32,null,0],
['video','A tour of the L2R Compass','A short walk through the Discovery Journey.',"Watch a short overview of how the Compass helps your family choose a direction.\n\nPaste a YouTube link in the admin panel to embed it here.",3,6,'https://www.youtube.com/embed/aqz-KE-bpKQ',0],
['download','Weekly family planner (printable)','One page to plan learning, chores and rest.',"A one-page printable planner. Add a file link in the admin panel to enable the download button.",4,1,null,0],
['download','Conversation starters card set','Thirty questions for the dinner table.',"Print, cut and keep these cards near the table.",2,1,null,0]];
foreach($rows as $r)$ins->execute($r);
}
try{$p->exec('ALTER TABLE items ADD COLUMN downloads INT DEFAULT 0');}catch(Throwable $x){}
$p->exec("UPDATE items SET url='uploads/samples/sample-audio.wav' WHERE type='podcast' AND url IS NULL");
$p->exec("UPDATE items SET url='uploads/samples/weekly-planner.html' WHERE type='download' AND url IS NULL AND title LIKE 'Weekly family planner%'");
$p->exec("UPDATE items SET url='uploads/samples/conversation-cards.html' WHERE type='download' AND url IS NULL AND title LIKE 'Conversation starters%'");
echo '<body style="font-family:Georgia,serif;max-width:560px;margin:60px auto"><h2>Left2Right is installed.</h2><p>Admin login: <b>admin@l2r.local</b> / <b>admin123</b> (change it after signing in).</p><p><a href="index.php">Open the site</a></p><p style="color:#a33">Delete install.php when you are done.</p></body>';
}catch(Throwable $x){http_response_code(500);echo '<pre>Install failed: '.e($x->getMessage()).'</pre><p>Check that MySQL is running in LAMPP and the credentials in config.php are right.</p>';}
