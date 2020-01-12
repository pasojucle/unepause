<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200112110316 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, time_line_id INT DEFAULT NULL, quantity INT DEFAULT 1 NOT NULL, comments LONGTEXT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), INDEX IDX_E00CEDDE4584665A (product_id), INDEX IDX_E00CEDDE19FCD424 (time_line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_image (product_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_64617F034584665A (product_id), INDEX IDX_64617F033DA5256D (image_id), PRIMARY KEY(product_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_page_container (family_id INT NOT NULL, page_container_id INT NOT NULL, INDEX IDX_CE1A36A5C35E566A (family_id), INDEX IDX_CE1A36A523D5B0C (page_container_id), PRIMARY KEY(family_id, page_container_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, phone VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_line (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, unit_id INT DEFAULT NULL, day DATETIME NOT NULL, max_quantity INT NOT NULL, INDEX IDX_7CA9BDDB4584665A (product_id), INDEX IDX_7CA9BDDBF8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE19FCD424 FOREIGN KEY (time_line_id) REFERENCES time_line (id)');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F033DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_page_container ADD CONSTRAINT FK_CE1A36A5C35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_page_container ADD CONSTRAINT FK_CE1A36A523D5B0C FOREIGN KEY (page_container_id) REFERENCES page_container (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE time_line ADD CONSTRAINT FK_7CA9BDDB4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE time_line ADD CONSTRAINT FK_7CA9BDDBF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE product ADD content LONGTEXT NOT NULL, ADD order_by INT DEFAULT NULL, ADD is_generic TINYINT(1) DEFAULT \'0\' NOT NULL, ADD type INT DEFAULT 1 NOT NULL, CHANGE label title VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE unit ADD duration INT DEFAULT NULL');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B8F409273');
        $this->addSql('DROP INDEX IDX_A5E6215B8F409273 ON family');
        $this->addSql('ALTER TABLE family ADD parent_id INT DEFAULT NULL, ADD has_uniques_prices TINYINT(1) DEFAULT \'0\' NOT NULL, ADD has_seasonal_products TINYINT(1) DEFAULT \'0\' NOT NULL, DROP page_content_id');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B727ACA70 FOREIGN KEY (parent_id) REFERENCES family (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B727ACA70 ON family (parent_id)');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F123D5B0C');
        $this->addSql('DROP INDEX IDX_36AC99F123D5B0C ON link');
        $this->addSql('ALTER TABLE link ADD url VARCHAR(255) DEFAULT NULL, DROP page_container_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE19FCD424');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE family_page_container');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE time_line');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B727ACA70');
        $this->addSql('DROP INDEX IDX_A5E6215B727ACA70 ON family');
        $this->addSql('ALTER TABLE family ADD page_content_id INT NOT NULL, DROP parent_id, DROP has_uniques_prices, DROP has_seasonal_products');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B8F409273 FOREIGN KEY (page_content_id) REFERENCES page_content (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B8F409273 ON family (page_content_id)');
        $this->addSql('ALTER TABLE link ADD page_container_id INT DEFAULT NULL, DROP url');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F123D5B0C FOREIGN KEY (page_container_id) REFERENCES page_container (id)');
        $this->addSql('CREATE INDEX IDX_36AC99F123D5B0C ON link (page_container_id)');
        $this->addSql('ALTER TABLE product DROP content, DROP order_by, DROP is_generic, DROP type, CHANGE title label VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE unit DROP duration');
    }
}
