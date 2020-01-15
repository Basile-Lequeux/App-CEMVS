<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200115132847 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lecon CHANGE maitre_arme maitre_arme_id INT NOT NULL');
        $this->addSql('ALTER TABLE lecon ADD CONSTRAINT FK_94E6242E35C6C1D6 FOREIGN KEY (maitre_arme_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_94E6242E35C6C1D6 ON lecon (maitre_arme_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lecon DROP FOREIGN KEY FK_94E6242E35C6C1D6');
        $this->addSql('DROP INDEX IDX_94E6242E35C6C1D6 ON lecon');
        $this->addSql('ALTER TABLE lecon CHANGE maitre_arme_id maitre_arme INT NOT NULL');
    }
}
