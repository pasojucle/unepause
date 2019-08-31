<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190829164325 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, route VARCHAR(50) DEFAULT NULL, param VARCHAR(50) DEFAULT NULL, INDEX IDX_47CC8C92727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92727ACA70 FOREIGN KEY (parent_id) REFERENCES action (id)');
        $actions = [
            ['id' => 1,
                'name' => 'Accueil',
                'route' => 'home',
                'param' => null,
                'parent' => null,
            ],
            ['id' => 2,
                'name' => 'Deep tissue',
                'route' => null,
                'param' => null,
                'parent' => null,
            ],
            ['id' => 3,
                'name' => 'En quoi ça consiste',
                'route' => 'massage',
                'param' => 'about',
                'parent' => 2,
            ],
            ['id' => 4,
                'name' => 'Pour qui ?',
                'route' => 'massage',
                'param' => 'target',
                'parent' => 2,
            ],
            ['id' => 5,
                'name' => 'Pourquoi ?',
                'route' => 'massage',
                'param' => 'reason',
                'parent' => 2,
            ],
            ['id' => 6,
                'name' => 'Durée et fréquence',
                'route' => 'massage',
                'param' => 'recommendations',
                'parent' => 2,
            ],
            ['id' => 7,
                'name' => 'Contre-indications',
                'route' => 'massage',
                'param' => 'cons-indications',
                'parent' => 2,
            ],
            ['id' => 8,
                'name' => 'Pratique',
                'route' => 'practice',
                'param' => null,
                'parent' => null,
            ],
            ['id' => 9,
                'name' => 'Tarifs',
                'route' => 'prices',
                'param' => null,
                'parent' => null,
            ],

            ['id' => 10,
                'name' => 'Réserver',
                'route' => 'booking',
                'param' => null,
                'parent' => null,
            ],
            ['id' => 11,
                'name' => 'Carte cadeau',
                'route' => 'giftcard',
                'param' => null,
                'parent' => null,
            ],
            ['id' => 12,
                'name' => 'Contact',
                'route' => 'contact',
                'param' => null,
                'parent' => null,
            ],
        ];
        foreach($actions as $action) {
            $this->addSql('INSERT INTO action (id, name, route, param, parent_id) VALUES (:id, :name, :route, :param, :parent)', $action);
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92727ACA70');
        $this->addSql('DROP TABLE action');
    }
}
