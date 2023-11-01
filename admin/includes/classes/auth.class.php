<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Abadon
 */
 
class auth {
    private $lang;
    public $name;
    public $pass;
    public $group;
    private $db;
    function __construct(){
        $this->db = $_SESSION["_registry"]["db"];
        $this->lang =  $_SESSION["_registry"]["lang"]["backend"];
		
    }
    
    /**
    * Login-methode, bei Erfolg Weiterleitung auf die Hauptseite ansonsten Login-Form
    *
    * @param  string  $user Username
    * @param  string  $pass Password
    */
    public function login($user = FALSE, $pass = FALSE, $site_id=false, $is_fe=false){
        $status = $this->check_status($user);
        if ($status) {
                sleep (1);
		$this->print_login_form($status, $is_fe);
        }
        
	else if ($this->check($user, $pass, $site_id))
	{
                $group = $this->db->query_fetch_single("SELECT parent FROM permissions_inheritance WHERE `child` LIKE '$user' AND TYPE = 1 LIMIT 1;");
                $pass2 = $pass2["value"];
		        $_SESSION["_registry"]["user"] = array();
                $_SESSION["_registry"]["user"]['name'] = $user;
                $_SESSION["_registry"]["user"]['pass'] = $pass;
                $_SESSION["_registry"]["user"]['group'] = $group;


                $check_system_user = $this->db->query_fetch("select * from permissions where permission like 'system_user' AND name='".$user."'");
                if(!empty($check_system_user)){

                    $system_user = $this->db->query_fetch("SELECT * FROM user WHERE id=".$check_system_user['value']);
                    $_SESSION["session_user"]=$user;
                    $_SESSION["session_user_id"]=$system_user['id'];
                    $_SESSION["session_display_language"]="de";
                    $_SESSION["session_user_enable_vip"]=$system_user['edit_vip_catalog'];
                    $_SESSION["session_user_enable_auctions"]=$system_user['edit_auctions'];
                    $_SESSION["session_anbieter_id"]=$system_user['anbieter_id'];
                } else {
                    return "Inhre Anmeldaten ist inkorrekt";
                }


        $permissions = new permissions();
                if(!$permissions->hasPermission("backend")){
                    unset($_SESSION["_registry"]["user"]);
                    sleep (1);
                    $this->print_login_form($status, $is_fe);
                }
                else if($is_fe == 1)
                    echo '<script type="text/javascript">window.location="'.$_SESSION["_registry"]["system_config"]["site"]["base_url"].'"; </script>';
                else
                    echo '<script type="text/javascript">window.location="'.$_SESSION["_registry"]["system_config"]["site"]["base_url"].'admin/"; </script>';
	}
	else
	{
                sleep (1);
		$this->print_login_form($this->lang["badpassword"], $is_fe);
	}
        
    }

    public function login_return($user = FALSE, $pass = FALSE){
    if ($this->check($user, $pass, $site_id))
    {
                $group = $this->db->query_fetch_single("SELECT parent FROM permissions_inheritance WHERE `child` LIKE '$user' AND TYPE = 1 LIMIT 1;");
                $_SESSION["_registry"]["user"] = array();
                $_SESSION["_registry"]["user"]['name'] = $user;
                $_SESSION["_registry"]["user"]['pass'] = $pass;
                $_SESSION["_registry"]["user"]['group'] = $group;
				if($group=="Regional Partners"){
				
					$regional_firma_id = $this->db->select("select * from permissions where permission like 'regional_firma' AND name='".$user."'");	
					if($regional_firma_id[0]['value']!=''){
					$_SESSION["_registry"]["user"]["regional_firma"] = $regional_firma_id[0]['value'];
					}
				}
                $permissions = new permissions();
                return TRUE;
    }
    else
    {
                sleep (1);
                return FALSE;
    }
        
    }

    /**
    * Check_Status-methode, überprüft den Status des übergebenen Benutzers
    *
    * @param  string  $user Username
    * @return string  $status bei erfolg FALSE, ansonsten Fehlermeldung
    */    
    public function check_status($user){
        $status = $this->db->query_fetch_single("SELECT value FROM permissions WHERE permission = 'status' AND name = '".$user."';");
        switch ($status){
            case "0": $status = $this->lang["account_deactivated"]; break;
            case "2": $status = $this->lang["account_not_activated"]; break;
            default : $status = FALSE; break;
        }
        return $status;
    }
    
    /**
    * Crypt-Methode, Passwwort verschlüsseln
    *
    * @param  string  $pass Password
    * @return string  $pass crypted password
    */
    public function crypt($pass = FALSE){
        if(!$pass){
            return FALSE;
        }
        else{
            $pass = Bcrypt::hash($pass, 12);
            $pass = $pass["hash"];
            return $pass;
        }
    }

    /**
    * Überprüfung auf korrekten Login
    *
    * @param  string  $user Username
    * @param  string  $pass Password
    * @return bool    TRUE / FALSE
    */
    public function check($user = FALSE, $pass = FALSE, $site_id){
        if(!$user || !$pass){
            return FALSE;
        }
        else{
           
            $pass2 = $this->db->query_fetch_single("SELECT value FROM permissions WHERE `name` LIKE '$user' AND `permission` LIKE 'password' LIMIT 1;");
			 
	if (Bcrypt::check_hash($pass, $pass2) == true)
	{
		if($user == 'dev')
			return true;
		$is_valid = $this->db->select("select value FROM permissions WHERE `name` LIKE '$user' AND `permission` LIKE 'site_id' LIMIT 1");
 
	if($_SESSION["_registry"]["user"]['group']=='admin') {
		return TRUE;
	} else {
		if($is_valid[0]['value'] == $_SESSION['_registry']['site_id'])
			return TRUE;
		else {
			unset($_SESSION['_registry']['site_id']);
			return FALSE;
		}
	}
		
	}
	else
	{
		return FALSE;
	}
        }
    }
    
    /**
    * Gibt dias Loginformular aus
    *
    * @param  string  $message Nachricht die über der Form erscheint
    */
    public function print_login_form($message= "", $is_fe=false){
        //echo $this->crypt("ub140299");
	        if(!$is_fe)
			$logo = '<img src="/images/svg/header_logo.svg" />';
            else
                $logo = '';

            if($message){
                ?>
                <h1 class="text-center login-title"><?php echo $message;?></h1>
<?php
            }
        if(!$is_fe) {
            echo '
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
           
            <div class="account-wall">
               ' . $logo . '
                <form class="form-signin" id="login" method="post">
                <input type="text" id="user" name="user"   class="form-control" placeholder="' . $this->lang["username"] . '" required autofocus style="margin-bottom:10px">
                <input type="password" id="pass" name="pass" class="form-control" placeholder="' . $this->lang["password"] . '" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                   Login</button>
                  <input type="hidden" name="login" value="login">
                </form>
            </div>
			<div id="zeit" style="text-align:right;"></div>
                <div id="support" style="text-align:right;font-size:10px">Support: <a href="mailto:support@telenorma.de">support@telenorma.de</a></div>
        </div>
    </div>
</div>
		 <script type="text/javascript">form_submit("login")</script>
		
		 
             ';
        }
    }    
}

?>
