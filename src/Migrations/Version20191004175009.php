<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191004175009 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page_content (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, title VARCHAR(100) DEFAULT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_4A5DB3CC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_page_content (image_id INT NOT NULL, page_content_id INT NOT NULL, INDEX IDX_E6AA3503DA5256D (image_id), INDEX IDX_E6AA3508F409273 (page_content_id), PRIMARY KEY(image_id, page_content_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_content ADD CONSTRAINT FK_4A5DB3CC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE image_page_content ADD CONSTRAINT FK_E6AA3503DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_page_content ADD CONSTRAINT FK_E6AA3508F409273 FOREIGN KEY (page_content_id) REFERENCES page_content (id) ON DELETE CASCADE');
        $this->addsql('INSERT INTO page_content SELECT * FROM article');
        $this->addsql('INSERT INTO image_page_content SELECT * FROM image_article');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE image_article');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B7294869C');
        $this->addSql('DROP INDEX IDX_A5E6215B7294869C ON family');
        $this->addSql('ALTER TABLE family CHANGE article_id page_content_id INT NOT NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B8F409273 FOREIGN KEY (page_content_id) REFERENCES page_content (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B8F409273 ON family (page_content_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B8F409273');
        $this->addSql('ALTER TABLE image_page_content DROP FOREIGN KEY FK_E6AA3508F409273');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, title VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci, content LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_23A0E66C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE image_article (image_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_972A59BA3DA5256D (image_id), INDEX IDX_972A59BA7294869C (article_id), PRIMARY KEY(image_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE image_article ADD CONSTRAINT FK_972A59BA3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_article ADD CONSTRAINT FK_972A59BA7294869C FOREIGN KEY (article_id) REFERENCES page_content (id) ON DELETE CASCADE');
        $this->addsql('INSERT INTO article SELECT * FROM page_content');
        $this->addsql('INSERT INTO image_page_content SELECT * FROM image_article');
        $this->addSql('DROP TABLE page_content');
        $this->addSql('DROP TABLE image_page_content');
        $this->addSql('DROP INDEX IDX_A5E6215B8F409273 ON family');
        $this->addSql('ALTER TABLE family CHANGE page_content_id article_id INT NOT NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B7294869C FOREIGN KEY (article_id) REFERENCES page_content (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B7294869C ON family (article_id)');
    }
}
