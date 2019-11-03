<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191101165354 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page_content_link (page_content_id INT NOT NULL, link_id INT NOT NULL, INDEX IDX_45D2D87A8F409273 (page_content_id), INDEX IDX_45D2D87AADA40271 (link_id), PRIMARY KEY(page_content_id, link_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, page_container_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_36AC99F1C4663E4 (page_id), INDEX IDX_36AC99F123D5B0C (page_container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_content_link ADD CONSTRAINT FK_45D2D87A8F409273 FOREIGN KEY (page_content_id) REFERENCES page_content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_content_link ADD CONSTRAINT FK_45D2D87AADA40271 FOREIGN KEY (link_id) REFERENCES link (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F123D5B0C FOREIGN KEY (page_container_id) REFERENCES page_container (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_content_link DROP FOREIGN KEY FK_45D2D87AADA40271');
        $this->addSql('DROP TABLE page_content_link');
        $this->addSql('DROP TABLE link');
    }
}
