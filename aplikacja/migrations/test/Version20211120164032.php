<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211120164032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD correspondence_address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455326528F7 FOREIGN KEY (correspondence_address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455326528F7 ON client (correspondence_address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455326528F7');
        $this->addSql('DROP INDEX UNIQ_C7440455326528F7 ON client');
        $this->addSql('ALTER TABLE client DROP correspondence_address_id');
    }
}
