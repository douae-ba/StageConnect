<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250722144550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD stagiaire_id_id INT NOT NULL, DROP role');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492AA7DFFB FOREIGN KEY (stagiaire_id_id) REFERENCES stage (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6492AA7DFFB ON user (stagiaire_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492AA7DFFB');
        $this->addSql('DROP INDEX IDX_8D93D6492AA7DFFB ON user');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(100) NOT NULL, DROP stagiaire_id_id');
    }
}
