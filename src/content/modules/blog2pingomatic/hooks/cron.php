<?php
if (containsModule ( null, "blog" )) {
	if (! function_exists ( "get_requested_pagename" ) and ! is_admin_dir ()) {
		include_once "templating.php";
	}

	if (! function_exists ( "rootDirectory" )) {
		function rootDirectory() {
			$pageURL = 'http';
			if ($_SERVER ["HTTPS"] == "on") {
				$pageURL .= "s";
			}
			$pageURL .= "://";
			$dirname = dirname ( $_SERVER ["REQUEST_URI"] );
			$dirname = str_replace ( "\\", "/", $dirname );
			$dirname = trim ( $dirname, "/" );
			if ($dirname != "") {
				$dirname = "/" . $dirname . "/";
			} else {
				$dirname = "/";
			}
			if ($_SERVER ["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER ["SERVER_NAME"] . ":" . $_SERVER ["SERVER_PORT"] . $dirname;
			} else {
				$pageURL .= $_SERVER ["SERVER_NAME"] . $dirname;
			}
			return $pageURL;
		}
	}
		$query = db_query ( "select id, title, seo_shortname from " . tbname ( "blog" ) . " where entry_enabled = 1 and posted2pingomatic = 0 order by datum limit 2" );
		if (db_num_rows ( $query ) > 0) {
			while ( $row = db_fetch_assoc ( $query ) ) {
				$id = $row ["id"];
				$title = $row ["title"];
				$seo_shortname = $row ["seo_shortname"];

				$link = rootDirectory () . get_requested_pagename () . ".html?single=" . $seo_shortname;

				$post = $title . " " . $link;
				$controller = ControllerRegistry::get("PingomaticController");
				$result = $controller->pingomatic($title, link);
				if($result["status"] == "ok"){
					db_query ( "UPDATE " . tbname ( "blog" ) . " set posted2pingomatic = 1 where id = $id" );
				}
		}
		}
}
?>
