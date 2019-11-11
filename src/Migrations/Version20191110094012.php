<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191110094012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE family_page_container (family_id INT NOT NULL, page_container_id INT NOT NULL, INDEX IDX_CE1A36A5C35E566A (family_id), INDEX IDX_CE1A36A523D5B0C (page_container_id), PRIMARY KEY(family_id, page_container_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE family_page_container ADD CONSTRAINT FK_CE1A36A5C35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_page_container ADD CONSTRAINT FK_CE1A36A523D5B0C FOREIGN KEY (page_container_id) REFERENCES page_container (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B23D5B0C');
        $this->addSql('DROP INDEX IDX_A5E6215B23D5B0C ON family');
        $this->addSql('ALTER TABLE family DROP page_container_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE family_page_container');
        $this->addSql('ALTER TABLE family ADD page_container_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B23D5B0C FOREIGN KEY (page_container_id) REFERENCES page_container (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B23D5B0C ON family (page_container_id)');
    }
}
