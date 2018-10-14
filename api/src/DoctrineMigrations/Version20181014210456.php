<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181014210456 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE access_token CHANGE expiryDateTime expiryDateTime DATETIME NOT NULL');
        $this->addSql('ALTER TABLE auth_code CHANGE expiryDateTime expiryDateTime DATETIME NOT NULL');
        $this->addSql('ALTER TABLE refresh_token CHANGE expiryDateTime expiryDateTime DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE access_token CHANGE expiryDateTime expiryDateTime DATE NOT NULL');
        $this->addSql('ALTER TABLE auth_code CHANGE expiryDateTime expiryDateTime DATE NOT NULL');
        $this->addSql('ALTER TABLE refresh_token CHANGE expiryDateTime expiryDateTime DATE NOT NULL');
    }
}
