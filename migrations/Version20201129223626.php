<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201129223626 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brief (id INT AUTO_INCREMENT NOT NULL, referentiel_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, contexte VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL, liste_livrable LONGTEXT NOT NULL, limit_at DATETIME DEFAULT NULL, description_rapide LONGTEXT NOT NULL, modalite_pedagogique LONGTEXT NOT NULL, critere_performance LONGTEXT NOT NULL, modalite_evaluation VARCHAR(255) NOT NULL, image_exemplaire LONGBLOB DEFAULT NULL, langue VARCHAR(30) NOT NULL, etat VARCHAR(30) NOT NULL, archivage TINYINT(1) NOT NULL, INDEX IDX_1FBB1007805DB139 (referentiel_id), INDEX IDX_1FBB10077E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_niveau (brief_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_1BF05631757FABFF (brief_id), INDEX IDX_1BF05631B3E9C81 (niveau_id), PRIMARY KEY(brief_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_apprenant (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, brief_promo_id INT DEFAULT NULL, statut VARCHAR(50) NOT NULL, INDEX IDX_DD6198EDC5697D6D (apprenant_id), INDEX IDX_DD6198ED3628C869 (brief_promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_promo (id INT AUTO_INCREMENT NOT NULL, brief_id INT DEFAULT NULL, promo_id INT DEFAULT NULL, INDEX IDX_9AC7FC8B757FABFF (brief_id), INDEX IDX_9AC7FC8BD0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, promo_id INT DEFAULT NULL, message LONGTEXT NOT NULL, piece_jointe LONGBLOB DEFAULT NULL, write_at DATETIME NOT NULL, INDEX IDX_659DF2AAA76ED395 (user_id), INDEX IDX_659DF2AAD0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, formateur_id INT DEFAULT NULL, fil_discution_id INT DEFAULT NULL, description LONGTEXT NOT NULL, write_at DATETIME NOT NULL, INDEX IDX_67F068BC155D8F51 (formateur_id), INDEX IDX_67F068BCC85F341A (fil_discution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence_valide (id INT AUTO_INCREMENT NOT NULL, competence_id INT DEFAULT NULL, apprenant_id INT DEFAULT NULL, niveau1 VARCHAR(255) NOT NULL, niveau2 VARCHAR(255) NOT NULL, niveau3 VARCHAR(255) NOT NULL, INDEX IDX_8BB7F7FE15761DAB (competence_id), INDEX IDX_8BB7F7FEC5697D6D (apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_brief_groupe (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, brief_id INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_4C4C1AA47A45358C (groupe_id), INDEX IDX_4C4C1AA4757FABFF (brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fil_discution (id INT AUTO_INCREMENT NOT NULL, app_liv_partiel_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_41858334DCE4A8E1 (app_liv_partiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, create_at DATETIME DEFAULT NULL, statut VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_apprenant (groupe_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_947F95197A45358C (groupe_id), INDEX IDX_947F9519C5697D6D (apprenant_id), PRIMARY KEY(groupe_id, apprenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_formateur (groupe_id INT NOT NULL, formateur_id INT NOT NULL, INDEX IDX_BDE2AD787A45358C (groupe_id), INDEX IDX_BDE2AD78155D8F51 (formateur_id), PRIMARY KEY(groupe_id, formateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_attendu (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_attendu_brief (livrable_attendu_id INT NOT NULL, brief_id INT NOT NULL, INDEX IDX_778854ED75180ACC (livrable_attendu_id), INDEX IDX_778854ED757FABFF (brief_id), PRIMARY KEY(livrable_attendu_id, brief_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_attendu_apprenant (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, livrable_attendu_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_BDB84E34C5697D6D (apprenant_id), INDEX IDX_BDB84E3475180ACC (livrable_attendu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel (id INT AUTO_INCREMENT NOT NULL, brief_promo_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, delai_at DATETIME DEFAULT NULL, create_at DATETIME NOT NULL, etat VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, nbre_rendu INT NOT NULL, nbre_corrige INT DEFAULT NULL, INDEX IDX_37F072C53628C869 (brief_promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel_niveau (livrable_partiel_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_4FEB984B519178C4 (livrable_partiel_id), INDEX IDX_4FEB984BB3E9C81 (niveau_id), PRIMARY KEY(livrable_partiel_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel_apprenant (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, livrable_partiel_id INT DEFAULT NULL, etat VARCHAR(50) NOT NULL, delai_at DATETIME DEFAULT NULL, INDEX IDX_5B1B4613C5697D6D (apprenant_id), INDEX IDX_5B1B4613519178C4 (livrable_partiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, referentiel_id INT DEFAULT NULL, langue VARCHAR(30) NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, lieu VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin_pro DATETIME NOT NULL, date_fin_reelle DATETIME NOT NULL, fabrique VARCHAR(50) NOT NULL, status VARCHAR(30) NOT NULL, avatar LONGBLOB DEFAULT NULL, INDEX IDX_C11D7DD1805DB139 (referentiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion_formateur (promotion_id INT NOT NULL, formateur_id INT NOT NULL, INDEX IDX_9C01AF62139DF194 (promotion_id), INDEX IDX_9C01AF62155D8F51 (formateur_id), PRIMARY KEY(promotion_id, formateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, brief_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, piece_jointe VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, INDEX IDX_939F4544757FABFF (brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brief ADD CONSTRAINT FK_1FBB1007805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('ALTER TABLE brief ADD CONSTRAINT FK_1FBB10077E3C61F9 FOREIGN KEY (owner_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE brief_niveau ADD CONSTRAINT FK_1BF05631757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_niveau ADD CONSTRAINT FK_1BF05631B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_apprenant ADD CONSTRAINT FK_DD6198EDC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE brief_apprenant ADD CONSTRAINT FK_DD6198ED3628C869 FOREIGN KEY (brief_promo_id) REFERENCES brief_promo (id)');
        $this->addSql('ALTER TABLE brief_promo ADD CONSTRAINT FK_9AC7FC8B757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE brief_promo ADD CONSTRAINT FK_9AC7FC8BD0C07AFF FOREIGN KEY (promo_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAD0C07AFF FOREIGN KEY (promo_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC85F341A FOREIGN KEY (fil_discution_id) REFERENCES fil_discution (id)');
        $this->addSql('ALTER TABLE competence_valide ADD CONSTRAINT FK_8BB7F7FE15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE competence_valide ADD CONSTRAINT FK_8BB7F7FEC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE etat_brief_groupe ADD CONSTRAINT FK_4C4C1AA47A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE etat_brief_groupe ADD CONSTRAINT FK_4C4C1AA4757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE fil_discution ADD CONSTRAINT FK_41858334DCE4A8E1 FOREIGN KEY (app_liv_partiel_id) REFERENCES livrable_partiel_apprenant (id)');
        $this->addSql('ALTER TABLE groupe_apprenant ADD CONSTRAINT FK_947F95197A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_apprenant ADD CONSTRAINT FK_947F9519C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_formateur ADD CONSTRAINT FK_BDE2AD787A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_formateur ADD CONSTRAINT FK_BDE2AD78155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_attendu_brief ADD CONSTRAINT FK_778854ED75180ACC FOREIGN KEY (livrable_attendu_id) REFERENCES livrable_attendu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_attendu_brief ADD CONSTRAINT FK_778854ED757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_attendu_apprenant ADD CONSTRAINT FK_BDB84E34C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE livrable_attendu_apprenant ADD CONSTRAINT FK_BDB84E3475180ACC FOREIGN KEY (livrable_attendu_id) REFERENCES livrable_attendu (id)');
        $this->addSql('ALTER TABLE livrable_partiel ADD CONSTRAINT FK_37F072C53628C869 FOREIGN KEY (brief_promo_id) REFERENCES brief_promo (id)');
        $this->addSql('ALTER TABLE livrable_partiel_niveau ADD CONSTRAINT FK_4FEB984B519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_niveau ADD CONSTRAINT FK_4FEB984BB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_apprenant ADD CONSTRAINT FK_5B1B4613C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE livrable_partiel_apprenant ADD CONSTRAINT FK_5B1B4613519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('ALTER TABLE promotion_formateur ADD CONSTRAINT FK_9C01AF62139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_formateur ADD CONSTRAINT FK_9C01AF62155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief_niveau DROP FOREIGN KEY FK_1BF05631757FABFF');
        $this->addSql('ALTER TABLE brief_promo DROP FOREIGN KEY FK_9AC7FC8B757FABFF');
        $this->addSql('ALTER TABLE etat_brief_groupe DROP FOREIGN KEY FK_4C4C1AA4757FABFF');
        $this->addSql('ALTER TABLE livrable_attendu_brief DROP FOREIGN KEY FK_778854ED757FABFF');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544757FABFF');
        $this->addSql('ALTER TABLE brief_apprenant DROP FOREIGN KEY FK_DD6198ED3628C869');
        $this->addSql('ALTER TABLE livrable_partiel DROP FOREIGN KEY FK_37F072C53628C869');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC85F341A');
        $this->addSql('ALTER TABLE etat_brief_groupe DROP FOREIGN KEY FK_4C4C1AA47A45358C');
        $this->addSql('ALTER TABLE groupe_apprenant DROP FOREIGN KEY FK_947F95197A45358C');
        $this->addSql('ALTER TABLE groupe_formateur DROP FOREIGN KEY FK_BDE2AD787A45358C');
        $this->addSql('ALTER TABLE livrable_attendu_brief DROP FOREIGN KEY FK_778854ED75180ACC');
        $this->addSql('ALTER TABLE livrable_attendu_apprenant DROP FOREIGN KEY FK_BDB84E3475180ACC');
        $this->addSql('ALTER TABLE livrable_partiel_niveau DROP FOREIGN KEY FK_4FEB984B519178C4');
        $this->addSql('ALTER TABLE livrable_partiel_apprenant DROP FOREIGN KEY FK_5B1B4613519178C4');
        $this->addSql('ALTER TABLE fil_discution DROP FOREIGN KEY FK_41858334DCE4A8E1');
        $this->addSql('ALTER TABLE brief_promo DROP FOREIGN KEY FK_9AC7FC8BD0C07AFF');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAD0C07AFF');
        $this->addSql('ALTER TABLE promotion_formateur DROP FOREIGN KEY FK_9C01AF62139DF194');
        $this->addSql('DROP TABLE brief');
        $this->addSql('DROP TABLE brief_niveau');
        $this->addSql('DROP TABLE brief_apprenant');
        $this->addSql('DROP TABLE brief_promo');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE competence_valide');
        $this->addSql('DROP TABLE etat_brief_groupe');
        $this->addSql('DROP TABLE fil_discution');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_apprenant');
        $this->addSql('DROP TABLE groupe_formateur');
        $this->addSql('DROP TABLE livrable_attendu');
        $this->addSql('DROP TABLE livrable_attendu_brief');
        $this->addSql('DROP TABLE livrable_attendu_apprenant');
        $this->addSql('DROP TABLE livrable_partiel');
        $this->addSql('DROP TABLE livrable_partiel_niveau');
        $this->addSql('DROP TABLE livrable_partiel_apprenant');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE promotion_formateur');
        $this->addSql('DROP TABLE ressource');
    }
}
