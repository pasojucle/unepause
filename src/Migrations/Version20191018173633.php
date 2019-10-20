<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191018173633 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_container ADD container_id INT NOT NULL, ADD page_id INT NOT NULL, DROP name, DROP tag_name');
        $this->addSql('ALTER TABLE page_container ADD CONSTRAINT FK_FC4C53D4BC21F742 FOREIGN KEY (container_id) REFERENCES container (id)');
        $this->addSql('ALTER TABLE page_container ADD CONSTRAINT FK_FC4C53D4C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_FC4C53D4BC21F742 ON page_container (container_id)');
        $this->addSql('CREATE INDEX IDX_FC4C53D4C4663E4 ON page_container (page_id)');
        $this->addSql('ALTER TABLE template CHANGE filename filename VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE page_content ADD CONSTRAINT FK_4A5DB3CC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        
        $pagesContainer = $this->connection->fetchAll('select * FROM page_content');
        foreach ($pagesContainer as $pageContainer) {
            $this->addSql('INSERT INTO `page_container`(id, `container_id`, `page_id`) VALUES (:id, :page_container_id, :page_id)', $pageContainer);
            $this->addSql('UPDATE page_content SET page_container_id = id');
        }
        $this->addSql('ALTER TABLE page_content ADD CONSTRAINT FK_4A5DB3C23D5B0C FOREIGN KEY (page_container_id) REFERENCES page_container (id)');
        $this->addSql('CREATE INDEX IDX_4A5DB3C23D5B0C ON page_content (page_container_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_container DROP FOREIGN KEY FK_FC4C53D4BC21F742');
        $this->addSql('ALTER TABLE page_container DROP FOREIGN KEY FK_FC4C53D4C4663E4');

        $pagesContainer = $this->connection->fetchAll('select * FROM page_container');
        foreach ($pagesContainer as $pageContainer) {
            $this->addSql('UPDATE `page_container` SET `page_container_id`=:container_id, `page_id`= :page_id)', $pageContainer);
        }
        $this->addSql('DROP INDEX IDX_FC4C53D4BC21F742 ON page_container');
        $this->addSql('DROP INDEX IDX_FC4C53D4C4663E4 ON page_container');
        $this->addSql('ALTER TABLE page_container ADD name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, ADD tag_name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, DROP container_id, DROP page_id');
        $this->addSql('ALTER TABLE page_content DROP FOREIGN KEY FK_4A5DB3CC4663E4');
        $this->addSql('ALTER TABLE page_content DROP FOREIGN KEY FK_4A5DB3C23D5B0C');
        $this->addSql('DROP INDEX IDX_4A5DB3C23D5B0C ON page_content');
        $this->addSql('ALTER TABLE template CHANGE filename filename VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
