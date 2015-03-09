<?php

use Phinx\Migration\AbstractMigration;

class ViewCimView extends AbstractMigration
{
    public function up()
    {
        $sql = "CREATE VIEW `cim_view` AS 
                select 
                    `cv`.`cim_orszag_id` AS `country_id`,
                    `co`.`nev` AS `country_name`,
                    `co`.`kod` AS `country_code`,
                    `ci`.`cim_iranyitoszam_id` AS `zip_code_id`,
                    `ci`.`cim_varos_id` AS `city_id`,
                    `cv`.`cim_megye_id` AS `county_id`,
                    `ci`.`iranyitoszam` AS `zip_code`,
                    `cv`.`cim_varos_nev` AS `city_name`,
                    `cm`.`cim_megye_nev` AS `county_name` 
                from (((`cim_iranyitoszam` `ci` 
                join `cim_varos` `cv` on((`ci`.`cim_varos_id` = `cv`.`cim_varos_id`))) 
                join `cim_orszag` `co` on((`cv`.`cim_orszag_id` = `co`.`cim_orszag_id`))) 
                join `cim_megye` `cm` on((`cv`.`cim_megye_id` = `cm`.`cim_megye_id`))) 
                order by `cv`.`cim_varos_nev`;";
        $this->execute($sql);
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute("DROP VIEW cim_view;");
    }
}