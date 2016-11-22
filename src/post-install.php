<?php
db_query ( "ALTER TABLE " . tbname ( "blog" ) . " ADD posted2pingomatic BOOLEAN not null default 0" );
db_query ( "UPDATE " . tbname ( "blog" ) . " set posted2pingomatic = 1 where posted2pingomatic = 0" );
