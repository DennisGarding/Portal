<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250218163440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Note';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS note (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, note LONGTEXT NOT NULL, INDEX IDX_CFBDFA1412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1412469DE2');
        $this->addSql('DROP TABLE IF EXISTS note');
    }
}
