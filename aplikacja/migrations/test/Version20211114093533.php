<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114093533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP first_name, DROP surrname, DROP hired_at, DROP profile_created_at, DROP last_seen_at, DROP hired_to');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` ADD first_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD surrname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD hired_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD profile_created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD last_seen_at DATETIME NOT NULL, ADD hired_to DATETIME NOT NULL');
    }
}
