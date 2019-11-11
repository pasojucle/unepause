<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191109190113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_image (product_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_64617F034584665A (product_id), INDEX IDX_64617F033DA5256D (image_id), PRIMARY KEY(product_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F033DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD content LONGTEXT NOT NULL, ADD order_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B8F409273');
        $this->addSql('DROP INDEX IDX_A5E6215B8F409273 ON family');
        $this->addSql('ALTER TABLE family ADD page_container_id INT DEFAULT NULL, DROP page_content_id');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B23D5B0C FOREIGN KEY (page_container_id) REFERENCES page_container (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B23D5B0C ON family (page_container_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE product_image');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B23D5B0C');
        $this->addSql('DROP INDEX IDX_A5E6215B23D5B0C ON family');
        $this->addSql('ALTER TABLE family ADD page_content_id INT DEFAULT NULL, DROP page_container_id');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B8F409273 FOREIGN KEY (page_content_id) REFERENCES page_content (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B8F409273 ON family (page_content_id)');
        $this->addSql('ALTER TABLE product DROP content, DROP order_by');
    }
}
