<?php
session_start();
const DB_HOST='127.0.0.1'; const DB_USER='root'; const DB_PASS=''; const DB_NAME='l2r';
function db(){static $p;if(!$p){$p=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);}return $p;}
function e($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
function user(){return $_SESSION['user']??null;}
function go($u){header('Location: '.$u);exit;}
function require_login(){if(!user())go('login.php?next='.urlencode(basename($_SERVER['REQUEST_URI'])));}
function csrf(){if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(16));return '<input type="hidden" name="csrf" value="'.$_SESSION['csrf'].'">';}
function check_csrf(){if(($_POST['csrf']??'')!==($_SESSION['csrf']??'x')){http_response_code(400);exit('Invalid form token. Go back and try again.');}}
