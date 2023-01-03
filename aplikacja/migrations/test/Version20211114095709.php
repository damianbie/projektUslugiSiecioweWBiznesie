<?php

declare(strict_types=1);
namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114095709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD worker_id INT');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6496B20BA36 ON user (worker_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6496B20BA36');
        $this->addSql('DROP INDEX UNIQ_8D93D6496B20BA36 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP worker_id');
    }
}
