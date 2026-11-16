<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261106102353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Añade los roles de autorización a los usuarios.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE users ADD roles JSON DEFAULT NULL'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP roles');
    }
}
