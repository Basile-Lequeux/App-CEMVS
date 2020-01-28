<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200127135957 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competitions ADD zone_arbitre_id INT NOT NULL, DROP zone_arbitre');
        $this->addSql('ALTER TABLE competitions ADD CONSTRAINT FK_A7DD463D29A2B610 FOREIGN KEY (zone_arbitre_id) REFERENCES arbitre (id)');
        $this->addSql('CREATE INDEX IDX_A7DD463D29A2B610 ON competitions (zone_arbitre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competitions DROP FOREIGN KEY FK_A7DD463D29A2B610');
        $this->addSql('DROP INDEX IDX_A7DD463D29A2B610 ON competitions');
        $this->addSql('ALTER TABLE competitions ADD zone_arbitre VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP zone_arbitre_id');
    }
}
