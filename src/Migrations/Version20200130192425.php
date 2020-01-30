<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200130192425 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE19FCD424');
        $this->addSql('CREATE TABLE date_line (id INT AUTO_INCREMENT NOT NULL, date_header_id INT NOT NULL, date DATETIME NOT NULL, max_quantity INT NOT NULL, INDEX IDX_F1CA3D02118F2C6C (date_header_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date_header (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, unit_id INT NOT NULL, max_quantity INT DEFAULT NULL, INDEX IDX_8AC697224584665A (product_id), INDEX IDX_8AC69722F8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE date_line ADD CONSTRAINT FK_F1CA3D02118F2C6C FOREIGN KEY (date_header_id) REFERENCES date_header (id)');
        $this->addSql('ALTER TABLE date_header ADD CONSTRAINT FK_8AC697224584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE date_header ADD CONSTRAINT FK_8AC69722F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('DROP TABLE time_line');
        $this->addSql('DROP INDEX IDX_E00CEDDE19FCD424 ON booking');
        $this->addSql('ALTER TABLE booking DROP time_line_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE date_line DROP FOREIGN KEY FK_F1CA3D02118F2C6C');
        $this->addSql('CREATE TABLE time_line (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, unit_id INT DEFAULT NULL, day DATETIME NOT NULL, max_quantity INT NOT NULL, INDEX IDX_7CA9BDDBF8BD700D (unit_id), INDEX IDX_7CA9BDDB4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE time_line ADD CONSTRAINT FK_7CA9BDDB4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE time_line ADD CONSTRAINT FK_7CA9BDDBF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('DROP TABLE date_line');
        $this->addSql('DROP TABLE date_header');
        $this->addSql('ALTER TABLE booking ADD time_line_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE19FCD424 FOREIGN KEY (time_line_id) REFERENCES time_line (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE19FCD424 ON booking (time_line_id)');
    }
}
