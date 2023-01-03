<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203170920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repair_order ADD client_id INT NOT NULL, ADD vehicle_id INT NOT NULL');
        $this->addSql('ALTER TABLE repair_order ADD CONSTRAINT FK_55F6573419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE repair_order ADD CONSTRAINT FK_55F65734545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('CREATE INDEX IDX_55F6573419EB6921 ON repair_order (client_id)');
        $this->addSql('CREATE INDEX IDX_55F65734545317D1 ON repair_order (vehicle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address CHANGE country country VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE province province VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE town town VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE street street VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE post_code post_code VARCHAR(6) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE house_number house_number VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE client CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surname surname VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pesel pesel VARCHAR(11) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nip nip VARCHAR(11) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE regon regon VARCHAR(9) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone_number phone_number VARCHAR(22) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE repair_order DROP FOREIGN KEY FK_55F6573419EB6921');
        $this->addSql('ALTER TABLE repair_order DROP FOREIGN KEY FK_55F65734545317D1');
        $this->addSql('DROP INDEX IDX_55F6573419EB6921 ON repair_order');
        $this->addSql('DROP INDEX IDX_55F65734545317D1 ON repair_order');
        $this->addSql('ALTER TABLE repair_order DROP client_id, DROP vehicle_id');
        $this->addSql('ALTER TABLE serivce CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE vehicle CHANGE manufacturer manufacturer VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE model model VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE production_year production_year VARCHAR(4) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE vin vin VARCHAR(17) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE registration_number registration_number VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE work_place CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE worker CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surname surname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone_number phone_number LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
