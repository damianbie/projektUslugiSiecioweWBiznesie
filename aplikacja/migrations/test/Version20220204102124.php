<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204102124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repair_order ADD registered_by_id INT NOT NULL, ADD ordered_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE repair_order ADD CONSTRAINT FK_55F6573427E92E18 FOREIGN KEY (registered_by_id) REFERENCES worker (id)');
        $this->addSql('CREATE INDEX IDX_55F6573427E92E18 ON repair_order (registered_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address CHANGE country country VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE province province VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE town town VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE street street VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE post_code post_code VARCHAR(6) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE house_number house_number VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE client CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surname surname VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pesel pesel VARCHAR(11) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nip nip VARCHAR(11) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE regon regon VARCHAR(9) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone_number phone_number VARCHAR(22) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE repair_order DROP FOREIGN KEY FK_55F6573427E92E18');
        $this->addSql('DROP INDEX IDX_55F6573427E92E18 ON repair_order');
        $this->addSql('ALTER TABLE repair_order DROP registered_by_id, DROP ordered_at');
        $this->addSql('ALTER TABLE serivce CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE vehicle CHANGE manufacturer manufacturer VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE model model VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE production_year production_year VARCHAR(4) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE vin vin VARCHAR(17) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE registration_number registration_number VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE work_place CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE worker CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surname surname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone_number phone_number LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
