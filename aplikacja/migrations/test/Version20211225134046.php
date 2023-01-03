<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211225134046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496B20BA36');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id)');
        $this->addSql('ALTER TABLE worker ADD account_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE worker ADD CONSTRAINT FK_9FB2BF629B6B5FBA FOREIGN KEY (account_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9FB2BF629B6B5FBA ON worker (account_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6496B20BA36');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6496B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE worker DROP FOREIGN KEY FK_9FB2BF629B6B5FBA');
        $this->addSql('DROP INDEX UNIQ_9FB2BF629B6B5FBA ON worker');
        $this->addSql('ALTER TABLE worker DROP account_id');
    }
}
