<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190914144953 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE container (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, tag_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_container (action_id INT NOT NULL, container_id INT NOT NULL, INDEX IDX_63A4FF069D32F035 (action_id), INDEX IDX_63A4FF06BC21F742 (container_id), PRIMARY KEY(action_id, container_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_container ADD CONSTRAINT FK_63A4FF069D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_container ADD CONSTRAINT FK_63A4FF06BC21F742 FOREIGN KEY (container_id) REFERENCES container (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action_container DROP FOREIGN KEY FK_63A4FF06BC21F742');
        $this->addSql('DROP TABLE container');
        $this->addSql('DROP TABLE action_container');
    }
}
