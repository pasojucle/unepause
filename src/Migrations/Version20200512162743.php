<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512162743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page_content_family (page_content_id INT NOT NULL, family_id INT NOT NULL, INDEX IDX_7C4A62A38F409273 (page_content_id), INDEX IDX_7C4A62A3C35E566A (family_id), PRIMARY KEY(page_content_id, family_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_content_family ADD CONSTRAINT FK_7C4A62A38F409273 FOREIGN KEY (page_content_id) REFERENCES page_content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_content_family ADD CONSTRAINT FK_7C4A62A3C35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
        $familyPageContainerList = $this->connection->fetchAll('SELECT * FROM family_page_container');
        if (!empty($familyPageContainerList)) {
            foreach ($familyPageContainerList as $familyPageContainer) {
                $this->addSql('BEGIN');
                $this->addSql('INSERT INTO `page_content`(`page_container_id`, `order_by`) VALUES (:page_container_id, 1)', $familyPageContainer);
                $this->addSql('INSERT INTO `page_content_family`(`family_id`, `page_content_id`) VALUES (:family_id, LAST_INSERT_ID())', $familyPageContainer);
                $this->addSql('COMMIT');
           }
        }

        $this->addSql('DROP TABLE family_page_container');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE family_page_container (family_id INT NOT NULL, page_container_id INT NOT NULL, INDEX IDX_CE1A36A5C35E566A (family_id), INDEX IDX_CE1A36A523D5B0C (page_container_id), PRIMARY KEY(family_id, page_container_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE family_page_container ADD CONSTRAINT FK_CE1A36A523D5B0C FOREIGN KEY (page_container_id) REFERENCES page_container (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_page_container ADD CONSTRAINT FK_CE1A36A5C35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
        $familyPageContentList = $this->connection->fetchAll('SELECT * FROM family_page_content AS a INNER JOIN page_content AS B ON B.id = A.page_content_id');
        if (!empty($familyPageContentList)) {
            foreach ($familyPageContentList as $familyPageContent) {
                $this->addSql('BEGIN');
                $this->addSql('DELETE FROM `page_content`WHERE `id` = :page_container_id)', $familyPageContent);
                $this->addSql('INSERT INTO `page_container_family`(`family_id`, `page_container_id`) VALUES (:family_id, :page_container_id)', $familyPageContent);
                $this->addSql('COMMIT');
           }
        }
        
        $this->addSql('DROP TABLE page_content_family');
    }
}
