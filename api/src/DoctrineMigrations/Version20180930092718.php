<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180930092718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ValueInjection DROP FOREIGN KEY FK_BDFD916228C4E0CB');
        $this->addSql('DROP INDEX IDX_BDFD916228C4E0CB ON ValueInjection');
        $this->addSql('ALTER TABLE ValueInjection ADD programAssociationOutput_id INT DEFAULT NULL, CHANGE programassociation_id programAssociationInput_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ValueInjection ADD CONSTRAINT FK_BDFD9162EE38FD20 FOREIGN KEY (programAssociationInput_id) REFERENCES ProgramAssociation (id)');
        $this->addSql('ALTER TABLE ValueInjection ADD CONSTRAINT FK_BDFD91628A0F554E FOREIGN KEY (programAssociationOutput_id) REFERENCES ProgramAssociation (id)');
        $this->addSql('CREATE INDEX IDX_BDFD9162EE38FD20 ON ValueInjection (programAssociationInput_id)');
        $this->addSql('CREATE INDEX IDX_BDFD91628A0F554E ON ValueInjection (programAssociationOutput_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ValueInjection DROP FOREIGN KEY FK_BDFD9162EE38FD20');
        $this->addSql('ALTER TABLE ValueInjection DROP FOREIGN KEY FK_BDFD91628A0F554E');
        $this->addSql('DROP INDEX IDX_BDFD9162EE38FD20 ON ValueInjection');
        $this->addSql('DROP INDEX IDX_BDFD91628A0F554E ON ValueInjection');
        $this->addSql('ALTER TABLE ValueInjection ADD programAssociation_id INT DEFAULT NULL, DROP programAssociationInput_id, DROP programAssociationOutput_id');
        $this->addSql('ALTER TABLE ValueInjection ADD CONSTRAINT FK_BDFD916228C4E0CB FOREIGN KEY (programAssociation_id) REFERENCES ProgramAssociation (id)');
        $this->addSql('CREATE INDEX IDX_BDFD916228C4E0CB ON ValueInjection (programAssociation_id)');
    }
}
