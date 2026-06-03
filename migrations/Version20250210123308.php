<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250210123308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Accordion state';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS accordion_state (id INT AUTO_INCREMENT NOT NULL, state JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('INSERT INTO `accordion_state` (`id`, `state`) VALUES (1, \'{"isDefault": true}\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS accordion_state');
    }
}
