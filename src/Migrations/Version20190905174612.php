<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190905174612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, route VARCHAR(50) NOT NULL, route_parameters LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, filename VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_article (image_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_972A59BA3DA5256D (image_id), INDEX IDX_972A59BA7294869C (article_id), PRIMARY KEY(image_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, template_id INT NOT NULL, action_id INT NOT NULL, name VARCHAR(50) NOT NULL, slug VARCHAR(50) NOT NULL, INDEX IDX_140AB6205DA0FB8 (template_id), INDEX IDX_140AB6209D32F035 (action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, slug VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, title VARCHAR(100) DEFAULT NULL, content LONGTEXT DEFAULT NULL, image VARCHAR(100) DEFAULT NULL, INDEX IDX_23A0E66C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image_article ADD CONSTRAINT FK_972A59BA3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_article ADD CONSTRAINT FK_972A59BA7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB6205DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB6208D0C9323 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB6205DA0FB8');
        $this->addSql('ALTER TABLE image_article DROP FOREIGN KEY FK_972A59BA3DA5256D');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66C4663E4');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB6208D0C9323');
        $this->addSql('ALTER TABLE image_article DROP FOREIGN KEY FK_972A59BA7294869C');
        $this->addSql('DROP TABLE template');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE image_article');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE article');
    }
}
