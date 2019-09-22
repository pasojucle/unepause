<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190906195252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, label VARCHAR(50) NOT NULL, INDEX IDX_D34A04ADC35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_A5E6215B7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, unit_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_CAC822D94584665A (product_id), INDEX IDX_CAC822D9F8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADC35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D94584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D9F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE article DROP image');

        $articles = [
            [
                'id' => 9,
                'title' => "Tarifs au 1er août 2019",
                'content' => '<p>* Offre valable dans un délais de 12 mois dès l&apos;acquisition du forfait</p><p>TVA non applicable, article 293B du code général des impôts.<br>Paiement par carte banquaire, virement, chèque ou espèces.</p>',
                'pageId' => 8,
            ],
        ];

        foreach($articles as $article) {
            $this->addSql('INSERT INTO article (id, title, content, page_id) VALUES (:id, :title, :content, :pageId)', $article);
        }

        $families = [
            [
                'id' => 1,
                'name' => 'Massage deep tissue personnalisé',
                'articleId' => 9,
            ],
        ];
        foreach($families as $family) {
            $this->addSql('INSERT INTO family (id, name, article_id) VALUES (:id, :name, :articleId)', $family);
        }

        $units = [
            [
                'id' => 1,
                'label' => '60 min',
            ],
            [
                'id' => 2,
                'label' => '90 min',
            ],
        ];
        foreach($units as $unit) {
            $this->addSql('INSERT INTO unit (id, label) VALUES (:id, :label)', $unit);
        }

        $products = [
            [
                'id' => 1,
                'label' => '1 massage',
                'familyId' => 1,
            ],
            [
                'id' => 2,
                'label' => 'Forfait régularité (5 massages)*',
                'familyId' => 1,
            ],
            [
                'id' => 3,
                'label' => 'Supplément huiles essentielles',
                'familyId' => 1,
            ],
        ];
        foreach($products as $product) {
            $this->addSql('INSERT INTO product (id, label, family_id) VALUES (:id, :label, :familyId)', $product);
        }

        $prices = [
            [
                'amount' => (float)50,
                'unitId' => 1,
                'productId' => 1,
            ],
            [
                'amount' => (float)75,
                'unitId' => 2,
                'productId' => 1,
            ],
            [
                'amount' => (float)225,
                'unitId' => 1,
                'productId' => 2,
            ],
            [
                'amount' => (float)350,
                'unitId' => 2,
                'productId' => 2,
            ],
            [
                'amount' => (float)5,
                'unitId' => 1,
                'productId' => 3,
            ],
            [
                'amount' => (float)5,
                'unitId' => 2,
                'productId' => 3,
            ],
        ];
        foreach($prices as $price) {
            $this->addSql('INSERT INTO price (amount, unit_id, product_id) VALUES (:amount, :unitId, :productId)', $price);
        }
        $images = [
            [
                'id' => 5,
                'title' => 'massage pression ferme',
                'filename' => 'massage-pression-ferme.jpg',
            ],
        ];
        foreach($images as $image) {
            $this->addSql('INSERT INTO image (id, title, filename) VALUES (:id, :title, :filename)', $image);
        }

        $imageArticleListe = [
            [   'image_id' => 5,
                'article_id' => 9,
            ],
        ];
        foreach($imageArticleListe as $imageArticle) {
            $this->addSql('INSERT INTO image_article (image_id, article_id) VALUES (:image_id, :article_id)', $imageArticle);
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D94584665A');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D9F8BD700D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADC35E566A');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE price');
        $this->addSql('ALTER TABLE article ADD image VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
