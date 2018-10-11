<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181011185735 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, code LONGTEXT NOT NULL, fullCode LONGTEXT NOT NULL, language VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX program_slug (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_787308072C2AC5D3 (translatable_id), UNIQUE INDEX ProgramTranslation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_value (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, defaultValue VARCHAR(255) DEFAULT NULL, programInput_id INT DEFAULT NULL, programOutput_id INT DEFAULT NULL, INDEX IDX_831E2BC230966129 (programInput_id), INDEX IDX_831E2BC2F30D4376 (programOutput_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programvalue_program (programvalue_id INT NOT NULL, program_id INT NOT NULL, INDEX IDX_60B1936A682A20B (programvalue_id), INDEX IDX_60B1936A3EB8070A (program_id), PRIMARY KEY(programvalue_id, program_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE value_injection (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, programValue_id INT DEFAULT NULL, programAssociationInput_id INT DEFAULT NULL, programAssociationOutput_id INT DEFAULT NULL, INDEX IDX_D463E8E2FFF4C05D (programValue_id), INDEX IDX_D463E8E2EE38FD20 (programAssociationInput_id), INDEX IDX_D463E8E28A0F554E (programAssociationOutput_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_association (id INT AUTO_INCREMENT NOT NULL, wrapperProgram_id INT DEFAULT NULL, wrappedProgram_id INT DEFAULT NULL, INDEX IDX_319F6CA4FA8118B3 (wrapperProgram_id), INDEX IDX_319F6CA4BCC2163B (wrappedProgram_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program_translation ADD CONSTRAINT FK_787308072C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_value ADD CONSTRAINT FK_831E2BC230966129 FOREIGN KEY (programInput_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE program_value ADD CONSTRAINT FK_831E2BC2F30D4376 FOREIGN KEY (programOutput_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE programvalue_program ADD CONSTRAINT FK_60B1936A682A20B FOREIGN KEY (programvalue_id) REFERENCES program_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programvalue_program ADD CONSTRAINT FK_60B1936A3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E2FFF4C05D FOREIGN KEY (programValue_id) REFERENCES program_value (id)');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E2EE38FD20 FOREIGN KEY (programAssociationInput_id) REFERENCES program_association (id)');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E28A0F554E FOREIGN KEY (programAssociationOutput_id) REFERENCES program_association (id)');
        $this->addSql('ALTER TABLE program_association ADD CONSTRAINT FK_319F6CA4FA8118B3 FOREIGN KEY (wrapperProgram_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE program_association ADD CONSTRAINT FK_319F6CA4BCC2163B FOREIGN KEY (wrappedProgram_id) REFERENCES program (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE program_translation DROP FOREIGN KEY FK_787308072C2AC5D3');
        $this->addSql('ALTER TABLE program_value DROP FOREIGN KEY FK_831E2BC230966129');
        $this->addSql('ALTER TABLE program_value DROP FOREIGN KEY FK_831E2BC2F30D4376');
        $this->addSql('ALTER TABLE programvalue_program DROP FOREIGN KEY FK_60B1936A3EB8070A');
        $this->addSql('ALTER TABLE program_association DROP FOREIGN KEY FK_319F6CA4FA8118B3');
        $this->addSql('ALTER TABLE program_association DROP FOREIGN KEY FK_319F6CA4BCC2163B');
        $this->addSql('ALTER TABLE programvalue_program DROP FOREIGN KEY FK_60B1936A682A20B');
        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E2FFF4C05D');
        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E2EE38FD20');
        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E28A0F554E');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE program_translation');
        $this->addSql('DROP TABLE program_value');
        $this->addSql('DROP TABLE programvalue_program');
        $this->addSql('DROP TABLE value_injection');
        $this->addSql('DROP TABLE program_association');
    }
}
