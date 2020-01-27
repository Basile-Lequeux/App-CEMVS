<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200127112844 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_categorie_age (user_id INT NOT NULL, categorie_age_id INT NOT NULL, INDEX IDX_61097CE3A76ED395 (user_id), INDEX IDX_61097CE34AA6672B (categorie_age_id), PRIMARY KEY(user_id, categorie_age_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_categorie_age ADD CONSTRAINT FK_61097CE3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_categorie_age ADD CONSTRAINT FK_61097CE34AA6672B FOREIGN KEY (categorie_age_id) REFERENCES categorie_age (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competitions ADD CONSTRAINT FK_A7DD463D4AA6672B FOREIGN KEY (categorie_age_id) REFERENCES categorie_age (id)');
        $this->addSql('CREATE INDEX IDX_A7DD463D4AA6672B ON competitions (categorie_age_id)');
        $this->addSql('ALTER TABLE user DROP categorie_age');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_categorie_age');
        $this->addSql('ALTER TABLE competitions DROP FOREIGN KEY FK_A7DD463D4AA6672B');
        $this->addSql('DROP INDEX IDX_A7DD463D4AA6672B ON competitions');
        $this->addSql('ALTER TABLE user ADD categorie_age VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
