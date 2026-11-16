<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261109220000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Corrige los nombres de los índices de categorías y tickets.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE categories RENAME INDEX uniq_3af346686e5eae5a TO UNIQ_3AF346685E237E06'
        );

        $this->addSql(
            'ALTER TABLE tickets RENAME INDEX idx_54469df4c3e5e72a TO IDX_54469DF459EC7D60'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE categories RENAME INDEX UNIQ_3AF346685E237E06 TO uniq_3af346686e5eae5a'
        );

        $this->addSql(
            'ALTER TABLE tickets RENAME INDEX IDX_54469DF459EC7D60 TO idx_54469df4c3e5e72a'
        );
    }
}
