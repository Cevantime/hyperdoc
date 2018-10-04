<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180929215156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ValueInjection (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, programValue_id INT DEFAULT NULL, programAssociation_id INT DEFAULT NULL, INDEX IDX_BDFD9162FFF4C05D (programValue_id), INDEX IDX_BDFD916228C4E0CB (programAssociation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ProgramAssociation (id INT AUTO_INCREMENT NOT NULL, wrapperProgram_id INT DEFAULT NULL, wrappedProgram_id INT DEFAULT NULL, INDEX IDX_532E1BE7FA8118B3 (wrapperProgram_id), INDEX IDX_532E1BE7BCC2163B (wrappedProgram_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ValueInjection ADD CONSTRAINT FK_BDFD9162FFF4C05D FOREIGN KEY (programValue_id) REFERENCES ProgramValue (id)');
        $this->addSql('ALTER TABLE ValueInjection ADD CONSTRAINT FK_BDFD916228C4E0CB FOREIGN KEY (programAssociation_id) REFERENCES ProgramAssociation (id)');
        $this->addSql('ALTER TABLE ProgramAssociation ADD CONSTRAINT FK_532E1BE7FA8118B3 FOREIGN KEY (wrapperProgram_id) REFERENCES Program (id)');
        $this->addSql('ALTER TABLE ProgramAssociation ADD CONSTRAINT FK_532E1BE7BCC2163B FOREIGN KEY (wrappedProgram_id) REFERENCES Program (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ValueInjection DROP FOREIGN KEY FK_BDFD916228C4E0CB');
        $this->addSql('DROP TABLE ValueInjection');
        $this->addSql('DROP TABLE ProgramAssociation');
    }
}
