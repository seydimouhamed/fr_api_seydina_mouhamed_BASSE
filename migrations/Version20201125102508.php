<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201125102508 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE groupe_competence_competence');
        $this->addSql('ALTER TABLE competence ADD groupe_competence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F89034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competence (id)');
        $this->addSql('CREATE INDEX IDX_94D4687F89034830 ON competence (groupe_competence_id)');
        $this->addSql('ALTER TABLE groupe_competence CHANGE descriptif descriptif LONGTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_competence_competence (groupe_competence_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_F64AE85C15761DAB (competence_id), INDEX IDX_F64AE85C89034830 (groupe_competence_id), PRIMARY KEY(groupe_competence_id, competence_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE groupe_competence_competence ADD CONSTRAINT FK_F64AE85C15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competence_competence ADD CONSTRAINT FK_F64AE85C89034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competence (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F89034830');
        $this->addSql('DROP INDEX IDX_94D4687F89034830 ON competence');
        $this->addSql('ALTER TABLE competence DROP groupe_competence_id');
        $this->addSql('ALTER TABLE groupe_competence CHANGE descriptif descriptif LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
