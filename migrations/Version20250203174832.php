<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250203174832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Snippet';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS snippet (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, code LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_961C8CD512469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE snippet ADD CONSTRAINT FK_961C8CD512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE snippet DROP FOREIGN KEY FK_961C8CD512469DE2');
        $this->addSql('DROP TABLE IF EXISTS snippet');
    }
}
