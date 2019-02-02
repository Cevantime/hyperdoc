<?php declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190131212334 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E271C5093D');
        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E2F028EB7F');
        $this->addSql('ALTER TABLE program_value_program DROP FOREIGN KEY FK_DC06127C78154797');
        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E278154797');
        $this->addSql('CREATE TABLE content_value (id INT AUTO_INCREMENT NOT NULL, content_input_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, default_value VARCHAR(255) DEFAULT NULL, INDEX IDX_F6B40CE664F5F039 (content_input_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_value_content (content_value_id INT NOT NULL, content_id INT NOT NULL, INDEX IDX_4EBD63D8AB97514D (content_value_id), INDEX IDX_4EBD63D884A0A3ED (content_id), PRIMARY KEY(content_value_id, content_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_association (id INT AUTO_INCREMENT NOT NULL, wrapper_content_id INT DEFAULT NULL, wrapped_content_id INT DEFAULT NULL, INDEX IDX_AEAF8B4AD30EEE75 (wrapper_content_id), INDEX IDX_AEAF8B4A302BA669 (wrapped_content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content_value ADD CONSTRAINT FK_F6B40CE664F5F039 FOREIGN KEY (content_input_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE content_value_content ADD CONSTRAINT FK_4EBD63D8AB97514D FOREIGN KEY (content_value_id) REFERENCES content_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_value_content ADD CONSTRAINT FK_4EBD63D884A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_association ADD CONSTRAINT FK_AEAF8B4AD30EEE75 FOREIGN KEY (wrapper_content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE content_association ADD CONSTRAINT FK_AEAF8B4A302BA669 FOREIGN KEY (wrapped_content_id) REFERENCES content (id)');
        $this->addSql('DROP TABLE program_association');
        $this->addSql('DROP TABLE program_value');
        $this->addSql('DROP TABLE program_value_program');
        $this->addSql('DROP INDEX IDX_D463E8E278154797 ON value_injection');
        $this->addSql('DROP INDEX IDX_D463E8E2F028EB7F ON value_injection');
        $this->addSql('DROP INDEX IDX_D463E8E271C5093D ON value_injection');
        $this->addSql('ALTER TABLE value_injection ADD content_value_id INT DEFAULT NULL, ADD content_association_input_id INT DEFAULT NULL, ADD content_association_output_id INT DEFAULT NULL, DROP program_value_id, DROP program_association_input_id, DROP program_association_output_id');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E2AB97514D FOREIGN KEY (content_value_id) REFERENCES content_value (id)');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E2CF9A9CBA FOREIGN KEY (content_association_input_id) REFERENCES content_association (id)');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E29AF48D75 FOREIGN KEY (content_association_output_id) REFERENCES content_association (id)');
        $this->addSql('CREATE INDEX IDX_D463E8E2AB97514D ON value_injection (content_value_id)');
        $this->addSql('CREATE INDEX IDX_D463E8E2CF9A9CBA ON value_injection (content_association_input_id)');
        $this->addSql('CREATE INDEX IDX_D463E8E29AF48D75 ON value_injection (content_association_output_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE content_value_content DROP FOREIGN KEY FK_4EBD63D8AB97514D');
        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E2AB97514D');
        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E2CF9A9CBA');
        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E29AF48D75');
        $this->addSql('CREATE TABLE program_association (id INT AUTO_INCREMENT NOT NULL, wrapper_program_id INT DEFAULT NULL, wrapped_program_id INT DEFAULT NULL, INDEX IDX_319F6CA469164A92 (wrapper_program_id), INDEX IDX_319F6CA48A33028E (wrapped_program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_value (id INT AUTO_INCREMENT NOT NULL, program_input_id INT DEFAULT NULL, program_output_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, value VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, default_value VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_831E2BC2B777E6E3 (program_input_id), INDEX IDX_831E2BC2883B895F (program_output_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_value_program (program_value_id INT NOT NULL, program_id INT NOT NULL, INDEX IDX_DC06127C78154797 (program_value_id), INDEX IDX_DC06127C3EB8070A (program_id), PRIMARY KEY(program_value_id, program_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program_association ADD CONSTRAINT FK_319F6CA469164A92 FOREIGN KEY (wrapper_program_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE program_association ADD CONSTRAINT FK_319F6CA48A33028E FOREIGN KEY (wrapped_program_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE program_value ADD CONSTRAINT FK_831E2BC2883B895F FOREIGN KEY (program_output_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE program_value ADD CONSTRAINT FK_831E2BC2B777E6E3 FOREIGN KEY (program_input_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE program_value_program ADD CONSTRAINT FK_DC06127C3EB8070A FOREIGN KEY (program_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_value_program ADD CONSTRAINT FK_DC06127C78154797 FOREIGN KEY (program_value_id) REFERENCES program_value (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE content_value');
        $this->addSql('DROP TABLE content_value_content');
        $this->addSql('DROP TABLE content_association');
        $this->addSql('DROP INDEX IDX_D463E8E2AB97514D ON value_injection');
        $this->addSql('DROP INDEX IDX_D463E8E2CF9A9CBA ON value_injection');
        $this->addSql('DROP INDEX IDX_D463E8E29AF48D75 ON value_injection');
        $this->addSql('ALTER TABLE value_injection ADD program_value_id INT DEFAULT NULL, ADD program_association_input_id INT DEFAULT NULL, ADD program_association_output_id INT DEFAULT NULL, DROP content_value_id, DROP content_association_input_id, DROP content_association_output_id');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E271C5093D FOREIGN KEY (program_association_output_id) REFERENCES program_association (id)');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E278154797 FOREIGN KEY (program_value_id) REFERENCES program_value (id)');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E2F028EB7F FOREIGN KEY (program_association_input_id) REFERENCES program_association (id)');
        $this->addSql('CREATE INDEX IDX_D463E8E278154797 ON value_injection (program_value_id)');
        $this->addSql('CREATE INDEX IDX_D463E8E2F028EB7F ON value_injection (program_association_input_id)');
        $this->addSql('CREATE INDEX IDX_D463E8E271C5093D ON value_injection (program_association_output_id)');
    }
}
