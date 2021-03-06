<?php
	namespace Controllers\admin;
	use MS\MSController;
	use MSGet;
	use MS\Acl;
	class Admin extends MSController{
		function __construct(){
			parent::__construct();
			$this->acl = new Acl();
			$this->acl->setAccess(
				array(
					array(
						"actions" => array("actionIndex"),
						"expression" => true
					),
					array(
						"actions" => array("actionDeneme","actionCikis"),
						"expression" => $this->isLogin(),
						"redirect" => "admin/actionLogin",
						"ip" => "::1"
					),
					array(
						"actions" => array("actionLogin"),
						"expression" => !$this->isLogin(),
						"redirect" => "admin",
						"ip" => "::1"
					),
					array(
						"actions" => array("isLogin"),
						"expression" => false,
						"redirect" => "admin"
					)
				)
			);
		}
		function actionIndex(){
			$giris = @$_SESSION["blogGiris"];
			if(!$giris){
				$this->actionLogin();
			}
			else{
				$this->actionDeneme();
			}
		}
		function actionLogin(){
			$giris = @$_SESSION["blogGiris"];
			if($_POST and !$giris){
				if(@$_POST["kadi"] === "mustafa220" and @$_POST["sifre"] === "mustafa"){
					$_SESSION["blogGiris"] = true;
					$giris = true;
				}
			}
			if($giris){
				header("Location:".$this->site."/admin/actionDeneme");
			}
			$this->view("admin/adminBas",array("title" => "Giriş Yapın !"));
			$this->view("admin/girisPanel");
			$this->view("admin/adminSon");
		}
		function actionDeneme(){
			echo "burasi Deneme action u bunu sadece giris yapanlar ve ip si ::1 olanlar gorebilir";
			echo '<br /><a href="'.$this->site.'/admin/actionCikis">Cikis</a>';
		}
		function isLogin(){
			$giris = @$_SESSION["blogGiris"];
			if($giris){
				return true;
			}
			else{
				return false;
			}
		}
		function actionCikis(){
			$_SESSION["blogGiris"] = false;
			header("Location:".$this->site);
		}
	}
?>