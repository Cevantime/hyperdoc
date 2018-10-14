<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181014185000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE access_token (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, client_id INT DEFAULT NULL, identifier VARCHAR(255) NOT NULL, expiryDateTime DATE NOT NULL, revoked TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_B6A2DD68772E836A (identifier), INDEX IDX_B6A2DD68A76ED395 (user_id), INDEX IDX_B6A2DD6819EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_token (id INT AUTO_INCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL, expiryDateTime DATE NOT NULL, revoked TINYINT(1) DEFAULT \'0\' NOT NULL, accessToken_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_C74F2195772E836A (identifier), INDEX IDX_C74F21954C5BE87 (accessToken_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auth_code (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, client_id INT DEFAULT NULL, redirectUri VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, expiryDateTime DATE NOT NULL, userIdentifier VARCHAR(255) NOT NULL, revoked TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_5933D02CA76ED395 (user_id), INDEX IDX_5933D02C19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scope (id INT AUTO_INCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_AF55D3772E836A (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scope_authcode (scope_id INT NOT NULL, authcode_id INT NOT NULL, INDEX IDX_7FC7AA6682B5931 (scope_id), INDEX IDX_7FC7AA6FE4ABE76 (authcode_id), PRIMARY KEY(scope_id, authcode_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD68A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD6819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE refresh_token ADD CONSTRAINT FK_C74F21954C5BE87 FOREIGN KEY (accessToken_id) REFERENCES access_token (id)');
        $this->addSql('ALTER TABLE auth_code ADD CONSTRAINT FK_5933D02CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE auth_code ADD CONSTRAINT FK_5933D02C19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE scope_authcode ADD CONSTRAINT FK_7FC7AA6682B5931 FOREIGN KEY (scope_id) REFERENCES scope (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scope_authcode ADD CONSTRAINT FK_7FC7AA6FE4ABE76 FOREIGN KEY (authcode_id) REFERENCES auth_code (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE refresh_token DROP FOREIGN KEY FK_C74F21954C5BE87');
        $this->addSql('ALTER TABLE scope_authcode DROP FOREIGN KEY FK_7FC7AA6FE4ABE76');
        $this->addSql('ALTER TABLE scope_authcode DROP FOREIGN KEY FK_7FC7AA6682B5931');
        $this->addSql('DROP TABLE access_token');
        $this->addSql('DROP TABLE refresh_token');
        $this->addSql('DROP TABLE auth_code');
        $this->addSql('DROP TABLE scope');
        $this->addSql('DROP TABLE scope_authcode');
    }
}
