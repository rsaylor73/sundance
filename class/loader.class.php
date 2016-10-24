<?php

/* This is a chain class system. The first path of the class are:

loader > users > customers > api > core

*/

include PATH."/class/users.class.php";

class loader extends users {

	public $linkID;
	function __construct($linkID){ $this->linkID = $linkID; }


	/* The load_module function performs the routing of functions */

	public function load_module($module) {

		if (method_exists('loader',$module)) {
			$this->$module();
		} elseif (method_exists('core',$module)) {
			$this->$module();
		} elseif (method_exists('users',$module)) {
			$this->$module();
                } elseif (method_exists('api',$module)) {
                        $this->$module();
		} elseif (method_exists('employees',$module)) {
			$this->$module();
		} else {
			print "<br><font color=red>The $module method does not exist.</font><br>";
			die;
		}
	}

	/* This generates a random password */
	public function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	/* This is used with the page numbers in the admin */
	public function map_numbers($max,$pages) {

		for ($i=0; $i < $pages; $i++) {
			if ($stop == "") {
				$stop = "0";
			}
			if ($i > 0) {
				$stop = $stop + $max;
			}
			$i2 = $i + 1;
			$array[$i2] = $stop;
		}
		return $array;
	}

	/* This is used with the page numbers in the admin */
	public function page_numbers($sql,$url) {
		$max = "20";
		$result = $this->new_mysql($sql);
		$total_records = $result->num_rows;
		$total_records = $total_records / $max;
		$pages = ceil($total_records);

			$page = $_GET['page'];
			if ($page == "") {
				$page = "1";
			}

			$html = "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">";
			$html .= "<button type=\"button\" class=\"btn btn-default\" disabled>Page</button>";
			if ($page == "1") {
				$html .= "<button type=\"button\" class=\"btn btn-primary\" onclick=\"document.location.href='".$url.$page."&stop=0'\">1</button>";
				$array = $this->map_numbers($max,$pages);
				$next = $page + 1;
				$next10 = $page + 10;
				$next100 = $page + 100;

				if ($next < $pages) {
					$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next."&stop=".$array[$next]."'\">&gt;&gt;</button>";
				}

				if ($next10 < $pages) {
					$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next10."&stop=".$array[$next10]."'\">+ 10</button>";
				}

				if ($next100 < $pages) {
					$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next100."&stop=".$array[$next100]."'\">+ 100</button>";
				}

				$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$pages."&stop=".$array[$pages]."'\">$pages</button>";

			} else {
				$array = $this->map_numbers($max,$pages);

				$pre = $page - 1;
				$pre10 = $page - 10;
				$pre100 = $page - 100;
				$next = $page + 1;
				$next10 = $page + 10;
				$next100 = $page + 100;

				$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url."1&stop=0'\">1</button>";

				if ($pre10 > 0) {
					$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$pre10."&stop=$array[$pre10]'\">- 10</button>";
				}

				if ($pre100 > 0) {
					$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$pre100."&stop=$array[$pre100]'\">- 100</button>";
				}

				$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$pre."&stop=$array[$pre]'\">&lt;&lt;</button>";
				
				$html .= "<button type=\"button\" class=\"btn btn-primary\" onclick=\"document.location.href='".$url.$page."&stop=$array[$page]'\">$page</button>";

				if ($next < $pages) {
					$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next."&stop=$array[$next]'\">&gt;&gt;</button>";
				}

				if ($next10 < $pages) {
					$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next10."&stop=$array[$next10]'\">+ 10</button>";
				}

				if ($next100 < $pages) {
					$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next100."&stop=$array[$next100]'\">+ 100</button>";
				}

				$html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$pages."&stop=$array[$pages]'\">$pages</button>";

			}
			$html .= "</div>";
		return $html;	
	}


}
?>
