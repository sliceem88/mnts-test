<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231125182850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO `accounts` (`name`,`email`,`account_id`,`amount`,`currency`,`user_id`)
        VALUES
          ("Klitu Mun","valu.bon@tres.pl","FXP97VWH8DV","14.59","USD",3),
          ("Klitu Mun","valu.bon@tres.pl","EVG82QOS9PR","13.08","EUR",3),
          ("Klitu Mun","valu.bon@tres.pl","YJI44VXW0HW","15.91","GBP",3),
          ("Klitu Mun","valu.bon@tres.pl","NAR77TUJ3ZM","9.10","USD",3),
          ("Klitu Mun","valu.bon@tres.pl","YXV12BIQ3WP","12.43","EUR",3),
          ("Klitu Mun","valu.bon@tres.pl","XME81NNH2JM","13.05","GBP",3),
          ("Klitu Mun","valu.bon@tres.pl","QSV58QJB0SE","15.48","USD",3),
          ("Klitu Mun","valu.bon@tres.pl","WSB81THL7SV","25.21","EUR",3),
          ("Klitu Mun","valu.bon@tres.pl","CNV14TGN9OT","11.40","GBP",3),
          ("Klitu Mun","valu.bon@tres.pl","NDN15EAK4ZQ","22.02","USD",3);');

        $this->addSql('INSERT INTO `accounts` (`name`,`email`,`account_id`,`amount`,`currency`,`user_id`)
        VALUES
          ("Semen Ditua","bit@trepu.fr","MDI75ORX5PX","20.66","USD",1),
          ("Semen Ditua","bit@trepu.fr","WJU29RXR7SK","15.57","EUR",1),
          ("Semen Ditua","bit@trepu.fr","IFK89QCT4BE","20.24","GBP",1),
          ("Semen Ditua","bit@trepu.fr","KOF74QXH8GT","15.25","USD",1),
          ("Semen Ditua","bit@trepu.fr","SZQ71VUQ5ET","10.41","EUR",1),
          ("Semen Ditua","bit@trepu.fr","IVT68NOO1YR","9.26","GBP",1),
          ("Semen Ditua","bit@trepu.fr","GDJ48FEK9VL","12.74","USD",1),
          ("Semen Ditua","bit@trepu.fr","YFL16CMJ0VM","16.02","EUR",1),
          ("Semen Ditua","bit@trepu.fr","UOI54XPG5CB","16.45","GBP",1),
          ("Semen Ditua","bit@trepu.fr","LPV38ZZW8LB","14.84","USD",1);');

        $this->addSql('INSERT INTO `accounts` (`name`,`email`,`account_id`,`amount`,`currency`,`user_id`)
        VALUES
          ("Stre Bondu","klite.sava@trete.de","JYL19PYP7JV","23.43","USD",2),
          ("Stre Bondu","klite.sava@trete.de","BLD14KPC6BF","14.71","EUR",2),
          ("Stre Bondu","klite.sava@trete.de","OVE63MIF2QE","20.27","GBP",2),
          ("Stre Bondu","klite.sava@trete.de","OBI27VJG9GX","17.97","USD",2),
          ("Stre Bondu","klite.sava@trete.de","HCM36VWX1WT","18.36","EUR",2),
          ("Stre Bondu","klite.sava@trete.de","VEH71OSP7CK","20.35","GBP",2),
          ("Stre Bondu","klite.sava@trete.de","XIM07VIE3UM","9.83","USD",2),
          ("Stre Bondu","klite.sava@trete.de","PGW01COG2KJ","19.87","EUR",2),
          ("Stre Bondu","klite.sava@trete.de","MXD80LVF1YR","16.79","GBP",2),
          ("Stre Bondu","klite.sava@trete.de","FWC70VOG4KZ","18.79","USD",2);');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
