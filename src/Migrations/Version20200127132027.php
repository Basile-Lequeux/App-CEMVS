<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200127132027 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE arbitre (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competitions ADD zone_arbitre VARCHAR(25) NOT NULL');
        $this->addSql('ALTER TABLE user ADD zone_arbitre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64929A2B610 FOREIGN KEY (zone_arbitre_id) REFERENCES arbitre (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64929A2B610 ON user (zone_arbitre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64929A2B610');
        $this->addSql('DROP TABLE arbitre');
        $this->addSql('ALTER TABLE competitions DROP zone_arbitre');
        $this->addSql('DROP INDEX IDX_8D93D64929A2B610 ON user');
        $this->addSql('ALTER TABLE user DROP zone_arbitre_id');
    }
}
