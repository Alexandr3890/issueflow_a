<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261105104546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Añade la contraseña a los usuarios.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE users ADD password VARCHAR(255) DEFAULT NULL'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP password');
    }
}
