<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250804100744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE espacepartage ADD ajoutee_par_id INT NOT NULL, ADD destinataire_id INT DEFAULT NULL, DROP ajoutee_par');
        $this->addSql('ALTER TABLE espacepartage ADD CONSTRAINT FK_646013D872F057A9 FOREIGN KEY (ajoutee_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE espacepartage ADD CONSTRAINT FK_646013D8A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_646013D872F057A9 ON espacepartage (ajoutee_par_id)');
        $this->addSql('CREATE INDEX IDX_646013D8A4F84F6E ON espacepartage (destinataire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE espacepartage DROP FOREIGN KEY FK_646013D872F057A9');
        $this->addSql('ALTER TABLE espacepartage DROP FOREIGN KEY FK_646013D8A4F84F6E');
        $this->addSql('DROP INDEX IDX_646013D872F057A9 ON espacepartage');
        $this->addSql('DROP INDEX IDX_646013D8A4F84F6E ON espacepartage');
        $this->addSql('ALTER TABLE espacepartage ADD ajoutee_par VARCHAR(255) NOT NULL, DROP ajoutee_par_id, DROP destinataire_id');
    }
}
