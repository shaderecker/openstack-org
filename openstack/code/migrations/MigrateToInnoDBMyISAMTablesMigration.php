<?php

/**
 * Copyright 2015 Open Infrastructure Foundation
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 **/
final class MigrateToInnoDBMyISAMTablesMigration extends AbstractDBMigrationTask
{
    protected $title = "MigrateToInnoDBMyISAMTablesMigration";

    protected $description = "MigrateToInnoDBMyISAMTablesMigration";

    function doUp()
    {
        global $database;

        $res = DB::query("SELECT TABLE_NAME FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = '{$database}' AND engine = 'myISAM' AND TABLE_NAME NOT LIKE '%_obsolete_%';");

        foreach($res as $table_name)
        {
            DB::query("ALTER TABLE {$table_name['TABLE_NAME']} ENGINE=INNODB;");
        }
    }

    function doDown()
    {
        // TODO: Implement doDown() method.
    }
}