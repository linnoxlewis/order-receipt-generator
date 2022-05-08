<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220425084511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "printer_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "check" (id UUID NOT NULL, order_id UUID DEFAULT NULL, status INT DEFAULT 0 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3C8EAC138D9F6D38 ON "check" (order_id)');
        $this->addSql('COMMENT ON COLUMN "check".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "check".order_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "order" (id UUID NOT NULL, printer_id INT DEFAULT NULL, check_id UUID DEFAULT NULL, info VARCHAR(3000) NOT NULL, amount INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F529939846EC494A ON "order" (printer_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398709385E7 ON "order" (check_id)');
        $this->addSql('COMMENT ON COLUMN "order".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "order".check_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "printer" (id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, api_key VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D4C79ED5E237E06 ON "printer" (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D4C79EDC912ED9D ON "printer" (api_key)');
        $this->addSql('ALTER TABLE "check" ADD CONSTRAINT FK_3C8EAC138D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F529939846EC494A FOREIGN KEY (printer_id) REFERENCES "printer" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398709385E7 FOREIGN KEY (check_id) REFERENCES "check" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398709385E7');
        $this->addSql('ALTER TABLE "check" DROP CONSTRAINT FK_3C8EAC138D9F6D38');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F529939846EC494A');
        $this->addSql('DROP SEQUENCE "printer_id_seq" CASCADE');
        $this->addSql('DROP TABLE "check"');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE "printer"');
    }
}
