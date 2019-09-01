<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Ver extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, filename VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_article (image_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_972A59BA3DA5256D (image_id), INDEX IDX_972A59BA7294869C (article_id), PRIMARY KEY(image_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image_article ADD CONSTRAINT FK_972A59BA3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_article ADD CONSTRAINT FK_972A59BA7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
    
        $images = [
            ['id' =>1,
                'title' => 'massage dos',
                'filename' => 'massage-dos.jpg',
            ],
            ['id' =>2,
                'title' => 'massage épaule',
                'filename' => 'massage-epaule.jpg',
            ],
            ['id' =>3,
                'title' => 'deep tissue',
                'filename' => 'deep-tissue.jpg',
            ],
            ['id' =>4,
                'title' => 'beurre de karté',
                'filename' => 'beurre-de-karite.jpg',
            ],
        ];
        foreach($images as $image) {
            $this->addSql('INSERT INTO image (id, title, filename) VALUES (:id, :title, :filename)', $image);
        }

        $imageArticleListe = [
            [   'image_id' => 3,
                'article_id' => 1,
            ],
            [   'image_id' => 3,
                'article_id' => 2,
            ],
            [   'image_id' => 3,
                'article_id' => 3,
            ],
            [   'image_id' => 3,
                'article_id' => 4,
            ],
            [   'image_id' => 3,
                'article_id' => 5,
            ],
            [   'image_id' => 4,
                'article_id' => 6,
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

        $this->addSql('ALTER TABLE image_article DROP FOREIGN KEY FK_972A59BA3DA5256D');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE image_article');
    }
}
