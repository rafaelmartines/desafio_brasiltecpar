<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230825000215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE batch_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE batch (id INT NOT NULL, batch TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, numero_bloco INT NOT NULL, string_entrada VARCHAR(255) NOT NULL, chave_encontrada VARCHAR(255) NOT NULL, hash_gerado VARCHAR(255) NOT NULL, numero_tentativas INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE batch_id_seq CASCADE');
        $this->addSql('DROP TABLE batch');
    }
}
