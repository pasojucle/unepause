<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191103092421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_container ADD title VARCHAR(50) DEFAULT NULL, ADD footer LONGTEXT DEFAULT NULL');
        $this->addSql('UPDATE `page_container` as c inner join page_content as d ON c.id = d.page_container_id SET c.title = d.title Where d.type_id = 1');
        $this->addSql('UPDATE `page_container` as c inner join page_content as d ON c.id = d.page_container_id SET c.footer = d.content Where d.type_id = 3');
        $this->addSql('DELETE FROM `page_content` WHERE type_id=1 or type_id=3');
    }


    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_container DROP title, DROP footer');
    }
}
