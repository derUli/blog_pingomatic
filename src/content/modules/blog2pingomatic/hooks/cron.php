<?php

if (containsModule(null, "blog")) {       
    $query = db_query("select id, title, seo_shortname from " . tbname("blog") . " where entry_enabled = 1 and posted2pingomatic = 0 order by datum limit 2");
    if (db_num_rows($query) > 0) {
        while ($row = db_fetch_assoc($query)) {
            $id = $row ["id"];
            $title = $row ["title"];
            $seo_shortname = $row ["seo_shortname"];

            $link = rootDirectory() . get_slug() . ".html?single=" . $seo_shortname;

            $post = $title . " " . $link;
            $controller = ControllerRegistry::get("PingomaticController");
            $result = $controller->pingomatic($title, $link);
            if ($result ["status"] == "ok") {
                db_query("UPDATE " . tbname("blog") . " set posted2pingomatic = 1 where id = $id");
            }
        }
    }
}
