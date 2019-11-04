<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191104192409 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B7294869C');
        $this->addSql('ALTER TABLE image_article DROP FOREIGN KEY FK_972A59BA7294869C');
        $this->addSql('CREATE TABLE class_container (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, title VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_container (id INT AUTO_INCREMENT NOT NULL, container_id INT NOT NULL, page_id INT NOT NULL, class_id INT DEFAULT NULL, order_by INT NOT NULL, title VARCHAR(50) DEFAULT NULL, footer LONGTEXT DEFAULT NULL, INDEX IDX_FC4C53D4BC21F742 (container_id), INDEX IDX_FC4C53D4C4663E4 (page_id), INDEX IDX_FC4C53D4EA000B10 (class_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_content (id INT AUTO_INCREMENT NOT NULL, page_container_id INT DEFAULT NULL, link_id INT DEFAULT NULL, title VARCHAR(100) DEFAULT NULL, content LONGTEXT DEFAULT NULL, order_by INT DEFAULT NULL, INDEX IDX_4A5DB3C23D5B0C (page_container_id), INDEX IDX_4A5DB3CADA40271 (link_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, page_container_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_36AC99F1C4663E4 (page_id), INDEX IDX_36AC99F123D5B0C (page_container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_page_content (image_id INT NOT NULL, page_content_id INT NOT NULL, INDEX IDX_E6AA3503DA5256D (image_id), INDEX IDX_E6AA3508F409273 (page_content_id), PRIMARY KEY(image_id, page_content_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, parameters VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_container ADD CONSTRAINT FK_FC4C53D4BC21F742 FOREIGN KEY (container_id) REFERENCES container (id)');
        $this->addSql('ALTER TABLE page_container ADD CONSTRAINT FK_FC4C53D4C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page_container ADD CONSTRAINT FK_FC4C53D4EA000B10 FOREIGN KEY (class_id) REFERENCES class_container (id)');
        $this->addSql('ALTER TABLE page_content ADD CONSTRAINT FK_4A5DB3C23D5B0C FOREIGN KEY (page_container_id) REFERENCES page_container (id)');
        $this->addSql('ALTER TABLE page_content ADD CONSTRAINT FK_4A5DB3CADA40271 FOREIGN KEY (link_id) REFERENCES link (id)');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F123D5B0C FOREIGN KEY (page_container_id) REFERENCES page_container (id)');
        $this->addSql('ALTER TABLE image_page_content ADD CONSTRAINT FK_E6AA3503DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_page_content ADD CONSTRAINT FK_E6AA3508F409273 FOREIGN KEY (page_content_id) REFERENCES page_content (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE image_article');
        $this->addSql('ALTER TABLE template ADD route_id INT DEFAULT NULL, DROP route_parameters, CHANGE route filename VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE template ADD CONSTRAINT FK_97601F8334ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('CREATE INDEX IDX_97601F8334ECB4E6 ON template (route_id)');
        $this->addSql('ALTER TABLE action ADD is_anchor TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('DROP INDEX IDX_A5E6215B7294869C ON family');
        $this->addSql('ALTER TABLE family CHANGE article_id page_content_id INT NOT NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B8F409273 FOREIGN KEY (page_content_id) REFERENCES page_content (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B8F409273 ON family (page_content_id)');
        $this->addSql('ALTER TABLE price CHANGE amount amount DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_container DROP FOREIGN KEY FK_FC4C53D4EA000B10');
        $this->addSql('ALTER TABLE page_content DROP FOREIGN KEY FK_4A5DB3C23D5B0C');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F123D5B0C');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B8F409273');
        $this->addSql('ALTER TABLE image_page_content DROP FOREIGN KEY FK_E6AA3508F409273');
        $this->addSql('ALTER TABLE page_content DROP FOREIGN KEY FK_4A5DB3CADA40271');
        $this->addSql('ALTER TABLE template DROP FOREIGN KEY FK_97601F8334ECB4E6');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, title VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci, content LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_23A0E66C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE image_article (image_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_972A59BA3DA5256D (image_id), INDEX IDX_972A59BA7294869C (article_id), PRIMARY KEY(image_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE image_article ADD CONSTRAINT FK_972A59BA3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_article ADD CONSTRAINT FK_972A59BA7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE class_container');
        $this->addSql('DROP TABLE page_container');
        $this->addSql('DROP TABLE page_content');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE image_page_content');
        $this->addSql('DROP TABLE route');
        $this->addSql('ALTER TABLE action DROP is_anchor');
        $this->addSql('DROP INDEX IDX_A5E6215B8F409273 ON family');
        $this->addSql('ALTER TABLE family CHANGE page_content_id article_id INT NOT NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B7294869C ON family (article_id)');
        $this->addSql('ALTER TABLE price CHANGE amount amount DOUBLE PRECISION NOT NULL');
        $this->addSql('DROP INDEX IDX_97601F8334ECB4E6 ON template');
        $this->addSql('ALTER TABLE template ADD route_parameters LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP route_id, CHANGE filename route VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
