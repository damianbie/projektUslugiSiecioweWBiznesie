<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114120506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE worker ADD work_place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE worker ADD CONSTRAINT FK_9FB2BF62D8132845 FOREIGN KEY (work_place_id) REFERENCES work_place (id)');
        $this->addSql('CREATE INDEX IDX_9FB2BF62D8132845 ON worker (work_place_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE worker DROP FOREIGN KEY FK_9FB2BF62D8132845');
        $this->addSql('DROP INDEX IDX_9FB2BF62D8132845 ON worker');
        $this->addSql('ALTER TABLE worker DROP work_place_id');
    }
}
