<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020151408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE class_container (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, class VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_container ADD class_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_container ADD CONSTRAINT FK_FC4C53D4EA000B10 FOREIGN KEY (class_id) REFERENCES class_container (id)');
        $this->addSql('CREATE INDEX IDX_FC4C53D4EA000B10 ON page_container (class_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_container DROP FOREIGN KEY FK_FC4C53D4EA000B10');
        $this->addSql('DROP TABLE class_container');
        $this->addSql('DROP INDEX IDX_FC4C53D4EA000B10 ON page_container');
        $this->addSql('ALTER TABLE page_container DROP class_id');
    }
}
