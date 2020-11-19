<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201119052315 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profil_sortie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, archivage TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenant CHANGE statut statut TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE profil CHANGE archivage archivage TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE archivage archivage TINYINT(1) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profil_sortie');
        $this->addSql('ALTER TABLE apprenant CHANGE statut statut TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE profil CHANGE archivage archivage TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE archivage archivage TINYINT(1) NOT NULL');
    }
}
