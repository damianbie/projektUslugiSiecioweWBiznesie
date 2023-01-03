<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114180346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE serivce (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price_netto DOUBLE PRECISION NOT NULL, tax DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serivce_worker (serivce_id INT NOT NULL, worker_id INT NOT NULL, INDEX IDX_4ADE503C8E4AF58F (serivce_id), INDEX IDX_4ADE503C6B20BA36 (worker_id), PRIMARY KEY(serivce_id, worker_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE serivce_worker ADD CONSTRAINT FK_4ADE503C8E4AF58F FOREIGN KEY (serivce_id) REFERENCES serivce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serivce_worker ADD CONSTRAINT FK_4ADE503C6B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serivce_worker DROP FOREIGN KEY FK_4ADE503C8E4AF58F');
        $this->addSql('DROP TABLE serivce');
        $this->addSql('DROP TABLE serivce_worker');
    }
}
