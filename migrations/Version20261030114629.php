<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261030114629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Añade usuarios, categorías y sus relaciones con tickets.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE categories (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, UNIQUE INDEX UNIQ_3AF346686E5EAE5A (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');

        $this->addSql('CREATE TABLE users (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, email VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');

        $this->addSql('ALTER TABLE tickets ADD assignee_id BIGINT UNSIGNED DEFAULT NULL, ADD category_id BIGINT UNSIGNED DEFAULT NULL');

        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4C3E5E72A FOREIGN KEY (assignee_id) REFERENCES users (id) ON DELETE SET NULL');

        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF412469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL');

        $this->addSql('CREATE INDEX IDX_54469DF4C3E5E72A ON tickets (assignee_id)');

        $this->addSql('CREATE INDEX IDX_54469DF412469DE2 ON tickets (category_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4C3E5E72A');

        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF412469DE2');

        $this->addSql('DROP TABLE categories');

        $this->addSql('DROP TABLE users');

        $this->addSql('ALTER TABLE tickets DROP assignee_id, DROP category_id');
    }
}