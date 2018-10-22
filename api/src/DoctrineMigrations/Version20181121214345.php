<?php declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181121214345 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, discr VARCHAR(255) NOT NULL, language VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, full_code VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_FEC530A9989D9B62 (slug), INDEX IDX_FEC530A9F675F31B (author_id), INDEX disriminator_index (discr), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE access_token (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, client_id INT DEFAULT NULL, identifier VARCHAR(255) NOT NULL, expiry_date_time DATETIME NOT NULL, revoked TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_B6A2DD68772E836A (identifier), INDEX IDX_B6A2DD68A76ED395 (user_id), INDEX IDX_B6A2DD6819EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auth_code (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, client_id INT DEFAULT NULL, redirect_uri VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, expiry_date_time DATETIME NOT NULL, revoked TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_5933D02CA76ED395 (user_id), INDEX IDX_5933D02C19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scope (id INT AUTO_INCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_AF55D3772E836A (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scope_auth_code (scope_id INT NOT NULL, auth_code_id INT NOT NULL, INDEX IDX_EB21B462682B5931 (scope_id), INDEX IDX_EB21B46269FEDEE4 (auth_code_id), PRIMARY KEY(scope_id, auth_code_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL, secret VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, redirect_uri VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C7440455772E836A (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_value (id INT AUTO_INCREMENT NOT NULL, program_input_id INT DEFAULT NULL, program_output_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, default_value VARCHAR(255) DEFAULT NULL, INDEX IDX_831E2BC2B777E6E3 (program_input_id), INDEX IDX_831E2BC2883B895F (program_output_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_value_program (program_value_id INT NOT NULL, program_id INT NOT NULL, INDEX IDX_DC06127C78154797 (program_value_id), INDEX IDX_DC06127C3EB8070A (program_id), PRIMARY KEY(program_value_id, program_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE value_injection (id INT AUTO_INCREMENT NOT NULL, program_value_id INT DEFAULT NULL, program_association_input_id INT DEFAULT NULL, program_association_output_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_D463E8E278154797 (program_value_id), INDEX IDX_D463E8E2F028EB7F (program_association_input_id), INDEX IDX_D463E8E271C5093D (program_association_output_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_E743EFE92C2AC5D3 (translatable_id), UNIQUE INDEX content_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_association (id INT AUTO_INCREMENT NOT NULL, wrapper_program_id INT DEFAULT NULL, wrapped_program_id INT DEFAULT NULL, INDEX IDX_319F6CA469164A92 (wrapper_program_id), INDEX IDX_319F6CA48A33028E (wrapped_program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_token (id INT AUTO_INCREMENT NOT NULL, access_token_id INT DEFAULT NULL, identifier VARCHAR(255) NOT NULL, expiry_date_time DATETIME NOT NULL, revoked TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_C74F2195772E836A (identifier), INDEX IDX_C74F21952CCB2688 (access_token_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD68A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD6819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE auth_code ADD CONSTRAINT FK_5933D02CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE auth_code ADD CONSTRAINT FK_5933D02C19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE scope_auth_code ADD CONSTRAINT FK_EB21B462682B5931 FOREIGN KEY (scope_id) REFERENCES scope (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scope_auth_code ADD CONSTRAINT FK_EB21B46269FEDEE4 FOREIGN KEY (auth_code_id) REFERENCES auth_code (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_value ADD CONSTRAINT FK_831E2BC2B777E6E3 FOREIGN KEY (program_input_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE program_value ADD CONSTRAINT FK_831E2BC2883B895F FOREIGN KEY (program_output_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE program_value_program ADD CONSTRAINT FK_DC06127C78154797 FOREIGN KEY (program_value_id) REFERENCES program_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_value_program ADD CONSTRAINT FK_DC06127C3EB8070A FOREIGN KEY (program_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E278154797 FOREIGN KEY (program_value_id) REFERENCES program_value (id)');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E2F028EB7F FOREIGN KEY (program_association_input_id) REFERENCES program_association (id)');
        $this->addSql('ALTER TABLE value_injection ADD CONSTRAINT FK_D463E8E271C5093D FOREIGN KEY (program_association_output_id) REFERENCES program_association (id)');
        $this->addSql('ALTER TABLE content_translation ADD CONSTRAINT FK_E743EFE92C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_association ADD CONSTRAINT FK_319F6CA469164A92 FOREIGN KEY (wrapper_program_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE program_association ADD CONSTRAINT FK_319F6CA48A33028E FOREIGN KEY (wrapped_program_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE refresh_token ADD CONSTRAINT FK_C74F21952CCB2688 FOREIGN KEY (access_token_id) REFERENCES access_token (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A9F675F31B');
        $this->addSql('ALTER TABLE access_token DROP FOREIGN KEY FK_B6A2DD68A76ED395');
        $this->addSql('ALTER TABLE auth_code DROP FOREIGN KEY FK_5933D02CA76ED395');
        $this->addSql('ALTER TABLE program_value DROP FOREIGN KEY FK_831E2BC2B777E6E3');
        $this->addSql('ALTER TABLE program_value DROP FOREIGN KEY FK_831E2BC2883B895F');
        $this->addSql('ALTER TABLE program_value_program DROP FOREIGN KEY FK_DC06127C3EB8070A');
        $this->addSql('ALTER TABLE content_translation DROP FOREIGN KEY FK_E743EFE92C2AC5D3');
        $this->addSql('ALTER TABLE program_association DROP FOREIGN KEY FK_319F6CA469164A92');
        $this->addSql('ALTER TABLE program_association DROP FOREIGN KEY FK_319F6CA48A33028E');
        $this->addSql('ALTER TABLE refresh_token DROP FOREIGN KEY FK_C74F21952CCB2688');
        $this->addSql('ALTER TABLE scope_auth_code DROP FOREIGN KEY FK_EB21B46269FEDEE4');
        $this->addSql('ALTER TABLE scope_auth_code DROP FOREIGN KEY FK_EB21B462682B5931');
        $this->addSql('ALTER TABLE access_token DROP FOREIGN KEY FK_B6A2DD6819EB6921');
        $this->addSql('ALTER TABLE auth_code DROP FOREIGN KEY FK_5933D02C19EB6921');
        $this->addSql('ALTER TABLE program_value_program DROP FOREIGN KEY FK_DC06127C78154797');
        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E278154797');
        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E2F028EB7F');
        $this->addSql('ALTER TABLE value_injection DROP FOREIGN KEY FK_D463E8E271C5093D');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE access_token');
        $this->addSql('DROP TABLE auth_code');
        $this->addSql('DROP TABLE scope');
        $this->addSql('DROP TABLE scope_auth_code');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE program_value');
        $this->addSql('DROP TABLE program_value_program');
        $this->addSql('DROP TABLE value_injection');
        $this->addSql('DROP TABLE content_translation');
        $this->addSql('DROP TABLE program_association');
        $this->addSql('DROP TABLE refresh_token');
    }
}
