<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105224936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_competence_tag (groupe_competence_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_4E0DECF489034830 (groupe_competence_id), INDEX IDX_4E0DECF4BAD26311 (tag_id), PRIMARY KEY(groupe_competence_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe_competence_tag ADD CONSTRAINT FK_4E0DECF489034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competence_tag ADD CONSTRAINT FK_4E0DECF4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE groupe_competence_groupe_tag');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_competence_groupe_tag (groupe_competence_id INT NOT NULL, groupe_tag_id INT NOT NULL, INDEX IDX_EEB7D50D89034830 (groupe_competence_id), INDEX IDX_EEB7D50DD1EC9F2B (groupe_tag_id), PRIMARY KEY(groupe_competence_id, groupe_tag_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE groupe_competence_groupe_tag ADD CONSTRAINT FK_EEB7D50D89034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competence (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competence_groupe_tag ADD CONSTRAINT FK_EEB7D50DD1EC9F2B FOREIGN KEY (groupe_tag_id) REFERENCES groupe_tag (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE groupe_competence_tag');
    }
}
