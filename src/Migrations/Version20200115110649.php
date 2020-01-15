<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200115110649 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE competitions (id INT AUTO_INCREMENT NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, arme VARCHAR(255) DEFAULT NULL, participants INT NOT NULL, blason VARCHAR(255) DEFAULT NULL, categorie_age VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competitions_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, competition_id INT NOT NULL, place INT DEFAULT NULL, INDEX IDX_536F51C9A76ED395 (user_id), INDEX IDX_536F51C97B39D312 (competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrainement (id INT AUTO_INCREMENT NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrainement_groupe (entrainement_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_D3EB3DE9A15E8FD (entrainement_id), INDEX IDX_D3EB3DE97A45358C (groupe_id), PRIMARY KEY(entrainement_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrainement_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, entrainements_id INT NOT NULL, present TINYINT(1) NOT NULL, INDEX IDX_EB3D3F70A76ED395 (user_id), INDEX IDX_EB3D3F702477266C (entrainements_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecon (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, entrainement_id INT NOT NULL, maitre_arme INT NOT NULL, present TINYINT(1) NOT NULL, informations LONGTEXT DEFAULT NULL, INDEX IDX_94E6242EA76ED395 (user_id), INDEX IDX_94E6242EA15E8FD (entrainement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, groupe_id INT NOT NULL, arme_id INT DEFAULT NULL, arbitre_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, blason VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, categorie_age VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, INDEX IDX_8D93D6497A45358C (groupe_id), INDEX IDX_8D93D64921D9C0A (arme_id), INDEX IDX_8D93D649943A5F0 (arbitre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_arbitre (id INT AUTO_INCREMENT NOT NULL, niveau_arbitre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_arme (id INT AUTO_INCREMENT NOT NULL, arme VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_objectifs (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, objectif VARCHAR(255) NOT NULL, INDEX IDX_760DBE5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competitions_user ADD CONSTRAINT FK_536F51C9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE competitions_user ADD CONSTRAINT FK_536F51C97B39D312 FOREIGN KEY (competition_id) REFERENCES competitions (id)');
        $this->addSql('ALTER TABLE entrainement_groupe ADD CONSTRAINT FK_D3EB3DE9A15E8FD FOREIGN KEY (entrainement_id) REFERENCES entrainement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entrainement_groupe ADD CONSTRAINT FK_D3EB3DE97A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entrainement_user ADD CONSTRAINT FK_EB3D3F70A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE entrainement_user ADD CONSTRAINT FK_EB3D3F702477266C FOREIGN KEY (entrainements_id) REFERENCES entrainement (id)');
        $this->addSql('ALTER TABLE lecon ADD CONSTRAINT FK_94E6242EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lecon ADD CONSTRAINT FK_94E6242EA15E8FD FOREIGN KEY (entrainement_id) REFERENCES entrainement (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64921D9C0A FOREIGN KEY (arme_id) REFERENCES user_arme (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649943A5F0 FOREIGN KEY (arbitre_id) REFERENCES user_arbitre (id)');
        $this->addSql('ALTER TABLE user_objectifs ADD CONSTRAINT FK_760DBE5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competitions_user DROP FOREIGN KEY FK_536F51C97B39D312');
        $this->addSql('ALTER TABLE entrainement_groupe DROP FOREIGN KEY FK_D3EB3DE9A15E8FD');
        $this->addSql('ALTER TABLE entrainement_user DROP FOREIGN KEY FK_EB3D3F702477266C');
        $this->addSql('ALTER TABLE lecon DROP FOREIGN KEY FK_94E6242EA15E8FD');
        $this->addSql('ALTER TABLE entrainement_groupe DROP FOREIGN KEY FK_D3EB3DE97A45358C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497A45358C');
        $this->addSql('ALTER TABLE competitions_user DROP FOREIGN KEY FK_536F51C9A76ED395');
        $this->addSql('ALTER TABLE entrainement_user DROP FOREIGN KEY FK_EB3D3F70A76ED395');
        $this->addSql('ALTER TABLE lecon DROP FOREIGN KEY FK_94E6242EA76ED395');
        $this->addSql('ALTER TABLE user_objectifs DROP FOREIGN KEY FK_760DBE5A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649943A5F0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64921D9C0A');
        $this->addSql('DROP TABLE competitions');
        $this->addSql('DROP TABLE competitions_user');
        $this->addSql('DROP TABLE entrainement');
        $this->addSql('DROP TABLE entrainement_groupe');
        $this->addSql('DROP TABLE entrainement_user');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE lecon');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_arbitre');
        $this->addSql('DROP TABLE user_arme');
        $this->addSql('DROP TABLE user_objectifs');
    }
}
