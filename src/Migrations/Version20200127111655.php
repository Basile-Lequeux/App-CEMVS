<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200127111655 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competitions ADD categorie_age_id INT NOT NULL, DROP categorie_age');
        $this->addSql('ALTER TABLE competitions ADD CONSTRAINT FK_A7DD463D4AA6672B FOREIGN KEY (categorie_age_id) REFERENCES categorie_age (id)');
        $this->addSql('CREATE INDEX IDX_A7DD463D4AA6672B ON competitions (categorie_age_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competitions DROP FOREIGN KEY FK_A7DD463D4AA6672B');
        $this->addSql('DROP INDEX IDX_A7DD463D4AA6672B ON competitions');
        $this->addSql('ALTER TABLE competitions ADD categorie_age VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP categorie_age_id');
    }
}
