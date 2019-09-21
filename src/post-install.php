<?php
$migrator = new DBMigrator ("module/blog2pingomatic", ModuleHelper::buildModuleRessourcePath ( "blog2pingomatic", "migrations/up" ) );
$migrator->migrate ();