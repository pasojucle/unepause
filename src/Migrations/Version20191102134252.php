<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191102134252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE page_content_link');
        $this->addSql('ALTER TABLE page_content ADD link_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_content ADD CONSTRAINT FK_4A5DB3CADA40271 FOREIGN KEY (link_id) REFERENCES link (id)');
        $this->addSql('CREATE INDEX IDX_4A5DB3CADA40271 ON page_content (link_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page_content_link (page_content_id INT NOT NULL, link_id INT NOT NULL, INDEX IDX_45D2D87A8F409273 (page_content_id), INDEX IDX_45D2D87AADA40271 (link_id), PRIMARY KEY(page_content_id, link_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE page_content_link ADD CONSTRAINT FK_45D2D87A8F409273 FOREIGN KEY (page_content_id) REFERENCES page_content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_content_link ADD CONSTRAINT FK_45D2D87AADA40271 FOREIGN KEY (link_id) REFERENCES link (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_content DROP FOREIGN KEY FK_4A5DB3CADA40271');
        $this->addSql('DROP INDEX IDX_4A5DB3CADA40271 ON page_content');
        $this->addSql('ALTER TABLE page_content DROP link_id');
    }
}
