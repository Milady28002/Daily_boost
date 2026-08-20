<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260820153721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT fk_68c58ed97e3c61f9');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED97E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT FK_68C58ED97E3C61F9');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT fk_68c58ed97e3c61f9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
