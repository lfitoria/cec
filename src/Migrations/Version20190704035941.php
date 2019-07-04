<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190704035941 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE col_info_files_ethic_eval (ethicevalrequest_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_54459AE935E09FA2 (ethicevalrequest_id), INDEX IDX_54459AE993CB796C (file_id), PRIMARY KEY(ethicevalrequest_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assent_files_ethic_eval (ethicevalrequest_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_5E45409C35E09FA2 (ethicevalrequest_id), INDEX IDX_5E45409C93CB796C (file_id), PRIMARY KEY(ethicevalrequest_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consent_files_ethic_eval (ethicevalrequest_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_B97EA9C235E09FA2 (ethicevalrequest_id), INDEX IDX_B97EA9C293CB796C (file_id), PRIMARY KEY(ethicevalrequest_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE col_info_files_ethic_eval ADD CONSTRAINT FK_54459AE935E09FA2 FOREIGN KEY (ethicevalrequest_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE col_info_files_ethic_eval ADD CONSTRAINT FK_54459AE993CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assent_files_ethic_eval ADD CONSTRAINT FK_5E45409C35E09FA2 FOREIGN KEY (ethicevalrequest_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assent_files_ethic_eval ADD CONSTRAINT FK_5E45409C93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consent_files_ethic_eval ADD CONSTRAINT FK_B97EA9C235E09FA2 FOREIGN KEY (ethicevalrequest_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consent_files_ethic_eval ADD CONSTRAINT FK_B97EA9C293CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE col_info_files_ethic_eval');
        $this->addSql('DROP TABLE assent_files_ethic_eval');
        $this->addSql('DROP TABLE consent_files_ethic_eval');
    }
}
