<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180929201733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Program (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, language VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ProgramTranslation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_1AC27F442C2AC5D3 (translatable_id), UNIQUE INDEX ProgramTranslation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ProgramValue (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, defaultValue VARCHAR(255) DEFAULT NULL, programInput_id INT DEFAULT NULL, programOutput_id INT DEFAULT NULL, INDEX IDX_944489D430966129 (programInput_id), INDEX IDX_944489D4F30D4376 (programOutput_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ProgramTranslation ADD CONSTRAINT FK_1AC27F442C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES Program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ProgramValue ADD CONSTRAINT FK_944489D430966129 FOREIGN KEY (programInput_id) REFERENCES Program (id)');
        $this->addSql('ALTER TABLE ProgramValue ADD CONSTRAINT FK_944489D4F30D4376 FOREIGN KEY (programOutput_id) REFERENCES Program (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ProgramTranslation DROP FOREIGN KEY FK_1AC27F442C2AC5D3');
        $this->addSql('ALTER TABLE ProgramValue DROP FOREIGN KEY FK_944489D430966129');
        $this->addSql('ALTER TABLE ProgramValue DROP FOREIGN KEY FK_944489D4F30D4376');
        $this->addSql('DROP TABLE Program');
        $this->addSql('DROP TABLE ProgramTranslation');
        $this->addSql('DROP TABLE ProgramValue');
    }
}
