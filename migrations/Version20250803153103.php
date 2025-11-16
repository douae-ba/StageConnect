<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250803153103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stage ADD encadrant_id INT DEFAULT NULL, ADD professeur_id INT DEFAULT NULL, DROP encadrant, DROP professeur');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369FEF1BA4 FOREIGN KEY (encadrant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C27C9369FEF1BA4 ON stage (encadrant_id)');
        $this->addSql('CREATE INDEX IDX_C27C9369BAB22EE9 ON stage (professeur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369FEF1BA4');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369BAB22EE9');
        $this->addSql('DROP INDEX IDX_C27C9369FEF1BA4 ON stage');
        $this->addSql('DROP INDEX IDX_C27C9369BAB22EE9 ON stage');
        $this->addSql('ALTER TABLE stage ADD encadrant VARCHAR(100) NOT NULL, ADD professeur VARCHAR(100) NOT NULL, DROP encadrant_id, DROP professeur_id');
    }
}
