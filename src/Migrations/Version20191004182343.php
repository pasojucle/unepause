<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191004182343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page_container (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, tag_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_content ADD page_container_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_content ADD CONSTRAINT FK_4A5DB3C23D5B0C FOREIGN KEY (page_container_id) REFERENCES page_container (id)');
        $this->addSql('CREATE INDEX IDX_4A5DB3C23D5B0C ON page_content (page_container_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_content DROP FOREIGN KEY FK_4A5DB3C23D5B0C');
        $this->addSql('DROP TABLE page_container');
        $this->addSql('DROP INDEX IDX_4A5DB3C23D5B0C ON page_content');
        $this->addSql('ALTER TABLE page_content DROP page_container_id');
    }
}
