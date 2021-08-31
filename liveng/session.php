<?php
require_once "initServer.php";
require_once "dbmanServer.php";

 class session{  
  var $db;
  var $conf;
  var $sess_path; 
  var $sesId; 
  private static $instance;
  //private static $sin = null;
  function session(){
   $this->conf = initServer::getConf();
   session_name("{$this->conf['session']['name']}");
   //session_cache_expire($this->conf['session']['lifetime']);
   //session_set_cookie_params(0);
   /*if($this->conf['session']['type'] == 'file'){
    if(!is_dir($this->conf['site paths']['hmp'].'/sess'))
    mkdir($this->conf['site paths']['hmp'].'/sess');
   session_save_path($this->conf['site paths']['hmp'].'/sess');
   }
   session_set_save_handler(
    array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy')
    , array(&$this,'gc')
   );*/
   //session_id($this->generateId());
   @session_start();
   //$this->sesId = session_id();         	   
  }   
  
  static function getInstance(){
   if(null === static::$instance){
    static::$instance = new static();
   }
   return static::$instance;
  }
  
  function generateId(){
   return md5(time()+rand());
  }
  
  function open($save_path, $session_name){
  if($this->conf['session']['type'] == 'file'){
   $this->sess_path = $save_path;
  }else{
   $this->db = dbmanServer::connect();
   }
   return true;
  }
  
  function close(){
   $this->db = null;
   return true;
  }
  
  function read(){  
   $id = $this->sesId;
   $ret = "";
   if($this->conf['session']['type'] == 'file'){
    $sess_file = "{$this->sess_path}/sess_$id";
    $ret = @file_get_contents($sess_file);
   }else{
     $qry = "select sess_data from session where session_id = $id";
     $dat = $this->db->getAll($qry);
     $ret = $dat[0]->sess_data;
   }
   return (string) $ret;
  }
  
  function write(){
  $id = $this->sesId;
  $sess_data = serialize($_SESSION);
  $ret = "";
   if($this->conf['session']['type'] == 'file'){
    $sess_file = "{$this->sess_path}/sess_$id";
    $ret = @file_put_contents($sess_file, $sess_data);
   }else{
     $s_id = $this->db->getNextId('session');
     $qry = "insert into session(session_id ,sess_id, sess_data, cr_dtt) values($s_id, $id, $sess_data, sysdate())";
     $ret = $this->db->runDml($qry);
    }
   return $ret;
  }
  
  function destroy(){
  $id = $this->sesId;
   $ret = "";
   if($this->conf['session']['type'] == 'file'){
    $sess_file = "{$this->sess_path}/sess_$id";
    $ret = @unlink($sess_file);
   }else{
     $qry = "delete from session where sess_id = $id";
     $ret = $this->db->runDml($qry);
    }
   return $ret;
  }
  
  function gc($lifetime){   
   if($this->conf['session']['type'] == 'file'){
    foreach(glob("{$this->sess_path}/sess_*") as $sess_file){
    if(filemtime($sess_file)+$lifetime < time())
     @unlink($sess_file);
    } 
   }else{
     $qry = "delete from session";
     $ret = $this->db->runDml($qry);
    }
   return true;
  }
  
  function terminate(){
   $_SESSION = array();
   @session_destroy();
  }
  
  //helper functions
  function setUserId($nam){
   $_SESSION['usid'] = $nam;
  }
  
  function getUserId(){
   return @$_SESSION['usid']; 
  }
  
  //company id session
  function setComapnyId($nam){
   $_SESSION['cname_id'] = $nam;
  }
  
  function getComapnyId(){
   return @$_SESSION['cname_id']; 
  }
  
  
  
  function setFirstName($nam){
   $_SESSION['fname'] = $nam;
  }
  
  function getFirstName(){
   return $_SESSION['fname']; 
  }
  
  function setLastName($nam){
   $_SESSION['lname'] = $nam;
  }
  
  function getLastName(){
   return $_SESSION['lname']; 
  }
  
  function setModules($nam){
   $_SESSION['modules'] = $nam;
  }
  
  function getModules(){
   return $_SESSION['modules']; 
  }    
  
  function set($k,$v){
   $_SESSION[$k] = $v;
  }
  
  function get($k){
   if(isset($_SESSION[$k])){
    return $_SESSION[$k];
   }
   else return false;
  }
  
  function setCounter(){
   if(isset($_SESSION['ucnt']))
    $_SESSION['ucnt']++;
   else
    $_SESSION['ucnt'] = 1;     
  }
  
  function getCounter(){
   return $SESSION['ucnt'];
  }
  
  function isLoggedOn(){
   if(isset($_SESSION['usid']))
    return true;
   else
    return false; 
  }
  
 }
?>
