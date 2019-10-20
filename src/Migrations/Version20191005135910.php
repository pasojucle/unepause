<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191005135910 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, parameters VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addsql('INSERT INTO route (id, name, parameters)  SELECT t.id, t.route, t.route_parameters FROM template as t');       
        $this->addSql('ALTER TABLE template ADD route_id INT DEFAULT NULL, ADD filename VARCHAR(50) DEFAULT NULL, DROP route, DROP route_parameters');
        $this->addsql('UPDATE template SET route_id = id');       
        $this->addSql('ALTER TABLE template ADD CONSTRAINT FK_97601F8334ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('CREATE INDEX IDX_97601F8334ECB4E6 ON template (route_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE template DROP FOREIGN KEY FK_97601F8334ECB4E6');
        $this->addSql('DROP INDEX IDX_97601F8334ECB4E6 ON template');
        $this->addSql('ALTER TABLE template ADD route VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD route_parameters LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP route_id, DROP filename');
        $this->addsql('UPDATE template  as t, route as r SET t.route = r.name, t.route_parameters = r.parameters WHERE t.id = r.id');       
        $this->addSql('DROP TABLE route');
    }
}
