ALTER TABLE {prefix}blog ADD posted2pingomatic BOOLEAN not null default 0;
update {prefix}blog set posted2pingomatic = 1 where posted2pingomatic = 0;